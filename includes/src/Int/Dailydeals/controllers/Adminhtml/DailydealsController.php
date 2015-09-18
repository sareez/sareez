<?php

class Int_Dailydeals_Adminhtml_DailydealsController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('dailydeals/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
	
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('dailydeals/dailydeals')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('dailydeals_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('dailydeals/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('dailydeals/adminhtml_dailydeals_edit'))
				->_addLeft($this->getLayout()->createBlock('dailydeals/adminhtml_dailydeals_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('dailydeals')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
		
			if(empty($data['related_product1'])){ 
				unset($data['related_product']);					 
			} else {
				$data['related_product'] = 	$data['related_product1'];
			}
			
			
			 $dstart = $data['date_start'];
			 
			 if(substr_count($dstart, 'VORM.') > 0) {
			 $dstart = str_replace('VORM.','AM', $dstart);
			 }
			 
			 if(substr_count($dstart, 'NACHM.') > 0) {
			 $dstart = str_replace('NACHM.','PM', $dstart);
			 }
			 
			$data['date_start'] = date("Y-m-d H:i:s", strtotime($dstart));
			
			
			$dend = $data['date_end'];
			
			if(substr_count($dend, 'VORM.') > 0) {
			 $dend = str_replace('VORM.','AM', $dend);
			 }
			
			 if(substr_count($dend, 'NACHM.') > 0) {
			 $dend = str_replace('NACHM.','PM', $dend);
			 }
			
		   $data['date_end'] = date("Y-m-d H:i:s", strtotime($dend));
			 
			
			
			
		 if(isset($data['stores'])) {
                  $stores = $data['stores'];
                  $storesCount = count($stores);
                  $storesIndex = 1;
                  $storesData = '';
                  foreach($stores as $store) {
                   $storesData .= $store;
                   if($storesIndex < $storesCount) {
                    $storesData .= ',';
                   }
                   $storesIndex++;
                  }
                  $data['store_id'] = $storesData;
                 } 
		
		
                $status = $data['status']; 
              
                if($status==1) {
                	  
					$datestart = $data['date_start'];
					$dateend = $data['date_end'];
        
				  $date_start=date('Y-m-d H:i:s' ,strtotime($datestart));
					$date_end=date('Y-m-d H:i:s' ,strtotime($dateend));

					$read = Mage::getSingleton('core/resource')->getConnection('core_read');
					$query=$read->fetchAll("SELECT TIMEDIFF( NOW() , '".$date_start."') AS diff");
					
					$query1=$read->fetchAll("SELECT TIMEDIFF('".$date_end."', NOW( )) AS diffend");
					$diff=$query[0]['diff'];
					$diffend=$query1[0]['diffend'];

					if($diffend < 0) {
					$data['deal_status'] = 'Ended';
					} elseif($diff < 0) {    
					$data['deal_status'] = 'Queued';
					} elseif($diffend >0 && $diff >=0 ) {
					$data['deal_status'] = 'Running';
					}

             
                } else {
                	   $data['deal_status'] = 'Disabled';
                }
			

			if($data['related_product']){
				$_pro = Mage::getModel('catalog/product')->load($data['related_product']);
				$orgspecialprice = $_pro->getspecial_price();
				$data['orgsplprice'] = $orgspecialprice;
				$_pro->setspecial_price($data['deal_price']);
				$_pro->save();	
			} else {
				unset($data['orgsplprice']);
			}
			
			Mage::getSingleton('catalog/product_action')->updateAttributes($ProductIds, $attributeData, $storeId);
			
			$model = Mage::getModel('dailydeals/dailydeals');		
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
			
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}	
				
				$model->save();
				
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('dailydeals')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('dailydeals')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('dailydeals/dailydeals');
				 
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $dailydealsIds = $this->getRequest()->getParam('dailydeals');
        if(!is_array($dailydealsIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($dailydealsIds as $dailydealsId) {
                    $dailydeals = Mage::getModel('dailydeals/dailydeals')->load($dailydealsId);
                    $dailydeals->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($dailydealsIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
    public function massStatusAction()
    {
        $dailydealsIds = $this->getRequest()->getParam('dailydeals');
        if(!is_array($dailydealsIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($dailydealsIds as $dailydealsId) {
                    $dailydeals = Mage::getSingleton('dailydeals/dailydeals')
                        ->load($dailydealsId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($dailydealsIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    public function exportCsvAction()
    {
        $fileName   = 'dailydeals.csv';
        $content    = $this->getLayout()->createBlock('dailydeals/adminhtml_dailydeals_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'dailydeals.xml';
        $content    = $this->getLayout()->createBlock('dailydeals/adminhtml_dailydeals_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
}
?>