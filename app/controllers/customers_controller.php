<?php
class CustomersController extends AppController {
	var $name = 'Customers';
	var $helpers = array('Html','Javascript', 'Form');
	
	function create() {
		$this->layout = 'layout_1280';
		$this->render('maint');
	}
	
	function edit() {
		if (!empty($this->params['url']['id'])) {
			$id = $this->params['url']['id'];
			
			$customer = $this->Customer->find(array('id' => $id));
		}
		else {
			$customer = null;
		}

		$this->data = $customer;
		$this->layout = 'layout_1280';
		$this->render('maint');
	}
	
	function save() {
		if ( !empty($this->data) ) {
			$id = $this->data['Customer']['id'];
			$cust_name = $this->data['Customer']['name'];
			
			$isCreate = false;
			if (empty($id)) {
				$isCreate = true;
			}
			
			if ($isCreate) {
				$this->data['Customer']['create_by'] = 'Tester';
				$this->data['Customer']['create_date'] = DboSource::expression('NOW()');
			}
			$this->data['Customer']['last_update_by'] = 'Tester';
			$this->data['Customer']['last_update_date'] = DboSource::expression('NOW()');
			
			$saveData = $this->data;
			/*if (!$isCreate) {
				unset($saveData['Customer']['cust_cd']);
			}*/
			
			if ($this->Customer->save($saveData)) {
				$this->data = NULL;
				if ($isCreate) {
					$success_msg = 'Create new Customer ['.$cust_name.'] successfully!';
				}
				else {
					$success_msg = 'Update Customer ['.$cust_name.'] successfully!';
				}
			} else {
				$error_msg = 'There was a problem with your modification';
			}
		}

		if (isset($success_msg)) $this->set('success_msg', $success_msg);
		if (isset($error_msg)) $this->set('error_msg', $error_msg);
		
		$this->layout = 'layout_1280';
		$this->render('maint');
	}
	
	function list_all() {
		$count = $this->Customer->find('count');
		$limit = Configure::read('page.limit');
		$pageCount = intval(ceil($count / $limit));
									
		$data = $this->Customer->find('all', array(
												'limit' => $limit,
												'offset' => 0,
												'order' => 'Customer.id desc')
									);
		
		$paging = array(
			'pageCount' => $pageCount,
			'page' => 1,
			'order'=>'Customer.id desc'
		);
		$this->set('paging', $paging);				
		$this->set('data', $data);
		
		$this->layout = 'search_form';
		$this->render('search');
	}
	
	function search() {
		$this->searchCustomer(false);
		
		$this->layout = 'blank';
		$this->viewPath = 'elements'.DS.'customers'; 
        $this->render('paging');
	}
	
	function genCVS() {
		$this->searchCustomer(true);
		
		$this->layout = 'blank'; 
        $this->render('excel_file');
	}
	
	function selectCust() {
		$count = $this->Customer->find('count');
		$limit = Configure::read('page.limit');
		$pageCount = intval(ceil($count / $limit));
									
		$data = $this->Customer->find('all', array(
												'limit' => $limit,
												'offset' => 0,
												'order' => 'Customer.id desc')
									);
		
		$paging = array(
			'pageCount' => $pageCount,
			'page' => 1,
			'order'=>'Customer.id desc'
		);
		$this->set('paging', $paging);				
		$this->set('data', $data);

		$this->layout = 'selectPopUp';
		$this->render('selectCust');
	}
	
	function searchForSelectCust() {
		$this->searchCustomer(false);
		
		$this->layout = 'blank';
		$this->viewPath = 'elements'.DS.'customers'; 
        $this->render('select_paging');
	}
	
	function searchCustomer($isCVS) {
		$url = $this->params['url'];
		$condition = array();
		$paging = array();
		$limit = Configure::read('page.limit');
		
		if (!empty($url['name'])) {
			$condition['lower(Customer.name) LIKE'] = '%'.strtolower($url['name']).'%';
			$paging['name'] = $url['name'];
		}
		if (!empty($url['cust_cd'])) {
			$condition['lower(Customer.cust_cd) LIKE'] = '%'.strtolower($url['cust_cd']).'%';
			$paging['cust_cd'] = $url['cust_cd'];
		}
		if (!empty($url['tel'])) {
			$condition['lower(Customer.tel) LIKE'] = '%'.strtolower($url['tel']).'%';
			$paging['tel'] = $url['tel'];
		}
		if (!empty($url['fax'])) {
			$condition['lower(Customer.fax) LIKE'] = '%'.strtolower($url['fax']).'%';
			$paging['fax'] = $url['fax'];
		}
		if (!empty($url['address'])) {
			$condition['lower(Customer.address) LIKE'] = '%'.strtolower($url['address']).'%';
			$paging['address'] = $url['address'];
		}
		if (!empty($url['contact_person'])) {
			$condition['lower(Customer.contact_person) LIKE'] = '%'.strtolower($url['contact_person']).'%';
			$paging['contact_person'] = $url['contact_person'];
		}
		if (!empty($url['email'])) {
			$condition['lower(Customer.email) LIKE'] = '%'.strtolower($url['email']).'%';
			$paging['email'] = $url['email'];
		}
		
		if (!empty($this->params['url']['order'])) {
			$order = $this->params['url']['order'];
		}
		else {
			// Default order
			$order = 'Customer.name asc';
		}
		
		if ($isCVS) {
			$data = $this->Customer->find('all', array(
			'conditions' => $condition,
			'order' => $order));
			
			$this->set('data', $data);
		}
		else {
			if (!empty($url['pageCount'])) {
				$pageCount = $url['pageCount'];
			}
			else {
				$count = $this->Customer->find('count', array(
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

			$data = $this->Customer->find('all', array(
			'conditions' => $condition,
			'limit' => $limit,
			'offset' => $limit * ($page - 1) ,
			'order' => $order));
			
			$this->set('paging', $paging);
			$this->set('data', $data);
		}
	}
	
// Ajax Call
	function searchByCustCd() {
		$cust_cd = $this->params['url']['cd'];
		$customer = $this->Customer->find('first', 
							array('conditions' => array('cust_cd' => $cust_cd),
									'fields' => 'name'
								)
							);
		
		if ($customer) {
			echo json_encode($customer);
		}
		
		$this->layout = 'blank_ajax';
		$this->viewPath = 'elements'; 
        $this->render('blank');
	}
	
	
}
?>