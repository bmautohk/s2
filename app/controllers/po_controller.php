<?php
class PoController extends AppController {
	var $name = 'Po';
	var $helpers = array('Html','Javascript', 'Form');
	
	function view() {
		if (!empty($this->params['url']['id'])) {
			$id = $this->params['url']['id'];
			
			$this->Po->recursive = 2;
			$po = $this->Po->find(array('Po.id' => $id));
		}
		else {
			$po = null;
		}

		$this->data = $po;
		$this->layout = 'layout_1280';
	}
	
	function list_all() {
		// Supplier dropdown
		$this->set('supplierCdList', ClassRegistry::init('Supplier')->getSupplierDropDown());
		
		// List last 20 records
		$this->Po->recursive = 0;				
		$data = $this->Po->find('all', array(
										'limit' => 20,
										'offset' => 0,
										'order' => 'Po.po_date desc')
								);
		
		$paging = array(
			'pageCount' => 0,
			'page' => 1
		);
		$this->set('paging', $paging);
		$this->set('data', $data);
		
		$this->layout = 'search_form';
		$this->render('search');
	}
	
	function search() {
		$this->searchPO(false);
		
		$this->layout = 'blank';
		$this->viewPath = 'elements'.DS.'po'; 
        $this->render('paging');
	}
	
	function genCVS() {
		$this->searchPO(true);
		
		$this->layout = 'blank'; 
        $this->render('excel_file');
	}
	
	function searchPO($isCVS) {
		$url = $this->params['url'];
		$condition = array();
		$limit = Configure::read('page.limit');
		$paging = array(
			'pageCount' => 0,
			'page' => 1
		);
		
		$this->Po->recursive = 0;
		
		$supplierCd = $url['data']['supplier_cd'];
		/*if (empty($supplierCd)) {
			$this->set('paging', $paging);
			$this->set('data', array());
			
	        return;
		}*/
		
		if (!empty($supplierCd)) {
			$condition['Po.supplier_cd'] = $supplierCd;
			$paging['data[supplier_cd]'] = $supplierCd;
		}
		
		if (!empty($url['po_id'])) {
			$condition['Po.id'] = $url['po_id'];
			$paging['po_id'] = $url['po_id'];
		}
		
		if (!empty($this->params['url']['order'])) {
			$order = $this->params['url']['order'];
		}
		else {
			// Default order
			$order = 'Po.id desc';
		}
		
		if ($isCVS) {
			$this->Po->recursive = 2;
			$data = $this->Po->find('all', array(
				'conditions' => $condition,
				'order' => $order));
			
			$this->set('data', $data);
		}
		else {
			if (!empty($url['pageCount'])) {
				$pageCount = $url['pageCount'];
			}
			else {
				$count = $this->Po->find('count', array(
						'conditions' => $condition));
				$pageCount = intval(ceil($count / $limit));
			}
			
			if (!empty($url['page'])) {
				$page = $url['page'];
			}
			else {
				$page = 1;
			}
			
			$paging = array_merge($paging, array(
				'pageCount' => $pageCount,
				'page' => $page,
				'order'=> $order
			));

			$data = $this->Po->find('all', array(
				'conditions' => $condition,
				'limit' => $limit,
				'offset' => $limit * ($page - 1) ,
				'order' => $order));
			
			$this->set('paging', $paging);
			$this->set('data', $data);
		}
	}
	
	function genPdf($id) {
		$this->Po->recursive = 2;
		$so = $this->Po->find(array('Po.id' => $id));
		
		$this->data = $so;
		$viewHtml = $this->render(null, 'blank2', 'pdf_layout');
		
		// you may comment below part for debug
		$this->output = '';
		$this->set('viewHtml', $viewHtml);
		
		$this->layout = 'blank';
		$this->viewPath = 'elements'; 
        $this->render('pdf');
	}
}
?>