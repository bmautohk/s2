<?
class InvoicesController extends AppController {
	var $name = 'Invoices';
	var $helpers = array('Html','Javascript', 'Form');
	
	function maintInit() {
		$this->layout = 'layout_1280';
	}
	
	function create() {
		$invoice['Invoice']['inv_date'] = date("Y-m-d");
		$invoice['Invoice']['total_amt'] = '0.00';
		$invoice['InvoiceDetail'] = array();
		
		if (!empty($this->params['url']['so_id'])) {
			$invoice['Invoice']['sell_order_id'] = $this->params['url']['so_id'];
			$so_id = $this->params['url']['so_id'];
		}
		
		$this->data = $invoice;
		$this->set('action', 'create');
		$this->maintInit();
		$this->render('maint');
	}
	
	function edit() {
		if (!empty($this->params['url']['id'])) {
			$id = $this->params['url']['id'];
			
			$this->Invoice->recursive = 2;
			$so = $this->Invoice->find(array('Invoice.id' => $id));
		}
		else {
			$so = null;
		}
		
		foreach ($so['InvoiceDetail'] as $index => $invoiceDetail) {
			$so['InvoiceDetail'][$index]['origQty'] = $so['InvoiceDetail'][$index]['SoDetail']['qty'];
			$so['InvoiceDetail'][$index]['availQty'] = $so['InvoiceDetail'][$index]['SoDetail']['qty'] - $so['InvoiceDetail'][$index]['SoDetail']['inv_qty'];
			$so['InvoiceDetail'][$index]['sumAvailActQty'] = $so['InvoiceDetail'][$index]['qty'] + $so['InvoiceDetail'][$index]['availQty'];
		}

		$this->data = $so;
		$this->set('action', 'edit');
		$this->maintInit();
		$this->render('maint');
	}
	
