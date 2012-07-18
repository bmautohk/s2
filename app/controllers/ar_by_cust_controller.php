<?php
class ArByCustController extends AppController {
	var $name = 'ArByCust';
	var $helpers = array('Html','Javascript', 'Form');
	
	function maintInit() {
		$this->layout = 'layout_1280';
	}
	
	function create() {
		$ArByCust['ArByCust']['settle_date'] = date("Y-m-d");
		
		if (!empty($this->params['url']['cust_cd'])) {
			$ArByCust['ArByCust']['cust_cd'] = $this->params['url']['cust_cd'];
		}
		
		$this->data = $ArByCust;
		$this->maintInit();
		$this->render('maint');
	}
	
	function edit() {
		if (!empty($this->params['url']['id'])) {
			$id = $this->params['url']['id'];
			$arByCust = $this->ArByCust->find(array('ArByCust.id' => $id));
		}
		else {
			$so = null;
		}

		$this->data = $arByCust;
		$this->maintInit();
		$this->render('maint');
	}
	
	function save() {
		$isSuccess = false;
		
		if ( !empty($this->data) ) {
			$id = $this->data['ArByCust']['id'];
			
			$isCreate = false;
			if (empty($id)) {
				$isCreate = true;
			}
			
			$saveData = $this->data;
			if ($isCreate) {
				$saveData['ArByCust']['create_by'] = 'Tester';
				$saveData['ArByCust']['create_date'] = DboSource::expression('NOW()');
			}
			else {
				unset($saveData['ArByCust']['cust_cd']);
				unset($saveData['ArByCust']['settle_date']);
			}
			$saveData['ArByCust']['last_update_by'] = 'Tester';
			$saveData['ArByCust']['last_update_date'] = DboSource::expression('NOW()');

			if (!$isCreate) {
				unset($this->ArByCust->validate['cust_cd']);
				unset($this->ArByCust->validate['settle_date']);
			}
			
			$this->ArByCust->set($saveData);
			if ($this->ArByCust->validates()) {
				if ($isCreate) {
					// Create AR
					$invoiceModel = ClassRegistry::init('Invoice');
					$arAmt = $invoiceModel->settleInvoice($saveData['ArByCust']['cust_cd'], $saveData['ArByCust']['amt'], 0);
					
					if ($arAmt <= 0) {
						// All amount are settled
						$saveData['ArByCust']['settle_amt'] = $saveData['ArByCust']['amt'];
						$saveData['ArByCust']['sts'] = ArByCust::STS_INACTIVE;
					}
					else {
						$saveData['ArByCust']['settle_amt'] = $saveData['ArByCust']['amt'] - $arAmt;
					}
					
					$this->ArByCust->save($saveData, array('validate' => false));
					$id = $this->ArByCust->getLastInsertId();
					$success_msg = 'Create AR ['.$id.'] successfully!';
					$isSuccess = true;
				}
				else {
					// Update AR
					unset($saveData['ArByCust']['cust_cd']);
					
					// Get original AR
					$origAr = $this->ArByCust->find('first', array('conditions'=>array('id'=>$id), 'recursive' => -1));
					$origARAmt = $origAr['ArByCust']['amt'];
					$newARAmt = $saveData['ArByCust']['amt'];

					if ($newARAmt == $origARAmt) {
						// Nothing to do
					}
					else if ($newARAmt > $origARAmt) {
						$arSts = $origAr['ArByCust']['sts'];
						if ($arSts == ArByCust::STS_INACTIVE ) {
							// Settle invoice
							$invoiceModel = ClassRegistry::init('Invoice');
							$remainARAmt = $invoiceModel->settleInvoice($origAr['ArByCust']['cust_cd'], $newARAmt - $origARAmt, 0);
							
							if ($remainARAmt <= 0) {
								// All amount are settled
								$saveData['ArByCust']['settle_amt'] = $saveData['ArByCust']['amt'];
								$saveData['ArByCust']['sts'] = ArByCust::STS_INACTIVE;
							}
							else {
								$saveData['ArByCust']['settle_amt'] = $origAr['ArByCust']['settle_amt'] + ($newARAmt - $origARAmt - $remainARAmt);
								$saveData['ArByCust']['sts'] = ArByCust::STS_ACTIVE;
							}
						}
					}
					else {
						$settleAmt = $origAr['ArByCust']['settle_amt'];;
						if ($newARAmt < $settleAmt) {
							// Unsettle invoice
							$invoiceModel = ClassRegistry::init('Invoice');
							$arAmt = $invoiceModel->unsettleInvoice($origAr['ArByCust']['cust_cd'], $settleAmt - $newARAmt, 0);
							$saveData['ArByCust']['settle_amt'] = $newARAmt;
							$saveData['ArByCust']['sts'] = ArByCust::STS_INACTIVE;
						}
					}
					
					$this->ArByCust->save($saveData, array('validate' => false));
					$success_msg = 'Update AR ['.$id.'] successfully!';
					$isSuccess = true;
				}
			} else {
				$error_msg = 'There was a problem with your modification';
			}
		}

		if (isset($success_msg)) $this->set('success_msg', $success_msg);
		if (isset($error_msg)) $this->set('error_msg', $error_msg);
		
		if ($isSuccess) {
			$this->data = NULL;
			$this->create();
		}
		else {
			$this->maintInit();
		$this->render('maint');
		}
	}
	
