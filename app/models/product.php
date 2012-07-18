<?php
class Product extends AppModel {
	var $name = 'Product';
	var $useTable = 'product';
	var $primaryKey = 'product_id';
	
	var $validate = array(
		'product_id' => array(
			'rule' => 'notEmpty', '
			required' => true,
			'message' => 'Required')
	);
}
?>