	function save() {
		$isSuccess = true;
		$this->set('action', 'save');
		
		if ( !empty($this->data) ) {
			$id = $this->data['Invoice']['id'];
			
			$isCreate = false;
			if (empty($id)) {
				$isCreate = true;
			}
			
			// Calcualte total amount
			$total_amt = 0;
			foreach ($this->data['InvoiceDetail'] as $index => $value) {
				$subtotal = $value['qty'] * ($value['unit_price'] - $value['discount']);
				$this->data['InvoiceDetail'][$index]['subtotal'] = $subtotal;
				$total_amt = $total_amt + $subtotal;
				
				if (empty($this->data['InvoiceDetail']['id'])) {
					$this->data['InvoiceDetail'][$index]['create_by'] = 'Tester';
					$this->data['InvoiceDetail'][$index]['create_date'] = DboSource::expression('NOW()');
				}
				$this->data['InvoiceDetail'][$index]['last_update_by'] = 'Tester';
				$this->data['InvoiceDetail'][$index]['last_update_date'] = DboSource::expression('NOW()');
			}
			$this->data['Invoice']['total_amt'] = $total_amt;
			
			// Get customer
			$customer = ClassRegistry::init('Customer')->find(array('cust_cd'=>$this->data['Invoice']['cust_cd']), array('id', 'cust_cd'));
			$this->data['Invoice']['cust_cd'] = $customer['Customer']['cust_cd'];
			$this->data['Invoice']['cust_id'] = $customer['Customer']['id'];
			
			if ($isCreate) {
				$this->data['Invoice']['create_by'] = 'Tester';
				$this->data['Invoice']['create_date'] = DboSource::expression('NOW()');
				
				// Get customer
				/*$soModel = ClassRegistry::init('So');
				$so = $soModel->find('first', array('conditions'=>array('id'=>$this->data['Invoice']['sell_order_id']),
													'recursive' => -1));
				$this->data['Invoice']['cust_cd'] = $so['So']['cust_cd'];
				$this->data['Invoice']['cust_id'] = $so['So']['cust_id'];*/
			}
			$this->data['Invoice']['last_update_by'] = 'Tester';
			$this->data['Invoice']['last_update_date'] = DboSource::expression('NOW()');

			try {
				$newInv = $this->data;
				unset($newInv['Customer']);
				if ($this->Invoice->saveAll($newInv, array("validate"=>"only"))) {
					unset($newInv["So"]);
					
					$arByCustModel = ClassRegistry::init('ArByCust');
					
					if ($isCreate) {
						// Remove detail (QTY = 0)
						foreach ($newInv['InvoiceDetail'] as $index => $value) {
							if ($value['qty'] == 0) {
								unset($newInv['InvoiceDetail'][$index]);
							}
						}

						// Create invoice
						// Add inv_qty of SO detail
						$isCheckSO = false;
						$soDetailModel = ClassRegistry::init('SoDetail');
						foreach ($this->data['InvoiceDetail'] as $idx => $invoiceDetail) {
							$soDetails = $soDetailModel->find(array('id'=>$invoiceDetail['so_detail_id']), array('id', 'inv_qty', 'qty'), NULL, -1);
							$soDetail = $soDetails['SoDetail'];
							$soDetail['inv_qty'] = $soDetail['inv_qty'] + $invoiceDetail['qty'];
							
							if ($soDetail['inv_qty'] > $soDetail['qty']) {
								$isSuccess = false;
							}
							
							if ($soDetail["qty"] == $soDetail["inv_qty"]) {
								// All qty are used
								$soDetail["sts"] = "C";
								$isCheckSO = true;
							}
							$soDetailList[] =  $soDetail;
						}
						if (!$isSuccess) {
							throw new Exception("Exist QTY > avail. Qty");
						}
						
						// Settle new created invoice
						$invRemainAmt = $arByCustModel->allocateAR($newInv['Invoice']['cust_cd'], $newInv['Invoice']["total_amt"]);
						$newInv['Invoice']["ar_settle_amt"] = $newInv['Invoice']["total_amt"] - $invRemainAmt;
						if ($newInv['Invoice']["ar_settle_amt"] >= $newInv['Invoice']["total_amt"]) {
							$newInv['Invoice']['ar_sts'] = Invoice::AR_STS_SETTLE;
						}
	
						// Update SO Detail
						if (isset($soDetailList)) {
							foreach ($soDetailList as $item) {
								$soDetailModel->save($item, false, array("inv_qty", "sts"));
							}
						}
						
						ClassRegistry::init('So')->completeSO($newInv["Invoice"]["sell_order_id"]);

						// Create invoice
						if ($this->Invoice->saveAll($newInv, array('validate'=>false))) {
							$id = $this->Invoice->getLastInsertId();
							$success_msg = 'Create new invoice ['.$id.'] successfully!';
						}
						else {
							$error_msg = 'There was a problem with your modification.';
							$isSuccess = false;
						}
					}
					else {
						// Update invoice
						
						// Update inv_qty of SO detail
						$soDetailModel = ClassRegistry::init('SoDetail');
						$invoiceDetailModel = ClassRegistry::init('InvoiceDetail');
						foreach ($this->data['InvoiceDetail'] as $invoiceDetail) {
							$soDetails = $soDetailModel->find(array('id'=>$invoiceDetail['so_detail_id']), array('id', 'inv_qty', 'qty'), NULL, -1);
							$orgInvDetail = $invoiceDetailModel->find(array('InvoiceDetail.id'=>$invoiceDetail['id']), array('qty'), NULL, -1);
							$soDetail = $soDetails['SoDetail'];
							$soDetail['inv_qty'] = $soDetail['inv_qty'] - $orgInvDetail['InvoiceDetail']['qty'] + $invoiceDetail['qty'];
							
							if ($soDetail['inv_qty'] > $soDetail['qty']) {
								$isSuccess = false;
							}
							
							if ($soDetail["qty"] == $soDetail["inv_qty"]) {
								// All qty are used
								$soDetail["sts"] = "C";
							}
							else {
								$soDetail["sts"] = "P";
							}
							$soDetailList[] =  $soDetail;
						}
						if (!$isSuccess) {
							throw new Exception("Exist QTY > avail. Qty");
						}
						
						// Retrieve original invoice
						$origInv = $this->Invoice->find('first', array('conditions'=>array('id'=>$id), 'recursive' => -1));
						$origInv = $origInv["Invoice"];
	
						if ($origInv["total_amt"] == $newInv["Invoice"]["total_amt"]) {
							// nothing to do
						}
						else if ($origInv["total_amt"] > $newInv["Invoice"]["total_amt"]) {
							// Old Invoice Amount > New Invoice Amount
							debug("Old invoice amt > new invoice amt");
							if ($origInv["ar_settle_amt"] >= $newInv["Invoice"]["total_amt"]) {
								$extraAR = $origInv["ar_settle_amt"] - $newInv["Invoice"]["total_amt"];
								$newInv["Invoice"]["ar_sts"] = Invoice::AR_STS_SETTLE;
								$newInv["Invoice"]["ar_settle_amt"] = $newInv["Invoice"]["total_amt"];
								
								// Allocate extra AR amount to other invoices
								$remainArAmt = $this->Invoice->settleInvoice($origInv["cust_cd"], $extraAR, $id);
								if ($remainArAmt > 0) {
									debug("Settle extra AR to other invoices");
									$arByCustModel->unallocateAR($origInv["cust_cd"], $remainArAmt);
								}
							}
						}
						else {
							// New Invoice Amount >= Old Invoice Amount
							debug("New invoice amt > Old invoice amt");
							if ($origInv["ar_sts"] == Invoice::AR_STS_SETTLE) {
								debug("Allocate AR");
								$remainInvAmt = $arByCustModel->allocateAR($origInv["cust_cd"], $newInv["Invoice"]["total_amt"] - $origInv["ar_settle_amt"]);
								
								if ($remainInvAmt > 0) {
									// Unsettle other invoices
									$remainInvAmt = $this->Invoice->unsettleInvoice($origInv["cust_cd"], $remainInvAmt, $id);
								}
								
								if ($remainInvAmt <= 0) {
									// Fully settle
									$newInv["Invoice"]["ar_sts"] = Invoice::AR_STS_SETTLE;
									$newInv["Invoice"]["ar_settle_amt"] = $newInv["Invoice"]["total_amt"];
								}
								else {
									// Partly settle
									$newInv["Invoice"]["ar_sts"] = Invoice::AR_STS_UNSETTLE;
									$newInv["Invoice"]["ar_settle_amt"] = $newInv["Invoice"]["total_amt"] - $remainInvAmt;
								}
							}
						}
						
						// Update SO Detail
						if (isset($soDetailList)) {
							foreach ($soDetailList as $item) {
								$soDetailModel->save($item, false, array("inv_qty", "sts"));
							}
						}
						
						ClassRegistry::init('So')->completeSO($newInv["Invoice"]["sell_order_id"]);
						
						// Update invoice
						if ($this->Invoice->saveAll($newInv, array('validate'=>false))) {
							$success_msg = 'Update invoice ['.$id.'] successfully!';
						}
						else {
							// Save fail
							$error_msg = 'There was a problem with your modification';
							$isSuccess = false;
						}
					}
				}
				else {
					// Validation fail
					$error_msg = 'There was a problem with your modification';
					$isSuccess = false;
				}
			} catch (Exception $e) {
				$error_msg = 'There was a problem with your modification! '.$e->getMessage();
				$isSuccess = false;
			}
		}

		if (isset($success_msg)) $this->set('success_msg', $success_msg);
		if (isset($error_msg)) $this->set('error_msg', $error_msg);

		if ($isSuccess) {
			$this->create();
		}
		else {
			$this->maintInit();
			$this->render('maint');
		}
	}
	
