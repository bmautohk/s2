<?php
class BalanceByCustController extends AppController {
	var $name = 'BalanceByCust';
	var $helpers = array('Html','Javascript', 'Form');
	
	function list_all() {
		$this->searchUnSettleInvoice("");
		$this->searchUnSettlePo("");
		
		$this->set('cust_cd', "");
		$this->layout = "layout_1280";
		$this->render("bbcomp");
	}
	
	function list_by_cust() {
		// Customer dropdown
		$this->set('custCdList', ClassRegistry::init('Customer')->getCustomerDropDown());
		
		$paging = array(
			'pageCount' => 0,
			'page' => 1
		);
		
		$this->set('cust_cd', "");
		$this->set('paging_ap', $paging);
		$this->set('paging_ar', $paging);
		$this->set('apData', array());
		$this->set('arData', array());
		
		$this->layout = "layout_1280";
		$this->render("bbc");
	}
	
	function search_ar() {
		$url = $this->params['url'];
		$cust_cd = !empty($url['cust_cd']) ? $url['cust_cd'] : "";
		
		$this->searchUnSettleInvoice($cust_cd);
		
		$this->set('cust_cd', $cust_cd);
		$this->layout = 'blank';
		$this->viewPath = 'elements'.DS.'balance_by_cust'; 
        $this->render('paging_ar');
	}
	
	function search_ap() {
		$url = $this->params['url'];
		$cust_cd = !empty($url['cust_cd']) ? $url['cust_cd'] : "";
		
		$this->searchUnSettlePo($cust_cd);
		
		$this->set('cust_cd', $cust_cd);
		$this->layout = 'blank';
		$this->viewPath = 'elements'.DS.'balance_by_cust'; 
        $this->render('paging_ap');
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
			$paging['cust_cd'] = $custCd;
		}
		
		if (!empty($this->params['url']['order'])) {
			$order = $this->params['url']['order'];
		}
		else {
			// Default order
			$order = 'Invoice.id desc';
		}
		
		$condition = array_merge($condition, array('ar_sts'=>Invoice::AR_STS_UNSETTLE));
		if (!empty($url['pageCount'])) {
			$pageCount = $url['pageCount'];
		}
		else {
			/*$count = $invoiceModel->find('count', array(
					'conditions' => $condition,
					'recursive' => 0));
			$pageCount = intval(ceil($count / $limit));*/
		}
		
		if (!empty($url['page'])) {
			$page = $url['page'];
		}
		else {
			$page = 1;
		}
		
		/*$paging = array_merge($paging, array(
			'pageCount' => $pageCount,
			'page' => $page,
			'order'=> $order
		));*/

		$data = $invoiceModel->find('all', array(
			'conditions' => $condition,
			'recursive' => 0,
			//'limit' => $limit,
			//'offset' => $limit * ($page - 1) ,
			'order' => $order)
		);
			
		$this->set('paging_ar', $paging);
		$this->set('arData', $data);
	}
	
	function searchUnSettlePo($custCd) {
		$url = $this->params['url'];
		$condition = array();
		$limit = Configure::read('page.limit');
		$paging = array(
			'pageCount' => 0,
			'page' => 1
		);
		
		$poModel = ClassRegistry::init('Po');
		
		if (!empty($custCd)) {
			$condition['So.cust_cd'] = $custCd;
			$paging['cust_cd'] = $custCd;
		}
		
		if (!empty($this->params['url']['order'])) {
			$order = $this->params['url']['order'];
		}
		else {
			// Default order
			$order = 'Po.id desc';
		}
		
		$condition = array_merge($condition, array('ap_sts'=>Po::AP_STS_UNSETTLE));
		if (!empty($url['pageCount'])) {
			$pageCount = $url['pageCount'];
		}
		else {
			/*$count = $poModel->find('count', array(
					'conditions' => $condition,
					'recursive' => 1));
			$pageCount = intval(ceil($count / $limit));*/
		}
		
		if (!empty($url['page'])) {
			$page = $url['page'];
		}
		else {
			$page = 1;
		}
		
		/*$paging = array_merge($paging, array(
			'pageCount' => $pageCount,
			'page' => $page,
			'order'=> $order
		));*/

		$data = $poModel->find('all', array(
			'conditions' => $condition,
			'recursive' => 1,
			//'limit' => $limit,
			//'offset' => $limit * ($page - 1) ,
			'order' => $order)
		);
			
		$this->set('paging_ap', $paging);
		$this->set('apData', $data);
	}
}
?>