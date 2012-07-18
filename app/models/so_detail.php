<?php
class SoDetail extends AppModel {
	var $name = 'SoDetail';
	var $useTable = 'so_detail';
	
	const STS_PENDING = "P";
	const STS_COMPLETE = "C";
	
	var $belongsTo = array(
		'Product' => array(
			'className'  => 'Product',
			'foreignKey' => 'prod_cd'
			)
	);
	
	var $validate = array(
		'qty' => array(
			'rule' => 'numeric',
			'required' => true,
			'message' => 'Qty - Invalid number'
		),
		'unit_price' => array(
			'rule' => 'numeric',
			'message' => 'Unti Prcie - Invalid number'
		),
		'cost' => array(
			'rule' => 'numeric',
			'message' => 'Cost - Invalid number'
		),
		'discount' => array(
			'rule' => 'numeric',
			'message' => 'Discount - Invalid number'
		),
		'supplier_cd' => array(
			'rule' => 'notEmpty',
			'message' => 'Supplier Code - Required'
		)
	);
}
?>
