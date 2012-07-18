<?php
class SoDetailController extends AppController {
	var $name = 'SoDetail';
	var $helpers = array('Html','Javascript', 'Form');
	
// Ajax Call
	function searchSoDetailBySoId() {
		$so_id = $this->params['url']['so_id'];
		/*$data = $this->SoDetail->find('all', 
							array('conditions' => array('sell_order_id' => $so_id))
							);*/
		$data = $this->SoDetail->find(
							array('sell_order_id' => $so_id)
							);

		$this->data = array('SoDetail' => $data);
		$this->layout = 'blank';
		$this->viewPath = 'elements'.DS.'so_detail'; 
        $this->render('so_detail_list');
	}
}
?>