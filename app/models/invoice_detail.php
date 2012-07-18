<?php
class InvoiceDetail extends AppModel {
	var $name = 'InvoiceDetail';
	var $useTable = 'invoice_detail';
	
	var $validate = array(
		'qty' => array(
			'rule' => 'numeric',
			'required' => true,
			'message' => 'Qty - Invalid number'
		),
		'discount' => array(
			'rule' => 'numeric',
			'required' => true,
			'message' => 'Discount - Invalid number'
		),
		'unit_price' => array(
			'rule' => 'numeric',
			'required' => true,
			'message' => 'Unit price - Invalid number'
		)
	);
	
	var $belongsTo = array(
		'Product' => array(
			'className'  => 'Product',
			'foreignKey' => 'prod_cd'
		),
		'SoDetail' => array(
			'className'  => 'SoDetail',
			'foreignKey' => 'so_detail_id'
		)
	);
}
?>