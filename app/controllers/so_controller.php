<?php

class SoController extends AppController {
	var $name = 'So';
	var $helpers = array('Html','Javascript', 'Form');
	
	function testdb() {
		//$this->So->transactional = true;
		//$this->So->begin();
		//$dataSource = $this->So->getDataSource();
		$dataSource =ConnectionManager::getDataSource($this->So->useDbConfig);
		$dataSource->begin($this->So);
		$so = $this->So->find(array("So.id"=>"4"), NULL, NULL, -1);
		var_dump($so);
		$so["So"]["cust_id"] = $so["So"]["cust_id"] + 1;
		//$this->So->data = $so;
		//$dataSource->update($this->So, NULL, NULL); 
		$this->So->save($so, false, array("cust_id"));
		//$this->So->rollback();
		$dataSource->rollback($this->So);
		
		$this->layout = 'blank';
		$this->render("blank");
	}
	
	function maintInit() {
		$this->set('supplierCdList', ClassRegistry::init('Supplier')->getSupplierDropDown());
		$this->layout = 'layout_1280';
	}
	
	function create() {
		$so['So']['so_date'] = date("Y-m-d");
		$so['So']['total_amt'] = '$0.00';
		$so['SoDetail'] = array();
		
		$this->maintInit();
		$this->data = $so;
		$this->render('maint');
	}
	
	function edit() {
		if (!empty($this->params['url']['id'])) {
			$id = $this->params['url']['id'];
			
			$this->So->recursive = 2;
			$so = $this->So->find(array('So.id' => $id));
		}
		else {
			$so = null;
		}

		$this->maintInit();
		$this->data = $so;
		$this->render('maint');
	}
	
	function save() {
		$isSuccess = true;
		
		if ( !empty($this->data) ) {
			$id = $this->data['So']['id'];

			// Calculate amount of SO details
			$total_amt = 0;
			foreach ($this->data['SoDetail'] as $index => $value) {
				if (empty($value['prod_cd'])) {
					unset($this->data['SoDetail'][$index]);
					continue;
				}
				$subtotal = $value['qty'] * ($value['unit_price'] - $value['discount']);
				$this->data['SoDetail'][$index]['subtotal'] = $subtotal;
				$total_amt = $total_amt + $subtotal;
				
				if (empty($this->data['SoDetail']['id'])) {
					$this->data['SoDetail'][$index]['create_by'] = 'Tester';
					$this->data['SoDetail'][$index]['create_date'] = DboSource::expression('NOW()');
				}
				$this->data['SoDetail'][$index]['last_update_by'] = 'Tester';
				$this->data['SoDetail'][$index]['last_update_date'] = DboSource::expression('NOW()');
			}
			$this->data['So']['total_amt'] = $total_amt;
			
			$isCreate = false;
			if (empty($id)) {
				$isCreate = true;
			}
			
			
			// Get customer ID
			$customer = ClassRegistry::init('Customer')->find(array('cust_cd'=>$this->data['So']['cust_cd']));
			$this->data['So']['cust_id'] = $customer['Customer']['id'];
			
			// Delivery date
			if ($this->data['So']['delivery_date'] == '') {
				$this->data['So']['delivery_date'] = NULL;
			}
			
			if ($isCreate) {
				$this->data['So']['create_by'] = 'Tester';
				$this->data['So']['create_date'] = DboSource::expression('NOW()');
			}
			$this->data['So']['last_update_by'] = 'Tester';
			$this->data['So']['last_update_date'] = DboSource::expression('NOW()');
			
			// No SO Detail
			$noOfDetail = sizeof($this->data['SoDetail']);
			if ($noOfDetail == 0) {
				unset($this->data['SoDetail']);
			}
			
			$saveData = $this->data;
			unset($saveData['Customer']);

		$this->So->begin();
			$soDetailModel = ClassRegistry::init('SoDetail');
			
			if ($this->So->saveAll($saveData, array("validate"=>"only"))) {
				// Create / Update PO
				if ($isCreate) {
					// Create SO
					if ($this->So->saveAll($saveData)) {
						$id = $this->So->getLastInsertId(); 
						$this->data['So']['id'] = $id;
					}
					else {
						$isSuccess = false;
					}
				}
				else {
					// Update SO
					
					// Update SO & SO detail status
					$so_sts = So::STS_COMPLETE;
					foreach ($saveData["SoDetail"] as $index => $detail) {
						$origSoDeatil = $soDetailModel->find(array('id' => $detail['id']), array("inv_qty"));
						if ($origSoDeatil['SoDetail']['inv_qty'] > $detail['qty']) {
							// Error
							$this->So->SoDetail->validationErrors[$index] = array("qty"=>"Input QTY < QTY in invoices (".$origSoDeatil['SoDetail']['inv_qty'].")");
							$isSuccess = false;
						}
						else if ($origSoDeatil['SoDetail']['inv_qty'] == $detail['qty']) {
							$saveData["SoDetail"][$index]['sts'] = SoDetail::STS_COMPLETE;
						}
						else {
							$saveData["SoDetail"][$index]['sts'] = SoDetail::STS_PENDING;
							$so_sts = So::STS_PENDING;
						}
					}
					$saveData["So"]["sts"] = $so_sts;
					
					// Save SO
					if ($isSuccess && $this->So->saveAll($saveData)) {
						$this->data['So']['id'] = $id;
					}
					else {
						$isSuccess = false;
					}
				}
				
				if ($isSuccess) {
					if (ClassRegistry::init('Po')->savePoFromSo($this->data)) {
						if ($isCreate) {
							$success_msg = 'Create new sell order ['.$id.'] successfully!';
						}
						else {
							$success_msg = 'Update sell order ['.$id.'] successfully!';
						}
						$this->data = NULL;
					$this->So->commit();
					}
					else {
					$this->So->rollback();
						$error_msg = 'There was a problem when creating purchase order.';
						$isSuccess = false;
					}
				}
				else {
					$error_msg = 'There was a problem with your modification.';
				}
				
		
			} else {
		$this->So->rollback();
				$error_msg = 'There was a problem with your modification.';
				$isSuccess = false;
			}
		}

		if (isset($success_msg)) $this->set('success_msg', $success_msg);
		if (isset($error_msg)) $this->set('error_msg', $error_msg);
		
		if ($isSuccess) {
			$this->create();
		}
		else {
			if ($noOfDetail == 0) {
				$this->data['SoDetail'] = array();
			}
			$this->maintInit();
			$this->render('maint');
		}
	}
	