	function list_all() {
		$count = $this->ArByCust->find('count');
		$limit = Configure::read('page.limit');
		$pageCount = intval(ceil($count / $limit));
									
		$data = $this->ArByCust->find('all', array(
												'limit' => $limit,
												'offset' => 0,
												'order' => 'ArByCust.id desc')
									);
		
		$paging = array(
			'pageCount' => $pageCount,
			'page' => 1,
			'order' => 'ArByCust.id desc'
		);
		$this->set('paging', $paging);				
		$this->set('data', $data);
		
		$this->layout = 'search_form';
		$this->render('search');
	}
	
	function search() {
		$this->searchAR(false);
		
		$this->layout = 'blank';
		$this->viewPath = 'elements'.DS.'arbycust'; 
        $this->render('paging');
	}
	
	function genCVS() {
		$this->searchAR(true);
		
		$this->layout = 'blank'; 
        $this->render('excel_file');
	}
	
	function searchAR($isCVS) {
		$url = $this->params['url'];
		$condition = array();
		$paging = array();
		$limit = Configure::read('page.limit');

		if (!empty($url['invoice_id'])) {
			$condition['lower(invoice_id) LIKE'] = '%'.strtolower($url['invoice_id']).'%';
			$paging['invoice_id'] = $url['invoice_id'];
		}
		if (!empty($url['cust_cd'])) {
			$condition['lower(cust_cd) LIKE'] = '%'.strtolower($url['cust_cd']).'%';
			$paging['cust_cd'] = $url['cust_cd'];
		}
		if (!empty($url['cheque_no'])) {
			$condition['lower(cheque_no) LIKE'] = '%'.strtolower($url['cheque_no']).'%';
			$paging['cheque_no'] = $url['cheque_no'];
		}
		if (!empty($url['settle_date_from'])) {
			$condition['settle_date >= '] = $url['settle_date_from'];
			$paging['settle_date_from'] = $url['settle_date_from'];
		}
		if (!empty($url['settle_date_to'])) {
			$condition['settle_date <= '] = $url['settle_date_to'];
			$paging['settle_date_to'] = $url['settle_date_to'];
		}
		if (!empty($url['amt'])) {
			$condition['amt >= '] = $url['amt'];
			$paging['amt'] = $url['amt'];
		}
		
		if (!empty($this->params['url']['order'])) {
			$order = $this->params['url']['order'];
		}
		else {
			$order = 'ArByCust.id asc';
		}
		
		if ($isCVS) {
			$data = $this->ArByCust->find('all', array(
				'conditions' => $condition,
				'order' => $order));
			
			$this->set('data', $data);
		}
		else {
			if (!empty($url['pageCount'])) {
				$pageCount = $url['pageCount'];
			}
			else {
				$count = $this->ArByCust->find('count', array(
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

			$data = $this->ArByCust->find('all', array(
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