<?php
class Supplier extends AppModel {
	var $name = 'Supplier';
	var $useTable = 'supplier';
	
	var $validate = array(
		'name' => array(
			'rule' => 'notEmpty', '
			required' => true,
			'message' => 'Required'),
		/*'supplier_cd' => array(
			'rule' => 'notEmpty', '
			required' => true,
			'message' => 'Required'),*/
		'email' => array(
			'rule' => 'email',
			'allowEmpty' => true,
			'message' => 'Please enter valid email')
	);
	
	public function afterSave($created) {
		if ($created) {
			// Set supplier_cd = id
			$this->saveField('supplier_cd', $this->getLastInsertID());
		}
		
		return parent::afterSave($created);
	}
	
	function getSupplierDropDown() {
		if (($data = Cache::read('supplier_dropdown_list', '1_hour')) == false) {
			$data = $this->find('list', array('fields'=>array('supplier_cd', 'name')));
			Cache::write("supplier_dropdown_list", $data, '1_hour');
		}
		return $data;
	}
}
?>