	function list_all() {
		$count = $this->Invoice->find('count');
		$limit = Configure::read('page.limit');
		$pageCount = intval(ceil($count / $limit));

		$data = $this->Invoice->find('all', array(
										'limit' => $limit,
										'offset' => 0,
										'order' => 'Invoice.id desc')
								);
		
		$paging = array(
			'pageCount' => $pageCount,
			'page' => 1,
			'order' => 'Invoice.id desc'
		);
		$this->set('paging', $paging);				
		$this->set('data', $data);
		
		$this->layout = 'search_form';
		$this->render('search');
	}
	
	function search() {
		$this->searchInvoices(false);
		
		$this->layout = 'blank';
		$this->viewPath = 'elements'.DS.'invoices'; 
        $this->render('paging');
	}
	
	function genCVS() {
		$this->searchInvoices(true);
		
		$this->layout = 'blank'; 
        $this->render('excel_file');
	}
	
	function searchInvoices($isCVS) {
		$url = $this->params['url'];
		$condition = array();
		$paging = array();
		$limit = Configure::read('page.limit');
		
		if (!empty($url['id'])) {
			$condition['Invoice.id'] = $url['id'];
			$paging['id'] = $url['id'];
		}
		if (!empty($url['cust_cd'])) {
			$condition['lower(Customer.cust_cd) LIKE'] = '%'.strtolower($url['cust_cd']).'%';
			$paging['cust_cd'] = $url['cust_cd'];
		}
		if (!empty($url['prod_cd'])) {
			$condition['lower(InvoiceDetail.prod_cd) LIKE'] = '%'.strtolower($url['prod_cd']).'%';
			$paging['prod_cd'] = $url['prod_cd'];
		}
		if (!empty($url['inv_date_from'])) {
			$condition['Invoice.inv_date >= '] = $url['inv_date_from'];
			$paging['inv_date_from'] = $url['inv_date_from'];
		}
		if (!empty($url['inv_date_to'])) {
			$condition['Invoice.inv_date <= '] = $url['inv_date_to'];
			$paging['inv_date_to'] = $url['inv_date_to'];
		}
		
		if (!empty($this->params['url']['order'])) {
			$order = $this->params['url']['order'];
		}
		else {
			$order = 'Invoice.id asc';
		}

		if ($isCVS) {
			$this->Invoice->bindModelForSearch();
			$data = $this->Invoice->find('all', array(
			    'conditions' => $condition,
			    'contain' => array('Customer', 'InvoiceDetail'),
			    'fields' => array('DISTINCT Invoice.*, Customer.cust_cd'),
				'order' => $order)
			);
			
			$this->set('data', $data);
		}
		else {
		
			if (!empty($url['pageCount'])) {
				$pageCount = $url['pageCount'];
			}
			else {
				$this->Invoice->bindModelForSearch();
				$count = $this->Invoice->find('count', array(
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
			
			$this->Invoice->recursive = 0;
			$this->Invoice->bindModelForSearch();
			$data = $this->Invoice->find('all', array(
			    'conditions' => $condition,
			    'contain' => array('Customer', 'InvoiceDetail'),
			    'fields' => array('DISTINCT Invoice.*'),
				'limit' => $limit,
				'offset' => $limit * ($page - 1) ,
				'order' => $order)
			);
			
			$this->set('paging', $paging);
			$this->set('data', $data);
		}
	}

	function genPdf($id) {
		$this->Invoice->recursive = 2;
		$so = $this->Invoice->find(array('Invoice.id' => $id));
		
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