<?php

class Sareez_Coupon_Adminhtml_CouponController extends Mage_Adminhtml_Controller_Action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('coupon/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('coupon/coupon')->load($id);
		
		

		

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('coupon_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('coupon/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('coupon/adminhtml_coupon_edit'))
				->_addLeft($this->getLayout()->createBlock('coupon/adminhtml_coupon_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('coupon')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			
			if(isset($_FILES['filename']['name']) && $_FILES['filename']['name'] != '') {
				try {	
					/* Starting upload */	
					$uploader = new Varien_File_Uploader('filename');
					
					// Any extention would work
	           		$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
					$uploader->setAllowRenameFiles(false);
					
					// Set the file upload mode 
					// false -> get the file directly in the specified folder
					// true -> get the file in the product like folders 
					//	(file.jpg will go in something like /media/f/i/file.jpg)
					$uploader->setFilesDispersion(false);
							
					// We set media as the upload dir
					$path = Mage::getBaseDir('media') . DS ;
					$uploader->save($path, $_FILES['filename']['name'] );
					
				} catch (Exception $e) {
		      
		        }
	        
		        //this way the name is saved in DB
	  			$data['filename'] = $_FILES['filename']['name'];
			}
	  			
	  			
			$model = Mage::getModel('coupon/coupon');		
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
			
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}	
				
				
						////////////// Coupon Insert >>
						
						
	$write = Mage::getSingleton('core/resource')->getConnection('core_write');
	$readresult=$write->query("SELECT * FROM `coupon` where coupon_id ='".$this->getRequest()->getParam('id')."'");
	while ($row = $readresult->fetch())
	{
	 $coupon_qty = $row['coupon_qty'];
	}
						
		$this->getRequest()->getParam('coupon_qty');
		/*for($c=1; $c<=$coupon_qty; $c++)
		{*/
		for($c=1; $c<=$this->getRequest()->getParam('coupon_qty'); $c++)
		{
		
			$coupon = rand(1,9).rand(1,9).'-'.rand(1,9).rand(1,9);
			$write = Mage::getSingleton('core/resource')->getConnection('core_write');
			$sql  = "INSERT INTO generatedcoupon set
			
						coupon_id = '".$model->getId()."',
						coupon_code = '$coupon',
						status = 'Y'";
						
			$write->query($sql);

		}
		////////////// << Coupon Insert
		
		
		///////////////// Edit Multiselect Value >>		
		$data = $this->getRequest()->getPost();
		
/*		echo "<pre>";
		print_r($data);
		echo "</pre>";
		exit;*/
		
		foreach ($data as $key => $value)
        {
            if (is_array($value))
            {
				// echo $key;
				
				if($key=="product_category")
				{
				 // echo $data[$key] = implode(',',$this->getRequest()->getParam($key)); 
			     $category .= implode(',',$this->getRequest()->getParam($key)); 
				}
				
				
				if($this->getRequest()->getParam('user')=="")
				{
				 $user = "";
				} else {
				
				if($key=="user")
				{
				 // echo $data[$key] = implode(',',$this->getRequest()->getParam($key)); 
			     $user .= implode(',',$this->getRequest()->getParam($key)); 
				}
				
				}
			  
			  
            }
        }   
		

		
		 // exit;
		 
		 
		 
		 
 
	$id = $this->getRequest()->getParam('id');
	$data = array(
	
		'product_category' 		=> $category, 
		'user' 					=> $user,
		'title' 				=> $this->getRequest()->getParam('title'),
		'status' 				=> $this->getRequest()->getParam('status'),
		'content' 				=> $this->getRequest()->getParam('content'),
		'no_of_prd'				=> $this->getRequest()->getParam('no_of_prd'),
		'action' 				=> $this->getRequest()->getParam('action'),
		'discount_amount' 		=> $this->getRequest()->getParam('discount_amount'),
		'min_amnt' 				=> $this->getRequest()->getParam('min_amnt'),
		'multiple_coupon' 		=> $this->getRequest()->getParam('multiple_coupon'),
		'coupon_qty' 			=> '0',
		'product_level' 		=> $this->getRequest()->getParam('product_level'),
		'discount_level' 		=> $this->getRequest()->getParam('discount_level'),
		'special_price' 		=> $this->getRequest()->getParam('special_price')
	
	);
	
	
	$model = Mage::getModel('coupon/coupon')->load($id)->addData($data);
	// $model->setId($id)->save();
	try {
		 $model->setId($id)->save();
		 echo "Data updated successfully.";
		} catch (Exception $e){
		 echo $e->getMessage(); 
		}
		 
		 
		 
		/////////////////////////////////////////////////////////////////////
		
				
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('coupon')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back', true)) {
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('coupon')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('coupon/coupon');
				 
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
        $couponIds = $this->getRequest()->getParam('coupon');
        if(!is_array($couponIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($couponIds as $couponId) {
                    $coupon = Mage::getModel('coupon/coupon')->load($couponId);
                    $coupon->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($couponIds)
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
        $couponIds = $this->getRequest()->getParam('coupon');
        if(!is_array($couponIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($couponIds as $couponId) {
                    $coupon = Mage::getSingleton('coupon/coupon')
                        ->load($couponId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($couponIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    public function exportCsvAction()
    {
        $fileName   = 'coupon.csv';
        $content    = $this->getLayout()->createBlock('coupon/adminhtml_coupon_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'coupon.xml';
        $content    = $this->getLayout()->createBlock('coupon/adminhtml_coupon_grid')
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