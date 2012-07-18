<?php
class Po extends AppModel {
	var $name = 'Po';
	var $useTable = 'po';
	
	// Constants
	const AP_STS_UNSETTLE = "U";
	const AP_STS_SETTLE = "S";

	var $hasMany = array('PoDetail' => array(
		'className'  => 'PoDetail',
		'foreignKey' => 'po_id')
	);
	
	var $belongsTo = array(
		'So' => array(
			'className' => 'So',
			'foreignKey' => 'sell_order_id',
			'associationForeignKey' => 'id'
			)
		); 
	
	function savePoFromSo($formData) {
		$so = $formData['So'];
		
		$apList = array();
		
	$this->begin();
		foreach ($formData['SoDetail'] as $index => $soDetail) {
			$supplierCd = $soDetail['supplier_cd'];
			$subtotal = $soDetail['qty'] * $soDetail['cost'];
			
			// PO header
			if (!isset($tmpPo[$supplierCd])) {
				$tmpPo[$supplierCd]['Po']['sell_order_id'] = $so['id'];
				$tmpPo[$supplierCd]['Po']['supplier_cd'] = $supplierCd;
				$tmpPo[$supplierCd]['Po']['po_date'] = $so['so_date'];
				$tmpPo[$supplierCd]['Po']['total_amt'] = $subtotal;
				$tmpPo[$supplierCd]['Po']['count'] = 0;
			}
			else {
				$tmpPo[$supplierCd]['Po']['total_amt'] += $subtotal;
				$tmpPo[$supplierCd]['Po']['count']++;
			}
			
			$count = $tmpPo[$supplierCd]['Po']['count'];
			
			// PO detail
			$tmpPo[$supplierCd]['PoDetail'][$count] = $soDetail;
			$tmpPo[$supplierCd]['PoDetail'][$count]['id'] = NULL;
			$tmpPo[$supplierCd]['PoDetail'][$count]['subtotal'] = $subtotal;
		}
		
		$apToSuppModel = ClassRegistry::init('ApToSupp');
		
		// Create / Update PO header
		$result = $this->find('all',
							array(
								'conditions'=>array('sell_order_id'=>$formData['So']['id']),
								'fields'=>array('id', 'supplier_cd'),
								'recursive' => 1
							)
						);

		if ($result != NULL) {
			foreach ($result as $value) {
				$po = $value['Po'];
				
				// Log the removed PO detail
				$removeList = ClassRegistry::init('PoDetail')->find('all',
													array('conditions' => array('po_id'=>$po['id']))
												);
				$poDetailLogModel = ClassRegistry::init('PoDetailLog');
				foreach ($removeList as $value2) {
					$data['PoDetailLog'] = $value2['PoDetail'];
					$data['PoDetailLog']['delete_date'] = DboSource::expression('NOW()');
					$data['PoDetailLog']['delete_by'] = 'Tester';
					if (!$poDetailLogModel->save($data)) {
						$this->rollback();
						return false;
					}
				}
				
				// Remove PO detail
				ClassRegistry::init('PoDetail')->deleteAll(array('po_id'=>$po['id']));
				
				$supplierCd = $po['supplier_cd'];
				if (isset($tmpPo[$supplierCd])) {
					// Update PO
					$data['Po']['id'] = $po['id'];
					$data['Po']['total_amt'] = $tmpPo[$supplierCd]['Po']['total_amt'];
					$data['Po']['last_update_by'] = 'Tester';
					$data['Po']['last_update_date'] = DboSource::expression('NOW()');
					
					$data['PoDetail'] = $tmpPo[$supplierCd]['PoDetail'];
				}
				else {
					// Clear PO
					$data['Po']['id'] = $po['id'];
					$data['Po']['total_amt'] = 0;
					$data['Po']['last_update_by'] = 'Tester';
					$data['Po']['last_update_date'] = DboSource::expression('NOW()');
				}
				
				// Reallocate AP
				// Retrieve original invoice
				$origPO = $this->find('first', array('conditions'=>array('id'=>$data['Po']['id']), 'recursive' => -1));
				$origPO = $origPO["Po"];

				if ($origPO["total_amt"] == $data["Po"]["total_amt"]) {
					// nothing to do
				}
				else if ($origPO["total_amt"] > $data["Po"]["total_amt"]) {
					// Old PO amount > New PO amount
					debug("Old PO Amt > New PO Amt");
					if ($origPO["ap_settle_amt"] >= $data["Po"]["total_amt"]) {
						$extraAP = $origPO["ap_settle_amt"] - $data["Po"]["total_amt"];
						$data["Po"]["ap_sts"] = self::AP_STS_SETTLE;
						$data["Po"]["ap_settle_amt"] = $data["Po"]["total_amt"];
						
						// Allocate extra AP amount to other PO
						$remainApAmt = $this->settlePO($origPO["supplier_cd"], $extraAP, $data['Po']['id']);
						if ($remainApAmt > 0) {
							debug("Allocate extra AP to other PO");
							$apToSuppModel->unallocateAP($origPO["supplier_cd"], $remainApAmt);
						}
					}
				}
				else {
					// New PO amount >= Old PO amount
					debug("New PO Amt >= Old PO Amt");
					if ($origPO["ap_sts"] == self::AP_STS_SETTLE) {
						debug("Settle PO");
						$remainPOAmt = $apToSuppModel->allocateAP($origPO["supplier_cd"], $data["Po"]["total_amt"] - $origPO["ap_settle_amt"]);
						
						if ($remainPOAmt > 0) {
							// Unsettle other PO
							$remainPOAmt = $this->unsettlePO($origPO["supplier_cd"], $remainPOAmt, $data['Po']['id']);
						}
						
						if ($remainPOAmt <= 0) {
							// Fully settle
							$data["Po"]["ap_sts"] = self::AP_STS_SETTLE;
							$data["Po"]["ap_settle_amt"] = $data["Po"]["total_amt"];
						}
						else {
							// Partly settle
							$data["Po"]["ap_sts"] = self::AP_STS_UNSETTLE;
							$data["Po"]["ap_settle_amt"] = $data["Po"]["total_amt"] - $remainPOAmt;
						}
					}
				}
	
				if (!$this->saveAll($data)) {
					$this->rollback();
					return false;
				}
				unset($data);
				unset($tmpPo[$supplierCd]);
			}
		}
		
		// Create PO
		foreach ($tmpPo as $po) {
			$po['Po']['create_by'] = 'Tester';
			$po['Po']['create_date'] = DboSource::expression('NOW()');
			$po['Po']['last_update_by'] = 'Tester';
			$po['Po']['last_update_date'] = DboSource::expression('NOW()');
			
			// Settle new created PO
			$poRemainAmt = $apToSuppModel->allocateAP($po['Po']['supplier_cd'], $po["Po"]["total_amt"]);
			$po["Po"]["ap_settle_amt"] = $po["Po"]["total_amt"] - $poRemainAmt;
			if ($po["Po"]["ap_settle_amt"]  >= $po["Po"]["total_amt"]) {
				$po["Po"]["ap_sts"] = self::AP_STS_SETTLE;
			}
			
			$data['Po'] = $po['Po'];
			$data['PoDetail'] = $po['PoDetail'];
			
			if (!$this->saveAll($data)) {
				$this->rollback();
				return false;
			}
			unset($data);
		}
		
	$this->commit();
		return true;
	}
	
// For AP
	function settlePO($supplierCd, $apAmt, $excludePoId) {
		// Find unsettle PO
		$pos = $this->find('all', array('conditions'=>array('ap_sts'=>self::AP_STS_UNSETTLE, 
																'supplier_cd'=>$supplierCd,
																'NOT'=>array('id'=>$excludePoId)),
													 'order'=>'Po.id', 'recursive' => -1));
		
		// Begin to settle PO
		foreach($pos as $value) {
			$po = $value['Po'];
			$po_remain_amt = $po['total_amt'] - $po['ap_settle_amt'];
			if ($po_remain_amt >= $apAmt) {
				// Partly settle
				$po['ap_settle_amt'] = $po['ap_settle_amt'] + $apAmt;
				$this->save($po, false, array("ap_settle_amt"));
				
				$apAmt = 0;
				break;
			}
			else {
				// Fully settle
				$apAmt = $apAmt - $po_remain_amt;
				$po['ap_settle_amt'] = $po['total_amt'];
				$po['ap_sts'] = self::AP_STS_SETTLE;
				$this->save($po, false, array("ap_settle_amt", "ap_sts"));
			}
		}
		
		return $apAmt; // return remaing amount
	}
	
	function unsettlePO($supplier_cd, $apAmt, $cutOffPoId) {
		// Find PO which has ever been settled
		$pos = $this->find('all', array('conditions'=>array('NOT' => array('ap_settle_amt'=>0), 
																'supplier_cd'=>$supplier_cd,
																'id >'=>$cutOffPoId),
											'order'=>'id desc', 'recursive' => -1));
		
		// Begin to settle PO
		foreach($pos as $value) {
			$po = $value['Po'];
			$po_settle_amt = $po['ap_settle_amt'];
			if ($po_settle_amt > $apAmt) {
				// Partly unsettle
				$po['ap_settle_amt'] = $po['ap_settle_amt'] - $apAmt;
				$po['ap_sts'] = self::AP_STS_UNSETTLE;
				$this->save($po, false, array("ap_settle_amt", "ap_sts"));
				
				$apAmt = 0;
				break;
			}
			else {
				// Fully unsettle
				$apAmt = $apAmt - $po_settle_amt;
				$po['ap_settle_amt'] = 0;
				$po['ap_sts'] = self::AP_STS_UNSETTLE;
				$this->save($po, false, array("ap_settle_amt", "ap_sts"));
			}
		}
		
		return $apAmt; // return remaing amount
	}
}
?>