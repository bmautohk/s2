<?php
class TestController extends AppController {
	var $name = 'Test';
	var $helpers = array('Html','Javascript', 'Form');
	
	function testQuery() {
		$model = ClassRegistry::init('Invoice');
		$model->bindModel(array(
		    'hasOne' => array(
		        'InvoiceDetail' => array(
		            'foreignKey' => false,
		            'conditions' => array('Invoice.id = InvoiceDetail.inv_id')
		        ),
		        'Customer' => array(
					'foreignKey' => false,
		            'conditions' => array('Customer.id = Invoice.cust_id')
				)
		    )
		));
		
		$result = $model->find('all', array(
		    'conditions' => array('Invoice.id' => 1),
		    'contain' => array('InvoiceDetail', 'Customer'),
		    'fields' => array('Invoice.*')
		));
		
		var_dump($result);
		$this->render('blank');
	}
	
	function patchAR() {
		$arByCustModel = ClassRegistry::init('ArByCust');
		$invoiceModel = ClassRegistry::init('Invoice');
		
		$arList = $arByCustModel->find('all', array('order'=>'id', 'recursive' => -1));
		
		foreach($arList as $value) {
			$ar = $value["ArByCust"];
			$arAmt = $invoiceModel->settleInvoice($ar['cust_cd'], $ar['amt'], 0);
			
			if ($arAmt <= 0) {
				// All amount are settled
				$ar['settle_amt'] = $ar['amt'];
				$ar['sts'] = ArByCust::STS_INACTIVE;
			}
			else {
				$ar['settle_amt'] = $ar['amt'] - $arAmt;
				$ar['sts'] = ArByCust::STS_ACTIVE;
			}
			
			$data['ArByCust'] = $ar;
			$arByCustModel->save($data, array('validate' => false));
		}
		
		$this->render('blank');
	}
	
	function patchAP() {
		$apToSuppModel = ClassRegistry::init('ApToSupp');
		$poModel = ClassRegistry::init('Po');
		
		$apList = $apToSuppModel->find('all', array('order'=>'id', 'recursive' => -1));
		
		foreach($apList as $value) {
			$ap = $value["ApToSupp"];
			$amt = $poModel->settlePo($ap['supplier_cd'], $ap['amt'], 0);
			
			if ($amt <= 0) {
				// All amount are settled
				$ap['settle_amt'] = $ap['amt'];
				$ap['sts'] = ApToSupp::STS_INACTIVE;
			}
			else {
				$ap['settle_amt'] = $ap['amt'] - $amt;
				$ap['sts'] = ApToSupp::STS_ACTIVE;
			}
			
			$data['ApToSupp'] = $ap;
			$apToSuppModel->save($data, array('validate' => false));
		}
		
		$this->render('blank');
	}
}
?>