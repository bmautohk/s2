<?php
class ApToSupp extends AppModel {
	var $name = 'ApToSupp';
	var $useTable = 'ap_to_supp';
	
	// Constants
	const STS_ACTIVE = "A";
	const STS_INACTIVE = "I";
	
	var $validate = array(
		'supplier_cd' => array(
			'rule1' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'Required',
				'last' => true),
			'rule2' => array(
				'rule' => 'checkSupplierCdExist',
				'required' => true,
				'message' => 'Not exists')),
		'payment_date' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'message' => 'Required'),
		'cheque_no' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'message' => 'Required'),
		'amt' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'message' => 'Required'),
		'invoice_id' => array(
			'rule' => 'checkInvoiceExist',
			'allowEmpty' => true,
			'message' => 'Not exists'),
		'so_id' => array(
			'rule' => 'checkSoExist',
			'allowEmpty' => true,
			'message' => 'Not exists'),
		'po_id' => array(
			'rule' => 'checkPoExist',
			'allowEmpty' => true,
			'message' => 'Not exists')
	);
	
	function checkInvoiceExist($check) {
		$id = reset($check); // Get 1st element
		$count = ClassRegistry::init('Invoice')->find('count', array('conditions' => array('id'=>$id), 'recursive' => -1));
		if ($count == 0) {
			return false;
		}
		else {
			return true;
		}
	}
	
	function checkPoExist($check) {
		$id = reset($check); // Get 1st element
		$count = ClassRegistry::init('Po')->find('count', array('conditions' => array('id'=>$id), 'recursive' => -1));
		if ($count == 0) {
			return false;
		}
		else {
			return true;
		}
	}
	
	function checkSoExist($check) {
		$id = reset($check); // Get 1st element
		$count = ClassRegistry::init('So')->find('count', array('conditions' => array('id'=>$id), 'recursive' => -1));
		if ($count == 0) {
			return false;
		}
		else {
			return true;
		}
	}
	
	function checkSupplierCdExist($check) {
		$supplier_cd = reset($check); // Get 1st element
		$count = ClassRegistry::init('Supplier')->find('count', array('conditions' => array('supplier_cd'=>$supplier_cd), 'recursive' => -1));
		if ($count == 0) {
			return false;
		}
		else {
			return true;
		}
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param $supplierCd
	 * @param $poAmt
	 * @return unsettle amount
	 */
	function allocateAP($supplierCd, $poAmt) {
		// Find active AP
		$apToSuppList = $this->find('all', array('conditions' => array('supplier_cd'=>$supplierCd, 'sts'=>self::STS_ACTIVE),
												'order'=>array("id"),
												'recursive' => -1)
									);
		if ($apToSuppList) {
			// Exist AP not settle => settle PO
			$poAmt = $poAmt;
			foreach ($apToSuppList as $aps) {
				$ap = $aps["ApToSupp"];
				$apRemainAmt = $ap["amt"] - $ap["settle_amt"];
				if ($apRemainAmt > $poAmt) {
					// Fully settle PO
					$ap["settle_amt"] = $ap["settle_amt"] + $poAmt;
					$this->save($ap, false, array("settle_amt", "sts"));
					
					$poAmt = 0;
					break;
				}
				else {
					// Partly settle PO
					$poAmt = $poAmt - $apRemainAmt;
					$ap["settle_amt"] = $ap["amt"];
					$ap["sts"] = self::STS_INACTIVE;
					$this->save($ap, false, array("settle_amt", "sts"));
				}
				$this->save($ap, false, array("settle_amt", "sts"));
			}
		}
		
		return $poAmt;
	}
	
	// 
	function unallocateAP($supplierCd, $unallocAmt) {
		if ($unallocAmt > 0) {
			// Find 
			$list = $this->find('all', array('conditions'=>array('supplier_cd'=>$supplierCd, 'settle_amt >'=> 0),
													 'order'=>'id desc', 'recursive' => -1));
			
			foreach($list as $value) {
				$ap = $value["ApToSupp"];
				if ($ap["settle_amt"] > $unallocAmt) {
					$ap["settle_amt"] = $ap["settle_amt"] - $unallocAmt;
					$ap["sts"] = self::STS_ACTIVE;
					$this->save($ap, false, array("settle_amt", "sts"));
					break;
				}
				else {
					$unallocAmt = $unallocAmt - $ap["settle_amt"];
					$ap["settle_amt"] = 0;
					$ap["sts"] = self::STS_ACTIVE;
					$this->save($ap, false, array("settle_amt", "sts"));
				}
			}
		}
	}
}
?>