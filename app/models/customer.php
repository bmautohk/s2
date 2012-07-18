<?php
class Customer extends AppModel {
	var $name = 'Customer';
	var $useTable = 'customer';
	
	var $validate = array(
		/*'cust_cd' => array(
			'rule1' => array(
				'rule' => 'isUnique',
				'message' => 'The cust code has already existed'),
			'rule2' => array(
			'rule' => 'notEmpty',
				'message' => 'Required')),*/
		'name' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'message' => 'Required'),
		'email' => array(
			'rule' => 'email',
			'allowEmpty' => true,
			'message' => 'Please enter valid email')
	);
	
	public function afterSave($created) {
		if ($created) {
			// Set cust_cd = id
			$this->saveField('cust_cd', $this->getLastInsertID());
		}
		
		return parent::afterSave($created);
	}
	
	function getCustomerDropDown() {
		if (($data = Cache::read('customer_dropdown_list', '1_hour')) == false) {
			$data = $this->find('list', array('fields'=>array('cust_cd', 'name'), 'order'=>'name'));
			Cache::write("customer_dropdown_list", $data, '1_hour');
		}
		return $data;
	}
}
?>
