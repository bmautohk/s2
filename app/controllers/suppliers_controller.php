<?php
class SuppliersController extends AppController {
	var $name = 'Suppliers';
	var $helpers = array('Html','Javascript', 'Form');
	
	function create() {
		$this->layout = 'layout_1280';
		$this->render('maint');
	}
	
	function edit() {
		if (!empty($this->params['url']['id'])) {
			$id = $this->params['url']['id'];
			
			$supplier = $this->Supplier->find(array('id' => $id));
		}
		else {
			$supplier = null;
		}

		$this->data = $supplier;
		$this->layout = 'layout_1280';
		$this->render('maint');
	}
	
	function save() {
		if ( !empty($this->data) ) {
			$id = $this->data['Supplier']['id'];
			$supplier_name = $this->data['Supplier']['name'];
			
			$isCreate = false;
			if (empty($id)) {
				$isCreate = true;
			}
			
			if ($isCreate) {
				$this->data['Supplier']['create_by'] = 'Tester';
				$this->data['Supplier']['create_date'] = DboSource::expression('NOW()');
			}
			$this->data['Supplier']['last_update_by'] = 'Tester';
			$this->data['Supplier']['last_update_date'] = DboSource::expression('NOW()');
			
			if ($this->Supplier->save($this->data)) {
				$this->data = NULL;
				
				// Clear cache
				Cache::delete('supplier_dropdown_list', '1_hour');
				
				if ($isCreate) {
					$success_msg = 'Create new supplier ['.$supplier_name.'] successfully!';
				}
				else {
					$success_msg = 'Update supplier ['.$supplier_name.'] successfully!';
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
		$count = $this->Supplier->find('count');
		$limit = Configure::read('page.limit');
		$pageCount = intval(ceil($count / $limit));
									
		$data = $this->Supplier->find('all', array(
												'limit' => $limit,
												'offset' => 0,
												'order' => 'Supplier.id desc')
									);
		
		$paging = array(
			'pageCount' => $pageCount,
			'page' => 1,
			'order' => 'Supplier.id desc'
		);
		$this->set('paging', $paging);				
		$this->set('data', $data);
		
		$this->layout = 'search_form';
		$this->render('search');
	}
	
	function search() {
		$this->searchSupplier(false);
		
		$this->layout = 'blank';
		$this->viewPath = 'elements'.DS.'suppliers'; 
        $this->render('paging');
	}
	
	function genCVS() {
		$this->searchSupplier(true);
		
		$this->layout = 'blank'; 
        $this->render('excel_file');
	}
	
	function searchSupplier($isCVS) {
		$url = $this->params['url'];
		$condition = array();
		$paging = array();
		$limit = Configure::read('page.limit');
		
		if (!empty($url['name'])) {
			$condition['lower(Supplier.name) LIKE'] = '%'.strtolower($url['name']).'%';
			$paging['name'] = $url['name'];
		}
		if (!empty($url['supplier_cd'])) {
			$condition['lower(Supplier.supplier_cd) LIKE'] = '%'.strtolower($url['supplier_cd']).'%';
			$paging['cust_cd'] = $url['supplier_cd'];
		}
		if (!empty($url['tel'])) {
			$condition['lower(Supplier.tel) LIKE'] = '%'.strtolower($url['tel']).'%';
			$paging['tel'] = $url['tel'];
		}
		if (!empty($url['fax'])) {
			$condition['lower(Supplier.fax) LIKE'] = '%'.strtolower($url['fax']).'%';
			$paging['fax'] = $url['fax'];
		}
		if (!empty($url['address'])) {
			$condition['lower(Supplier.address) LIKE'] = '%'.strtolower($url['address']).'%';
			$paging['address'] = $url['address'];
		}
		if (!empty($url['contact_person'])) {
			$condition['lower(Supplier.contact_person) LIKE'] = '%'.strtolower($url['contact_person']).'%';
			$paging['contact_person'] = $url['contact_person'];
		}
		if (!empty($url['email'])) {
			$condition['lower(Supplier.email) LIKE'] = '%'.strtolower($url['email']).'%';
			$paging['email'] = $url['email'];
		}
		
		if (!empty($this->params['url']['order'])) {
			$order = $this->params['url']['order'];
		}
		else {
			$order = 'Supplier.id asc';
		}
		
		if ($isCVS) {
			$data = $this->Supplier->find('all', array(
				'conditions' => $condition,
				'order' => $order));
			
			$this->set('data', $data);
		}
		else {
			if (!empty($url['pageCount'])) {
				$pageCount = $url['pageCount'];
			}
			else {
				$count = $this->Supplier->find('count', array(
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
			
			$data = $this->Supplier->find('all', array(
				'conditions' => $condition,
				'limit' => $limit,
				'offset' => $limit * ($page - 1) ,
				'order' => $order));
		
			$this->set('paging', $paging);
			$this->set('data', $data);
		}
	}
}
?>