<?php
class ArByCust extends AppModel {
	var $name = 'ArByCust';
	var $useTable = 'ar_by_cust';
	
	// Constants
	const STS_ACTIVE = "A";
	const STS_INACTIVE = "I";
	
	var $validate = array(
		'cust_cd' => array(
			'rule1' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'Required',
				'last' => true),
			'rule2' => array(
				'rule' => 'checkCustCdExist',
				'required' => true,
				'message' => 'Not exists')),
		'settle_date' => array(
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
	
	function checkCustCdExist($check) {
		$id = reset($check); // Get 1st element
		$count = ClassRegistry::init('Customer')->find('count', array('conditions' => array('cust_cd'=>$id), 'recursive' => -1));
		if ($count == 0) {
			return false;
		}
		else {
			return true;
		}
	}
	
	/**
	 * Active AR settle invoice
	 * 
	 * @param $custCd String
	 * @param $invAmt Float amount needed to settle
	 */
	function allocateAR($custCd, $invAmt) {
		$arList = $this->find('all', array('conditions'=>array('sts'=>'A', 
																'cust_cd'=>$custCd),
													 'order'=>'id', 'recursive' => -1));
		foreach($arList as $value) {
			$ar = $value["ArByCust"];
			$arRemainAmt = $ar["amt"] - $ar["settle_amt"];
			
			if ($arRemainAmt > $invAmt) {
				$ar["settle_amt"] = $ar["settle_amt"] + $invAmt;
				$data["ArByCust"] = $ar;
				$this->save($data, false, array("settle_amt"));
				$invAmt = 0;
				break;
			}
			else {
				$ar["sts"] = "I";
				$ar["settle_amt"] = $ar["amt"];
				$data["ArByCust"] = $ar;
				$this->save($data, false, array("sts", "settle_amt"));
				$invAmt = $invAmt - $arRemainAmt;
			}
		}
		
		return $invAmt; // non-settle invoice amount
	}
	
	function unallocateAR($custCd, $unallocAmt) {
		if ($unallocAmt > 0) {
			// Reallocate to AR
			$arList = $this->find('all', array('conditions'=>array('cust_cd'=>$custCd, 'settle_amt >'=> 0),
													 'order'=>'id desc', 'recursive' => -1));
			
			foreach($arList as $value) {
				$ar = $value["ArByCust"];
				if ($ar["settle_amt"] > $unallocAmt) {
					$ar["settle_amt"] = $ar["settle_amt"] - $unallocAmt;
					$ar["sts"] = ArByCust::STS_ACTIVE;
					$this->save($ar, false, array("settle_amt", "sts"));
					break;
				}
				else {
					$unallocAmt = $unallocAmt - $ar["settle_amt"];
					$ar["settle_amt"] = 0;
					$ar["sts"] = ArByCust::STS_ACTIVE;
					$this->save($ar, false, array("settle_amt", "sts"));
				}
			}
		}
	}
}
?>
