<?php
class Invoice extends AppModel {
	var $name = 'Invoice';
	var $useTable = 'invoice';
	
	// Constants
	const AR_STS_UNSETTLE = "U";
	const AR_STS_SETTLE = "S";
	
	var $belongsTo = array(
		'So' => array(
			'className'  => 'So',
			'foreignKey' => 'sell_order_id'
			),
		'Customer' => array(
			'className'  => 'Customer',
			'foreignKey' => 'cust_id'
		)
	);

	var $hasMany = array('InvoiceDetail' => array(
		'className'  => 'InvoiceDetail',
		'foreignKey' => 'inv_id')
	);
	
	var $validate = array(
		'cust_cd' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'message' => 'Required'
		),
		'cust_id' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'message' => 'Required'
		)
	);
	
	function bindModelForSearch() {
		$this->bindModel(array(
		    'hasOne' => array(
		        'InvoiceDetail' => array(
		            'foreignKey' => false,
		            'conditions' => array('Invoice.id = InvoiceDetail.inv_id')
		        )
		    ),
		    'belongsTo' => array(
		    	'Customer' => array(
					'foreignKey' => false,
		            'conditions' => array('Customer.id = Invoice.cust_id')
				)
			)
		));
	}
	
	/**
	 * Settle active invoice
	 * @param $custCd String customer code
	 * @param $arAmt float amount for settle
	 * @param $excludeInvId integer invoice to be exculded
	 */
	function settleInvoice($custCd, $arAmt, $excludeInvId) {
		$invoices = $this->find('all', array('conditions'=>array('ar_sts'=>self::AR_STS_UNSETTLE, 
																'cust_cd'=>$custCd,
																'NOT'=>array('id'=>$excludeInvId)),
											'order'=>'Invoice.id', 'recursive' => -1));
		
		// Begin to settle invoice
		foreach($invoices as $value) {
			$invoice = $value['Invoice'];
			$invoice_remain_amt = $invoice['total_amt'] - $invoice['ar_settle_amt'];
			if ($invoice_remain_amt >= $arAmt) {
				// Partly settle
				$invoice['ar_settle_amt'] = $invoice['ar_settle_amt'] + $arAmt;
				$this->save($invoice, false, array("ar_settle_amt"));
				
				$arAmt = 0;
				break;
			}
			else {
				// Fully settle
				$arAmt = $arAmt - $invoice_remain_amt;
				$invoice['ar_settle_amt'] = $invoice['total_amt'];
				$invoice['ar_sts'] = self::AR_STS_SETTLE;
				$this->save($invoice, false, array("ar_settle_amt", "ar_sts"));
			}
		}
		
		return $arAmt; // return remaing amount
	}
	
	/**
	 * Unsettle the invcoies which amount has ever been settled
	 * 
	 * @param $custCd String customer code
	 * @param $arAmt float amount to unsettle from invoice
	 */
	function unsettleInvoice($custCd, $arAmt, $cutOffInvId) {
		$invoices = $this->find('all', array('conditions'=>array('NOT' => array('ar_settle_amt'=>0), 
																'cust_cd'=>$custCd,
																'id >'=>$cutOffInvId),
											'order'=>'id desc', 'recursive' => -1));
		
		// Begin to settle invoice
		foreach($invoices as $key=>$value) {
			$invoice = $value['Invoice'];
			$invoice_settle_amt = $invoice['ar_settle_amt'];
			if ($invoice_settle_amt > $arAmt) {
				// Partly unsettle
				$invoice['ar_settle_amt'] = $invoice['ar_settle_amt'] - $arAmt;
				$invoice['ar_sts'] = self::AR_STS_UNSETTLE;
				$this->save($invoice, false, array("ar_settle_amt", "ar_sts"));
				
				$arAmt = 0;
				break;
			}
			else {
				// Fully unsettle
				$arAmt = $arAmt - $invoice_settle_amt;
				$invoice['ar_settle_amt'] = 0;
				$invoice['ar_sts'] = self::AR_STS_UNSETTLE;
				$this->save($invoice, false, array("ar_settle_amt", "ar_sts"));
			}
		}
		
		return $arAmt; // return remaing amount
	}
}
?>