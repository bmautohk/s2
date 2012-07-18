<?php
class So extends AppModel {
	var $name = 'So';
	var $useTable = 'so';
	
	const STS_PENDING = "P";
	const STS_COMPLETE = "C";
	
	var $belongsTo = array('Customer' => array(
		'className'  => 'Customer',
		'foreignKey' => 'cust_id'
		)
	);
	
	var $hasMany = array('SoDetail' => array(
		'className'  => 'SoDetail',
		'foreignKey' => 'sell_order_id')
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
		        'SoDetail' => array(
		            'foreignKey' => false,
		            'conditions' => array('So.id = SoDetail.sell_order_id')
		        )
		    ),
		    'belongsTo' => array(
		    	'Customer' => array(
					'foreignKey' => false,
		            'conditions' => array('Customer.id = So.cust_id')
				)
			)
		));
	}
	
	function completeSO($id) {
		$soDetailModel = ClassRegistry::init('SoDetail');
		$detail = $soDetailModel->find(array("sell_order_id"=>$id, "sts"=>"P"), NULL, NULL, -1);
		
		$so["id"] = $id;
		if (empty($detail)) {
			// Complete SO
			$so["sts"] = "C";
		}
		else {
			$so["sts"] = "P";
		}
		$this->save($so, false, array("sts"));
	}
}
?>
