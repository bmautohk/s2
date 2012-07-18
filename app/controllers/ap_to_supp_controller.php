<?php
class ApToSuppController extends AppController {
	var $name = 'ApToSupp';
	var $helpers = array('Html','Javascript', 'Form');
	
	function maintInit() {
		$this->layout = 'layout_1280';
	}
	
	function create() {
		$ApToSupp['ApToSupp']['payment_date'] = date("Y-m-d");
		
		if (!empty($this->params['url']['supplier_cd'])) {
			$ApToSupp['ApToSupp']['supplier_cd'] = $this->params['url']['supplier_cd'];
		}
		
		$this->data = $ApToSupp;
		$this->maintInit();
		$this->render('maint');
	}
	
	function edit() {
		if (!empty($this->params['url']['id'])) {
			$id = $this->params['url']['id'];
			$ApToSupp = $this->ApToSupp->find(array('ApToSupp.id' => $id));
		}
		else {
			$so = null;
		}

		$this->data = $ApToSupp;
		$this->maintInit();
		$this->render('maint');
	}
	
	function save() {
		$isSuccess = false;
		
		if ( !empty($this->data) ) {
			$id = $this->data['ApToSupp']['id'];
			
			$isCreate = false;
			if (empty($id)) {
				$isCreate = true;
			}
			
			$saveData = $this->data;
			if ($isCreate) {
				$saveData['ApToSupp']['create_by'] = 'Tester';
				$saveData['ApToSupp']['create_date'] = DboSource::expression('NOW()');
			}
			else {
				unset($saveData['ApToSupp']['cust_cd']);
				unset($saveData['ApToSupp']['settle_date']);
			}
			$saveData['ApToSupp']['last_update_by'] = 'Tester';
			$saveData['ApToSupp']['last_update_date'] = DboSource::expression('NOW()');

			if (!$isCreate) {
				unset($this->ApToSupp->validate['supplier_cd']);
				unset($this->ApToSupp->validate['payment_date']);
			}
			
			$this->ApToSupp->set($saveData);
			if ($this->ApToSupp->validates()) {
				if ($isCreate) {
					// Create AP
					$poModel = ClassRegistry::init('Po');
					$apAmt = $poModel->settlePO($saveData['ApToSupp']['supplier_cd'], $saveData['ApToSupp']['amt'], 0);
					
					if ($apAmt <= 0) {
						// All amount are settled
						$saveData['ApToSupp']['settle_amt'] = $saveData['ApToSupp']['amt'];
						$saveData['ApToSupp']['sts'] = ApToSupp::STS_INACTIVE;
					}
					else {
						$saveData['ApToSupp']['settle_amt'] = $saveData['ApToSupp']['amt'] - $apAmt;
					}
					
					$this->ApToSupp->save($saveData, array('validate' => false));
					$id = $this->ApToSupp->getLastInsertId();
					$success_msg = 'Create AP ['.$id.'] successfully!';
					$isSuccess = true;
				}
				else {
					// Update AP
					unset($saveData['ApToSupp']['supplier_cd']);
					
					// Get original AP
					$origAp = $this->ApToSupp->find('first', array('conditions'=>array('id'=>$id), 'recursive' => -1));
					$origAPAmt = $origAp['ApToSupp']['amt'];
					$newAPAmt = $saveData['ApToSupp']['amt'];

					if ($newAPAmt == $origAPAmt) {
						// Nothing to do
					}
					else if ($newAPAmt > $origAPAmt) {
						$apSts = $origAp['ApToSupp']['sts'];
						if ($apSts == ApToSupp::STS_INACTIVE) {
							// Settle PO
							$poModel = ClassRegistry::init('Po');
							$remainAPAmt = $poModel->settlePO($origAp['ApToSupp']['supplier_cd'], $newAPAmt - $origAPAmt, 0);
							
							if ($remainAPAmt <= 0) {
								// All amount are settled
								$saveData['ApToSupp']['settle_amt'] = $saveData['ApToSupp']['amt'];
								$saveData['ApToSupp']['sts'] = ApToSupp::STS_INACTIVE;
							}
							else {
								$saveData['ApToSupp']['settle_amt'] = $origAp['ApToSupp']['settle_amt'] + ($newAPAmt - $origAPAmt - $remainAPAmt);
								$saveData['ApToSupp']['sts'] = ApToSupp::STS_ACTIVE;
							}
						}
					}
					else {
						$settleAmt = $origAp['ApToSupp']['settle_amt'];;
						if ($newAPAmt < $settleAmt) {
							// Unsettle PO
							$poModel = ClassRegistry::init('Po');
							$apAmt = $poModel->unsettlePO($origAp['ApToSupp']['supplier_cd'], $settleAmt - $newAPAmt, 0);
							$saveData['ApToSupp']['settle_amt'] = $newAPAmt;
							$saveData['ApToSupp']['sts'] = ApToSupp::STS_INACTIVE;
						}
					}
					
					$this->ApToSupp->save($saveData, array('validate' => false));
					$success_msg = 'Update AP ['.$id.'] successfully!';
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
		$count = $this->ApToSupp->find('count');
		$limit = Configure::read('page.limit');
		$pageCount = intval(ceil($count / $limit));
									
		$data = $this->ApToSupp->find('all', array(
												'limit' => $limit,
												'offset' => 0,
												'order' => 'ApToSupp.id desc')
									);
		
		$paging = array(
			'pageCount' => $pageCount,
			'page' => 1,
			'order' => 'ApToSupp.id desc'
		);
		$this->set('paging', $paging);				
		$this->set('data', $data);
		
		$this->layout = 'search_form';
		$this->render('search');
	}
	
	function search() {
		$this->searchAP(false);
		
		$this->layout = 'blank';
		$this->viewPath = 'elements'.DS.'aptosupp'; 
        $this->render('paging');
	}
	
	function genCVS() {
		$this->searchAP(true);
		
		$this->layout = 'blank'; 
        $this->render('excel_file');
	}
	
	function searchAP($isCVS) {
		$url = $this->params['url'];
		$condition = array();
		$paging = array();
		$limit = Configure::read('page.limit');
		
		if (!empty($url['ap_id'])) {
			$condition['lower(id) LIKE'] = '%'.strtolower($url['ap_id']).'%';
			$paging['ap_id'] = $url['ap_id'];
		}
		if (!empty($url['po_id'])) {
			$condition['lower(po_id) LIKE'] = '%'.strtolower($url['po_id']).'%';
			$paging['po_id'] = $url['po_id'];
		}
		if (!empty($url['so_id'])) {
			$condition['lower(so_id) LIKE'] = '%'.strtolower($url['so_id']).'%';
			$paging['so_id'] = $url['so_id'];
		}
		if (!empty($url['invoice_id'])) {
			$condition['lower(invoice_id) LIKE'] = '%'.strtolower($url['invoice_id']).'%';
			$paging['invoice_id'] = $url['invoice_id'];
		}
		if (!empty($url['supplier_cd'])) {
			$condition['lower(supplier_cd) LIKE'] = '%'.strtolower($url['supplier_cd']).'%';
			$paging['supplier_cd'] = $url['supplier_cd'];
		}
		if (!empty($url['payment_date_from'])) {
			$condition['payment_date >= '] = $url['payment_date_from'];
			$paging['payment_date_from'] = $url['payment_date_from'];
		}
		if (!empty($url['payment_date_to'])) {
			$condition['payment_date <= '] = $url['payment_date_to'];
			$paging['payment_date_to'] = $url['payment_date_to'];
		}
		if (!empty($url['cheque_no'])) {
			$condition['lower(cheque_no) LIKE'] = '%'.strtolower($url['cheque_no']).'%';
			$paging['cheque_no'] = $url['cheque_no'];
		}
		if (!empty($url['amt'])) {
			$condition['amt >= '] = $url['amt'];
			$paging['amt'] = $url['amt'];
		}
		
		if (!empty($this->params['url']['order'])) {
			$order = $this->params['url']['order'];
		}
		else {
			$order = 'ApToSupp.id asc';
		}
		
		if ($isCVS) {
			$data = $this->ApToSupp->find('all', array(
				'conditions' => $condition,
				'order' => $order));
			
			$this->set('data', $data);
		}
		else {
			if (!empty($url['pageCount'])) {
				$pageCount = $url['pageCount'];
			}
			else {
				$count = $this->ApToSupp->find('count', array(
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

			$data = $this->ApToSupp->find('all', array(
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