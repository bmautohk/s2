<?
class PoDetail extends AppModel {
	var $name = 'PoDetail';
	var $useTable = 'po_detail';
	
	var $belongsTo = array('Product' => array(
		'className'  => 'Product',
		'foreignKey' => 'prod_cd'
		)
	);
}
?>