	function list_all() {
		$count = $this->So->find('count');
		$limit = Configure::read('page.limit');
		$pageCount = intval(ceil($count / $limit));
		
		$this->So->recursive = 0;				
		$data = $this->So->find('all', array(
										'limit' => $limit,
										'offset' => 0,
										'order' => 'So.id desc')
								);
		
		$paging = array(
			'pageCount' => $pageCount,
			'page' => 1,
			'order' => 'So.id desc'
		);
		$this->set('paging', $paging);				
		$this->set('data', $data);
		
		$this->layout = 'search_form';
		$this->render('search');
	}
	
	function search() {
		$this->searchSO(false);
		
		$this->layout = 'blank';
		$this->viewPath = 'elements'.DS.'so'; 
        $this->render('paging');
	}
	
	function genCVS() {
		$this->searchSO(true);
		
		$this->layout = 'blank'; 
        $this->render('excel_file');
	}
	
	function searchSO($isCVS) {
		$url = $this->params['url'];
		$condition = array();
		$paging = array();
		$limit = Configure::read('page.limit');
		
		if (!empty($url['id'])) {
			$condition['So.id'] = $url['id'];
			$paging['id'] = $url['id'];
		}
		if (!empty($url['cust_name'])) {
			$condition['lower(Customer.name) LIKE'] = '%'.strtolower($url['cust_name']).'%';
			$paging['cust_name'] = $url['cust_name'];
		}
		if (!empty($url['cust_cd'])) {
			$condition['lower(So.cust_cd) LIKE'] = '%'.strtolower($url['cust_cd']).'%';
			$paging['cust_cd'] = $url['cust_cd'];
		}
		if (!empty($url['so_date_from'])) {
			$condition['So.so_date >= '] = $url['so_date_from'];
			$paging['so_date_from'] = $url['so_date_from'];
		}
		if (!empty($url['so_date_to'])) {
			$condition['So.so_date <= '] = $url['so_date_to'];
			$paging['so_date_to'] = $url['so_date_to'];
		}
		if (!empty($url['prod_cd'])) {
			$condition['lower(SoDetail.prod_cd) LIKE'] = '%'.strtolower($url['prod_cd']).'%';
			$paging['prod_cd'] = $url['prod_cd'];
		}
		
		if (!empty($this->params['url']['order'])) {
			$order = $this->params['url']['order'];
		}
		else {
			$order = 'So.id desc';
		}
		
		if ($isCVS) {
			$this->So->bindModelForSearch();
			$data = $this->So->find('all', array(
			    'conditions' => $condition,
			    'contain' => array('Customer', 'SoDetail'),
			    'fields' => array('DISTINCT So.*'),
				'order' => $order)
			);

			$this->set('data', $data);
		}
		else {
			if (!empty($url['pageCount'])) {
				$pageCount = $url['pageCount'];
			}
			else {
				$this->So->bindModelForSearch();
				$count = $this->So->find('count', array(
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
			
			$this->So->recursive = 0;
			$this->So->bindModelForSearch();
			$data = $this->So->find('all', array(
			    'conditions' => $condition,
			    'contain' => array('Customer', 'SoDetail'),
			    'fields' => array('DISTINCT So.*'),
				'limit' => $limit,
				'offset' => $limit * ($page - 1) ,
				'order' => $order)
			);

			$this->set('paging', $paging);
			$this->set('data', $data);
		}
	}
	
// Ajax Call
	/**
	 * Get SO detail to display in Invoice Creation
	 * 
	 */
	function searchSoDetailBySoId() {
		$so_id = $this->params['url']['so_id'];
		$this->So->recursive = 2;
		$so = $this->So->find(array('So.id' => $so_id));
		
		if (!$so) {
			$this->set('error_msg', 'Sell Order Not Found!');
			
			$this->layout = 'blank';
			$this->viewPath = 'elements'.DS.'invoices';
	        $this->render('fail');
	        return;
		}
		
		if ($so['So']['sts'] == 'C') {
			$this->set('error_msg', 'Sell Order ['.$so_id.'] has already completed!');
			
			$this->layout = 'blank';
			$this->viewPath = 'elements'.DS.'invoices';
	        $this->render('fail');
	        return;
		}

		$index = 0;
		$data['Customer'] = $so['Customer'];
		//$data['InvoiceDetail'] = $so['SoDetail'];
		for ($i = 0; $i < sizeof($so['SoDetail']); $i++) {
			if ($so['SoDetail'][$i]['qty'] - $so['SoDetail'][$i]['inv_qty'] == 0) {
				// Skip avail qty = 0
				continue;
			}
			$data['InvoiceDetail'][$index] = $so['SoDetail'][$i];
			$data['InvoiceDetail'][$index]['so_detail_id'] = $data['InvoiceDetail'][$index]['id'];
			$data['InvoiceDetail'][$index]['id'] = '';
			$data['InvoiceDetail'][$index]['origQty'] = $data['InvoiceDetail'][$index]['qty'];
			$data['InvoiceDetail'][$index]['availQty'] = $data['InvoiceDetail'][$index]['qty'] - $data['InvoiceDetail'][$index]['inv_qty'];
			$data['InvoiceDetail'][$index]['qty'] = 0;
			$data['InvoiceDetail'][$index]['subtotal'] = 0;
			$data['InvoiceDetail'][$index]['sumAvailActQty'] = $data['InvoiceDetail'][$index]['qty'] + $data['InvoiceDetail'][$index]['availQty'];
			$index++;
		}
		$data['Invoice']['total_amt'] = 0;
		
		$this->data = $data;
		$this->layout = 'blank';
		$this->viewPath = 'elements'.DS.'invoices'; 
        $this->render('invoice_detail_list');
	}
	
	function genPdf($id) {
		$this->So->recursive = 2;
		$so = $this->So->find(array('So.id' => $id));
		
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