<?php
class ProductsController extends AppController {
	var $name = 'Products';
	var $helpers = array('Html','Javascript', 'Form');
	
	
	function save() {
		if ( !empty($this->data) ) {
			$id = $this->data['Product']['product_id'];
			$product_name = $this->data['Product']['product_name'];
			
			
			$isCreate = false;
			
			
			$counter = $this->Product->find('count', 
							array('conditions' => array('product_id' => $id),
									
								)
							);
							
			if ($counter==0) {
				$isCreate = true;
			}
			
			if ($isCreate) {
				$this->data['Product']['create_by'] = 'Tester';
				$this->data['Product']['create_date'] = DboSource::expression('NOW()');
			}
			$this->data['Product']['last_update_by'] = 'Tester';
			$this->data['Product']['last_update_date'] = DboSource::expression('NOW()');
			
			if ($this->Product->save($this->data)) {
				$this->data = NULL;
				
				// Clear cache
				//Cache::delete('supplier_dropdown_list', '1_hour');
				
				if ($isCreate) {
					$success_msg = 'Create new Product ['.$id.'] successfully!';
				}
				else {
					$success_msg = 'Update Product ['.$id.'] successfully!';
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
	
	
	function create() {
		$this->layout = 'layout_1280';
		$this->render('maint');
	}
	
	function edit() {
		if (!empty($this->params['url']['id'])) {
			$id = $this->params['url']['id'];
			
		 	$Product = $this->Product->find(array('product_id' => $id));
		}
		else {
			$Product = null;
		}

		$this->data = $Product;
		$this->layout = 'layout_1280';
		$this->render('maint');
	}

	function list_all() {
		$count = $this->Product->find('count');
		$limit = Configure::read('page.limit');
		$pageCount = intval(ceil($count / $limit));

		$data = $this->Product->find('all', array(
										'limit' => $limit,
										'offset' => 0,
										'order' => 'Product.product_id')
								);
		
		$paging = array(
			'pageCount' => $pageCount,
			'page' => 1,
			'order' => 'Product.product_id'
		);
		$this->set('paging', $paging);				
		$this->set('data', $data);
		$this->set('charset', 'euc-jp');
		
		$this->layout = 'search_form';
		$this->render('search');
	}
	
	function search() {
		$url = $this->params['url'];
		$condition = array();
		$paging = array();
		$limit = Configure::read('page.limit');
		
		if (!empty($url['product_id'])) {
			$condition['lower(Product.product_id) like'] = '%'.strtolower($url['product_id']).'%';
			$paging['product_id'] = $url['product_id'];
		}
		if (!empty($url['desc'])) {
			echo $url['desc'];
			$condition['lower(Product.product_name) LIKE'] = '%'.strtolower($url['desc']).'%';
			$paging['desc'] = $url['desc'];
		}
		if (!empty($url['price_from'])) {
			$condition['Product.product_cus_price >= '] = $url['price_from'];
			$paging['price_from'] = $url['price_from'];
		}
		if (!empty($url['price_to'])) {
			$condition['Product.product_cus_price <= '] = $url['price_to'];
			$paging['price_to'] = $url['price_to'];
		}
		
		if (!empty($this->params['url']['order'])) {
			$order = $this->params['url']['order'];
		}
		else {
			$order = 'Product.product_id asc';
		}
		
		if (!empty($url['pageCount'])) {
			$pageCount = $url['pageCount'];
		}
		else {
			$count = $this->Product->find('count', array(
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
		
		$data = $this->Product->find('all', array(
			'conditions' => $condition,
			'limit' => $limit,
			'offset' => $limit * ($page - 1) ,
			'order' => $order));
		
		
		$this->set('paging', $paging);
		$this->set('data', $data);

		$this->layout = 'blank';
		$this->viewPath = 'elements'.DS.'products'; 
        $this->render('paging');
	}
	
// Ajax Call
	function searchList() {
		$prod_cd = $this->params['url']['term'];
		$data = $this->Product->find('all', 
							array('conditions' => array('product_id like ' => $prod_cd.'%'),
									'fields' => array('product_id', "product_name"),
									'limit' => 10
								)
							);
		
		$i = 0;
		foreach ($data as $products) {
			$product = $products['Product'];
			$product_list[$i] = array('id'=>$product['product_id'],
									'value'=>$product['product_id'],
									'label'=>$product['product_id'].' - '.$product['product_name']
								);
			$i++;
		}
		if ($product_list) {
			echo json_encode($product_list);
		}
		
		$this->layout = 'blank_ajax';
		$this->viewPath = 'elements'; 
        $this->render('blank');
	}
	
	function searchByProdCd() {
		$prod_cd = $this->params['url']['cd'];
		$data = $this->Product->find('first', 
							array('conditions' => array('product_id' => $prod_cd),
									'fields' => array("product_name", 'product_cus_price', 'product_cost_rmb'),
								)
							);
		echo json_encode($data);
		$this->layout = 'blank_ajax';
		$this->viewPath = 'elements'; 
        $this->render('blank');
	}
}
?>