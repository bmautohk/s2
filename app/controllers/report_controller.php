<?php
class ReportController extends AppController {
	var $name = 'Report';
	var $helpers = array('Html','Javascript', 'Form');

	function list_all() {
		// Customer dropdown
		$this->set('custCdList', ClassRegistry::init('Customer')->getCustomerDropDown());
		
		$paging = array(
			'pageCount' => 0,
			'page' => 1
		);
		$this->set('paging', $paging);
		$this->set('invoiceList', array());
		
		$this->layout = 'search_form';
		$this->render('search');
	}
	
	function search() {
		$this->searchUnSettleInvoiceByCustCd();
		
		$this->layout = 'blank';
		$this->viewPath = 'elements'.DS.'report'; 
        $this->render('paging');
	}
	
	function searchUnSettleInvoiceByCustCd() {
		$custCd = $this->params['url']['data']['cust_cd'];
		if (empty($custCd)) {
			$this->set('paging', array('pageCount' => 0,'page' => 1));
			$this->set('invoiceList', array());
			
	        return;
		}
		$this->searchUnSettleInvoice($custCd);
	}
	
	function searchUnSettleInvoice($custCd) {
		$url = $this->params['url'];
		$condition = array();
		$limit = Configure::read('page.limit');
		$paging = array(
			'pageCount' => 0,
			'page' => 1
		);
		
		$invoiceModel = ClassRegistry::init('Invoice');
		
		if (!empty($custCd)) {
			$condition['Invoice.cust_cd'] = $custCd;
			$paging['data[cust_cd]'] = $custCd;
		}
		
		if (!empty($this->params['url']['order'])) {
			$order = $this->params['url']['order'];
		}
		else {
			// Default order
			$order = 'Invoice.id desc';
		}
		
		$condition = array_merge($condition, array('ar_sts'=>'A'));
		if (!empty($url['pageCount'])) {
			$pageCount = $url['pageCount'];
		}
		else {
			$count = $invoiceModel->find('count', array(
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

		$data = $invoiceModel->find('all', array(
			'conditions' => $condition,
			//'limit' => $limit,
			//'offset' => $limit * ($page - 1) ,
			'order' => $order)
		);
			
		$this->set('paging', $paging);
		$this->set('invoiceList', $data);
	}
	
	function searchUnSettlePo($custCd) {
		$url = $this->params['url'];
		$condition = array();
		$limit = Configure::read('page.limit');
		$paging = array(
			'pageCount' => 0,
			'page' => 1
		);
		
		$invoiceModel = ClassRegistry::init('Invoice');
		
		if (!empty($custCd)) {
			$condition['Invoice.cust_cd'] = $custCd;
			$paging['data[cust_cd]'] = $custCd;
		}
		
		if (!empty($this->params['url']['order'])) {
			$order = $this->params['url']['order'];
		}
		else {
			// Default order
			$order = 'Invoice.id desc';
		}
		
		$condition = array_merge($condition, array('ar_sts'=>'A'));
		if (!empty($url['pageCount'])) {
			$pageCount = $url['pageCount'];
		}
		else {
			$count = $invoiceModel->find('count', array(
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

		$data = $invoiceModel->find('all', array(
			'conditions' => $condition,
			'limit' => $limit,
			'offset' => $limit * ($page - 1) ,
			'order' => $order));
			
			$this->set('paging', $paging);
			$this->set('invoiceList', $data);
	}
}
?>