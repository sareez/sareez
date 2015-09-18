<?php
class Int_Measurement_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/measurement?id=15 
    	 *  or
    	 * http://site.com/measurement/id/15 	
    	 */
    	/* 
		$measurement_id = $this->getRequest()->getParam('id');

  		if($measurement_id != null && $measurement_id != '')	{
			$measurement = Mage::getModel('measurement/measurement')->load($measurement_id)->getData();
		} else {
			$measurement = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($measurement == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$measurementTable = $resource->getTableName('measurement');
			
			$select = $read->select()
			   ->from($measurementTable,array('measurement_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$measurement = $read->fetchRow($select);
		}
		Mage::register('measurement', $measurement);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
    
    public function formAction()
    {
    	//die("In Form");
    	$this->loadLayout();     
		$this->renderLayout();
    }
    

    public function blouseAction()
    {
    	$this->loadLayout();     
		$this->renderLayout();
    }
    
    public function salwarAction()
    {
    	$this->loadLayout();     
		$this->renderLayout();
    }
     
    public function lehengaAction()
    {
    	$this->loadLayout();     
		$this->renderLayout();
    }
    
	public function viewallmeasurementAction()
    {
    	$this->loadLayout();     
		$this->renderLayout();
    }
	
	public function viewBlouseAction()
    {
    	$this->loadLayout();     
		$this->renderLayout();
    }
     
	public function editBlouseAction()
    {
    	$this->loadLayout();     
		$this->renderLayout();
    }
    
	public function viewSalwarAction()
    {
    	$this->loadLayout();     
		$this->renderLayout();
    }
     
	public function editSalwarAction()
    {
    	$this->loadLayout();     
		$this->renderLayout();
    }
    
	public function viewLehengaAction()
    {
    	$this->loadLayout();     
		$this->renderLayout();
    }
     
	public function editLehengaAction()
    {
    	$this->loadLayout();     
		$this->renderLayout();
    }
     
	public function readymadeBlouseAction()
    {
    	$this->loadLayout();     
		$this->renderLayout();
    }
     
	public function readymadeSalwarAction()
    {
    	$this->loadLayout();     
		$this->renderLayout();
    }
     
	public function readymadeLehengaAction()
    {
    	$this->loadLayout();     
		$this->renderLayout();
    }
	
	public function customblouseAction()
    {
    	$this->loadLayout();     
		$this->renderLayout();
    }
	
	public function customblousepopupAction()
    {
    	$this->loadLayout();     
		$this->renderLayout();
    }
	
	public function customlehengaAction()
    {
    	$this->loadLayout();     
		$this->renderLayout();
    }
	
	public function customlehengapopupAction()
    {
    	$this->loadLayout();     
		$this->renderLayout();
    }
	
	public function customsalwarAction()
    {
    	$this->loadLayout();     
		$this->renderLayout();
    }
	
	public function customsalwarpopupAction()
    {
    	$this->loadLayout();     
		$this->renderLayout();
    }
	
	public function measurementhistoryAction()
    {
    	$this->loadLayout();     
		$this->renderLayout();
    }
	
	
	   public function readymadehistoryAction()
    {
    	$this->loadLayout();     
		$this->renderLayout();
    }
	
	public function measurementhistorypopupAction()
    {
    	$this->loadLayout();     
		$this->renderLayout();
    }
	
	
	   public function readymadehistorypopupAction()
    {
    	$this->loadLayout();     
		$this->renderLayout();
    }
	
/*edit measurment action start	*/
	public function editcustomblousepopupAction()
    {
    	$this->loadLayout();     
		$this->renderLayout();
    }
	
	public function editcustomsalwarpopupAction()
    {
    	$this->loadLayout();     
		$this->renderLayout();
    }
	
	public function editcustomlehengapopupAction()
    {
    	$this->loadLayout();     
		$this->renderLayout();
    }
/*edit measurment action end	*/	
    
	public function submitAction()
    {
    	
    	$data = $this->getRequest()->getParams();
        $data['doi'] =  date("Y-m-d H:i:s");		
		
    	unset($data['measurement_id']);
    	
    	try{
    		$modelmeasurement  =  Mage::getModel('measurement/measurement')->setData($data)->save();
			$lastInsertid  = $modelmeasurement->getId();	
			
			if(Mage::getSingleton('customer/session')->isLoggedIn())
		 {
		     $customerId = Mage::getModel('customer/session')->getCustomer()->getId();
		 }	
			
		$measurementforuser = array();
		$measurementforuser['user_id'] = $customerId;
		$measurementforuser['products_id'] = 0;
		$measurementforuser['measurement_id'] = $lastInsertid;		
		 Mage::getModel('measurement/measurementforuser')->setData($measurementforuser)->save();
			
			
    		$msg = "Data has been successfully saved";
    		Mage::getSingleton('core/session')->addSuccess($msg);
    		return $this->_redirect('measurement/index/'.$data['measurement_type']);
    	} catch(Exception $e){
    		$msg = "Data has not been saved";
    		Mage::getSingleton('core/session')->addError($msg);
    		return $this->_redirect('measurement/index/'.$data['measurement_type']);	
    	}
    	
    }
    
    public function submitcustommeasurementpopupAction()
    {
    	$data = $this->getRequest()->getParams();
        $data['doi'] =  date("Y-m-d H:i:s");
		
		$requst_data = '';
		$requst_data .= $data[body_garment].",";
		$requst_data .= $data[around_bust].",";
		$requst_data .= $data[around_above_waist].",";
		$requst_data .= $data[shoulder].",";
		$requst_data .= $data[sleeve_length].",";
		$requst_data .= $data[sleeve_style].",";
		$requst_data .= $data[around_arm_hole].",";
		$requst_data .= $data[around_arm].",";
		$requst_data .= $data[front_neck_depth].",";
		$requst_data .= $data[front_neck_style].",";
		$requst_data .= $data[back_neck_depth].",";
		$requst_data .= $data[back_neck_style].",";
		$requst_data .= $data[blouse_length].",";
		$requst_data .= $data[petticoat_length].",";
        $requst_data .= $data[around_bottom].",";
		$requst_data .= $data[around_thigh].",";
		$requst_data .= $data[around_knee].",";
		$requst_data .= $data[around_calf].",";
		$requst_data .= $data[around_ankle].",";
		$requst_data .= $data[churidar_style].",";
		$requst_data .= $data[lehenga_length].",";
		$requst_data .= $data[closing_side].",";
		$requst_data .= $data[closing_with].",";
		$requst_data .= $data[lining].",";
		$requst_data .= $data[around_waist].",";
		$requst_data .= $data[around_hips].",";
		$requst_data .= $data[your_height].",";
		$requst_data .= $data[your_height].",";
		$requst_data .= $data[kameez_length].",";
		$requst_data .= $data[kameez_style].",";
		$requst_data .= $data[salwar_length].",";
		$requst_data .= $data[salwar_style].",";
		$requst_data .= $data[salwar_fitings].",";
		$requst_data .= $data[choli_length].",";
		$requst_data .= $data[lehnga_style].",";
		$requst_data .= $data[elastic].",";		
		$requst_data .= $data[instructions];
		$requst_data = trim($requst_data);
		echo '----------------------<br/>';
		$measurement_id = $data[measurement_id];
		
    	$measurement = Mage::getModel('measurement/measurement')->load($measurement_id)->getData();
		//echo 'ssss'.$data[measurement_id];
		//echo '<pre>'; print_r($measurement);
		$saved_data .= '';
		$saved_data .= $measurement[body_garment].",";
		$saved_data .= $measurement[around_bust].",";
		$saved_data .= $measurement[around_above_waist].",";
		$saved_data .= $measurement[shoulder].",";
		$saved_data .= $measurement[sleeve_length].",";
		$saved_data .= $measurement[sleeve_style].",";
		$saved_data .= $measurement[around_arm_hole].",";
		$saved_data .= $measurement[around_arm].",";
		$saved_data .= $measurement[front_neck_depth].",";
		$saved_data .= $measurement[front_neck_style].",";
		$saved_data .= $measurement[back_neck_depth].",";
		$saved_data .= $measurement[back_neck_style].",";
		$saved_data .= $measurement[blouse_length].",";
		$saved_data .= $measurement[petticoat_length].",";
		$saved_data .= $measurement[around_bottom].",";
		$saved_data .= $measurement[around_thigh].",";
		$saved_data .= $measurement[around_knee].",";
		$saved_data .= $measurement[around_calf].",";
		$saved_data .= $measurement[around_ankle].",";
		$saved_data .= $measurement[churidar_style].",";
		$saved_data .= $measurement[lehenga_length].",";
		$saved_data .= $measurement[closing_side].",";
		$saved_data .= $measurement[closing_with].",";
		$saved_data .= $measurement[lining].",";
		$saved_data .= $measurement[around_waist].",";
		$saved_data .= $measurement[around_hips].",";
		$saved_data .= $measurement[your_height].",";
		$saved_data .= $measurement[your_height].",";
		$saved_data .= $measurement[kameez_length].",";
		$saved_data .= $measurement[kameez_style].",";
		$saved_data .= $measurement[salwar_length].",";
		$saved_data .= $measurement[salwar_style].",";
		$saved_data .= $measurement[salwar_fitings].",";
		$saved_data .= $measurement[choli_length].",";
		$saved_data .= $measurement[lehnga_style].",";
		$saved_data .= $measurement[elastic].",";
		$saved_data .= $measurement[instructions];
		$saved_data = trim($saved_data);		
		
    	//unset($data['measurement_id']);
    	
    	try{
			if($data[measurement_id]==''){ 
			unset($data['measurement_id']);	
			$modelmeasurement  =  Mage::getModel('measurement/measurement')->setData($data)->save();
			$lastInsertid  = $modelmeasurement->getId();	
			}
			else if($data[measurement_id]!='' && ($requst_data != $saved_data)){ 
			unset($data['measurement_id']);
			$data['measurement_name'] .= ' (Updated on '.date("Y-m-d H:i:s").')';
			$modelmeasurement  =  Mage::getModel('measurement/measurement')->setData($data)->save();
			$lastInsertid  = $modelmeasurement->getId();	
			}
			else
			{ 
			$lastInsertid = $data[measurement_id];
			}	
			
			$customerId = $data[cust_id];	
			
			$measurementforuser = array();
			$measurementforuser['user_id'] = $customerId;
			$measurementforuser['products_id'] = $data['products_id'];
			$measurementforuser['order_id'] = $data['order_id'];
			$measurementforuser['measurement_id'] = $lastInsertid;		
			Mage::getModel('measurement/measurementforuser')->setData($measurementforuser)->save();
			
			
			$msg = "Data has been successfully saved";
			//Mage::getSingleton('core/session')->addSuccess($msg);
			$redirect_url = "index.php/admin/sales_order/view/order_id/".$data['order_id']."/key/bb273d1ed6188bc688fd3fe8ad99c756/";
			//$this->_redirect($redirect_url);
			
?>
			<script type="text/javascript">
                window.close();
                window.opener.location.href = window.opener.location.href;
            </script>
<?php		
    	} catch(Exception $e){
			$msg = "Data has not been saved";
			Mage::getSingleton('core/session')->addError($msg);
			//$redirect_url = "sales/order/view/order_id/".$data['order_id']."/";
			$redirect_url = "index.php/admin/sales_order/view/order_id/".$data['order_id']."/key/bb273d1ed6188bc688fd3fe8ad99c756/";
			$this->_redirect($redirect_url);
    	}
    	
    }
	
	public function editsubmitcustommeasurementpopupAction()
    {
    	$data = $this->getRequest()->getParams();
	
	
        $data['doi'] =  date("Y-m-d H:i:s");		
		
    	//unset($data['measurement_id']);
    	
    	try{
			$modelmeasurement  =  Mage::getModel('measurement/measurement')->setData($data)->save();
			$msg = "Data has been successfully saved";
			Mage::getSingleton('core/session')->addSuccess($msg);
			$redirect_url = "index.php/admin/sales_order/view/order_id/".$data['order_id']."/key/bb273d1ed6188bc688fd3fe8ad99c756/";
			//$this->_redirect($redirect_url);
			
?>
			<script type="text/javascript">
                window.close();
                window.opener.location.href = window.opener.location.href;
            </script>
<?php		
    	} catch(Exception $e){
			$msg = "Data has not been saved";
			Mage::getSingleton('core/session')->addError($msg);
			//$redirect_url = "sales/order/view/order_id/".$data['order_id']."/";
			$redirect_url = "index.php/admin/sales_order/view/order_id/".$data['order_id']."/key/bb273d1ed6188bc688fd3fe8ad99c756/";
			$this->_redirect($redirect_url);
    	}
    	
    }
    
	
    public function submitcustommeasurementAction()
    {
    	$data = $this->getRequest()->getParams();
        $data['doi'] =  date("Y-m-d H:i:s");		
		//echo '<pre>'; print_r($data);
		
		$requst_data = '';
		$requst_data .= $data[body_garment].",";
		$requst_data .= $data[around_bust].",";
		$requst_data .= $data[around_above_waist].",";
		$requst_data .= $data[shoulder].",";
		$requst_data .= $data[sleeve_length].",";
		$requst_data .= $data[sleeve_style].",";
		$requst_data .= $data[around_arm_hole].",";
		$requst_data .= $data[around_arm].",";
		$requst_data .= $data[front_neck_depth].",";
		$requst_data .= $data[front_neck_style].",";
		$requst_data .= $data[back_neck_depth].",";
		$requst_data .= $data[back_neck_style].",";
		$requst_data .= $data[blouse_length].",";
		$requst_data .= $data[petticoat_length].",";
        $requst_data .= $data[around_bottom].",";
		$requst_data .= $data[around_thigh].",";
		$requst_data .= $data[around_knee].",";
		$requst_data .= $data[around_calf].",";
		$requst_data .= $data[around_ankle].",";
		$requst_data .= $data[churidar_style].",";
		$requst_data .= $data[lehenga_length].",";
		$requst_data .= $data[closing_side].",";
		$requst_data .= $data[closing_with].",";
		$requst_data .= $data[lining].",";
		$requst_data .= $data[around_waist].",";
		$requst_data .= $data[around_hips].",";
		$requst_data .= $data[your_height].",";
		$requst_data .= $data[your_height].",";
		$requst_data .= $data[kameez_length].",";
		$requst_data .= $data[kameez_style].",";
		$requst_data .= $data[salwar_length].",";
		$requst_data .= $data[salwar_style].",";
		$requst_data .= $data[salwar_fitings].",";
		$requst_data .= $data[choli_length].",";
		$requst_data .= $data[lehnga_style].",";
		$requst_data .= $data[elastic].",";		
		$requst_data .= $data[instructions];
		echo $requst_data = trim($requst_data);
		echo '----------------------<br/>';
		$measurement_id = $data[measurement_id];
		
    	$measurement = Mage::getModel('measurement/measurement')->load($measurement_id)->getData();
		//echo 'ssss'.$data[measurement_id];
		//echo '<pre>'; print_r($measurement);
		$saved_data .= '';
		$saved_data .= $measurement[body_garment].",";
		$saved_data .= $measurement[around_bust].",";
		$saved_data .= $measurement[around_above_waist].",";
		$saved_data .= $measurement[shoulder].",";
		$saved_data .= $measurement[sleeve_length].",";
		$saved_data .= $measurement[sleeve_style].",";
		$saved_data .= $measurement[around_arm_hole].",";
		$saved_data .= $measurement[around_arm].",";
		$saved_data .= $measurement[front_neck_depth].",";
		$saved_data .= $measurement[front_neck_style].",";
		$saved_data .= $measurement[back_neck_depth].",";
		$saved_data .= $measurement[back_neck_style].",";
		$saved_data .= $measurement[blouse_length].",";
		$saved_data .= $measurement[petticoat_length].",";
		$saved_data .= $measurement[around_bottom].",";
		$saved_data .= $measurement[around_thigh].",";
		$saved_data .= $measurement[around_knee].",";
		$saved_data .= $measurement[around_calf].",";
		$saved_data .= $measurement[around_ankle].",";
		$saved_data .= $measurement[churidar_style].",";
		$saved_data .= $measurement[lehenga_length].",";
		$saved_data .= $measurement[closing_side].",";
		$saved_data .= $measurement[closing_with].",";
		$saved_data .= $measurement[lining].",";
		$saved_data .= $measurement[around_waist].",";
		$saved_data .= $measurement[around_hips].",";
		$saved_data .= $measurement[your_height].",";
		$saved_data .= $measurement[your_height].",";
		$saved_data .= $measurement[kameez_length].",";
		$saved_data .= $measurement[kameez_style].",";
		$saved_data .= $measurement[salwar_length].",";
		$saved_data .= $measurement[salwar_style].",";
		$saved_data .= $measurement[salwar_fitings].",";
		$saved_data .= $measurement[choli_length].",";
		$saved_data .= $measurement[lehnga_style].",";
		$saved_data .= $measurement[elastic].",";
		$saved_data .= $measurement[instructions];
		echo $saved_data = trim($saved_data);
		
		/*if(strcmp(trim($requst_data),trim($saved_data))==0){
			echo "SAME1";
		} else {
			echo "NOT SAME1";
		}*/
    	//die;
    	try{
			if($data[measurement_id]==''){ 
			unset($data['measurement_id']);	
			$modelmeasurement  =  Mage::getModel('measurement/measurement')->setData($data)->save();
			$lastInsertid  = $modelmeasurement->getId();	
			}
			else if($data[measurement_id]!='' && ($requst_data != $saved_data)){ 
			unset($data['measurement_id']);
			$data['measurement_name'] .= ' (Updated on '.date("Y-m-d H:i:s").')';
			$modelmeasurement  =  Mage::getModel('measurement/measurement')->setData($data)->save();
			$lastInsertid  = $modelmeasurement->getId();	
			}
			else
			{ 
			$lastInsertid = $data[measurement_id];
			}
			if(Mage::getSingleton('customer/session')->isLoggedIn())
			{
			 $customerId = Mage::getModel('customer/session')->getCustomer()->getId();
			}	
			
			$measurementforuser = array();
			$measurementforuser['user_id'] = $customerId;
			$measurementforuser['products_id'] = $data['products_id'];
			$measurementforuser['order_id'] = $data['order_id'];
			$measurementforuser['measurement_id'] = $lastInsertid;		
			Mage::getModel('measurement/measurementforuser')->setData($measurementforuser)->save();
			
			
			$msg = "Data has been successfully saved";
			Mage::getSingleton('core/session')->addSuccess($msg);
			$redirect_url = "sales/order/view/order_id/".$data['order_id']."/";
			$this->_redirect($redirect_url);
			
    	} catch(Exception $e){
			$msg = "Data has not been saved";
			Mage::getSingleton('core/session')->addError($msg);
			$redirect_url = "sales/order/view/order_id/".$data['order_id']."/";
			$this->_redirect($redirect_url);
    	}
    	
    }
    	
	
 	public function formPostAction()
    {
    	print "<pre>";
	print_r($_REQUEST);
    	exit();
    	
    }
	public function submitreadymadeblouseAction()
    {
	
	if(!Mage::helper('customer')->isLoggedIn())
	{				
	    Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::getUrl('customer/account/'.Mage::helper('core')->urlEncode(Mage::getUrl('quoteproduct/index/Viewquote'))));
	}
	
	$data = $this->getRequest()->getParams();
	
		
	
	$measurementforreadymade = array();
	
    $measurementforreadymade['readymade_type'] = $data['readymade_type'];
	$measurementforreadymade['blouse_rdmd_reasymade_size'] = $data['blouse_rdmd_reasymade_size'];
	$measurementforreadymade['blouse_rdmd_sleeves_length'] = $data['blouse_rdmd_sleeves_length'];
	$measurementforreadymade['blouse_rdmd_length'] = $data['blouse_rdmd_length'];
	$measurementforreadymade['petticoat_rdmd_length'] = $data['petticoat_rdmd_length'];
	$measurementforreadymade['instructions'] = $data['instructions'];
	
	
	if(isset($data['readymadeSubmit']))
	{
	    if((!$data['readymade_id']))
	    {
		
		 if(Mage::getSingleton('customer/session')->isLoggedIn())
		 {
		     $customerId = Mage::getModel('customer/session')->getCustomer()->getId();
		 }	
		
		$modelreadymade = Mage::getModel('measurement/measurementforreadymade')
		->setData($measurementforreadymade);
		$modelreadymade->save();
		
		
		$lastInsertid  = $modelreadymade->getId();		
		$measurementforuser = array();
		$measurementforuser['user_id'] = $customerId;
		$measurementforuser['products_id'] = $data['products_id'];
		$measurementforuser['readymade_id'] = $lastInsertid;
		$measurementforuser['order_id'] = $data['order_id'];	
		Mage::getModel('measurement/measurementforuser')->setData($measurementforuser)->save();
		$message = $this->__('Information Added Successfully.');
					Mage::getSingleton('checkout/session')->addSuccess($message);
		
	    }
	    else
	    {
		//$measurementforreadymade['readymade_id'] = $data['readymade_id'];
				
		Mage::getModel('measurement/measurementforreadymade')->setData($measurementforreadymade)
		->setId($data['readymade_id'])
		->save();
		
		$message = $this->__('Information Updated Successfully.');
					Mage::getSingleton('checkout/session')->addSuccess($message);
		
	    }
	    
	    $redirect_url = "sales/order/view/order_id/".$data['order_id']."/";
	    $this->_redirect($redirect_url);
	}
    	
    	
    }
	
	
	
	
	
	
	
	
	
	public function submitreadymadesalwarAction()
    {
	
	if(!Mage::helper('customer')->isLoggedIn())
	{				
	    Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::getUrl('customer/account/'.Mage::helper('core')->urlEncode(Mage::getUrl('quoteproduct/index/Viewquote'))));
	}
	
	$data = $this->getRequest()->getParams();
	
		
	
	$measurementforreadymade = array();	
  
	
	$measurementforreadymade['readymade_type'] = $data['readymade_type'];
	$measurementforreadymade['suit_rdmd_readymade_size'] = $data['suit_rdmd_readymade_size'];
	$measurementforreadymade['suit_rdmd_height'] = $data['suit_rdmd_height'];
	$measurementforreadymade['suit_rdmd_height_2'] = $data['suit_rdmd_height_2'];
	$measurementforreadymade['suit_rdmd_sleeves_length'] = $data['suit_rdmd_sleeves_length'];
	$measurementforreadymade['instructions'] = $data['instructions'];
	
	
	if(isset($data['readymadeSubmit']))
	{
	    if((!$data['readymade_id']))
	    {
		
		 if(Mage::getSingleton('customer/session')->isLoggedIn())
		 {
		     $customerId = Mage::getModel('customer/session')->getCustomer()->getId();
		 }	
		
		$modelreadymade = Mage::getModel('measurement/measurementforreadymade')
		->setData($measurementforreadymade);
		$modelreadymade->save();
		
		
		$lastInsertid  = $modelreadymade->getId();		
		$measurementforuser = array();
		$measurementforuser['user_id'] = $customerId;
		$measurementforuser['products_id'] = $data['products_id'];
		$measurementforuser['readymade_id'] = $lastInsertid;
		$measurementforuser['order_id'] = $data['order_id'];	
		Mage::getModel('measurement/measurementforuser')->setData($measurementforuser)->save();
		$message = $this->__('Information Added Successfully.');
					Mage::getSingleton('checkout/session')->addSuccess($message);
		
	    }
	    else
	    {
		//$measurementforreadymade['readymade_id'] = $data['readymade_id'];
				
		Mage::getModel('measurement/measurementforreadymade')->setData($measurementforreadymade)
		->setId($data['readymade_id'])
		->save();
		
		$message = $this->__('Information Updated Successfully.');
					Mage::getSingleton('checkout/session')->addSuccess($message);
		
	    }
	    
	     $redirect_url = "sales/order/view/order_id/".$data['order_id']."/";
	    $this->_redirect($redirect_url);
	}
    	
    	
    }
	
	
	public function submitreadymadelehengaAction()
    {
	
	if(!Mage::helper('customer')->isLoggedIn())
	{				
	    Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::getUrl('customer/account/'.Mage::helper('core')->urlEncode(Mage::getUrl('quoteproduct/index/Viewquote'))));
	}
	
	$data = $this->getRequest()->getParams();
	$measurementforreadymade = array();	
	$measurementforreadymade['readymade_type'] = $data['readymade_type'];
	$measurementforreadymade['lehenga_rdmd_readymade_size'] = $data['lehenga_rdmd_readymade_size'];
	$measurementforreadymade['lehenga_rdmd_height'] = $data['lehenga_rdmd_height'];
	$measurementforreadymade['lehenga_rdmd_height_2'] = $data['lehenga_rdmd_height_2'];
	$measurementforreadymade['lehenga_rdmd_sleeves_length'] = $data['lehenga_rdmd_sleeves_length'];
	$measurementforreadymade['instructions'] = $data['instructions'];
	$measurementforreadymade['choli_rdmd_length'] = $data['choli_rdmd_length'];
	$measurementforreadymade['lehenga_rdmd_waist'] = $data['lehenga_rdmd_waist'];
	
	
	
	
	if(isset($data['readymadeSubmit']))
	{
	    if((!$data['readymade_id']))
	    {
		
		 if(Mage::getSingleton('customer/session')->isLoggedIn())
		 {
		     $customerId = Mage::getModel('customer/session')->getCustomer()->getId();
		 }	
		
		$modelreadymade = Mage::getModel('measurement/measurementforreadymade')->setData($measurementforreadymade);
		$modelreadymade->save();
		
		
		$lastInsertid  = $modelreadymade->getId();		
		$measurementforuser = array();
		$measurementforuser['user_id'] = $customerId;
		$measurementforuser['products_id'] = $data['products_id'];
		$measurementforuser['readymade_id'] = $lastInsertid;
		$measurementforuser['order_id'] = $data['order_id'];	
		Mage::getModel('measurement/measurementforuser')->setData($measurementforuser)->save();
		$message = $this->__('Information Added Successfully.');
		Mage::getSingleton('checkout/session')->addSuccess($message);
		
	    }
	    else
	    {
		//$measurementforreadymade['readymade_id'] = $data['readymade_id'];
				
		Mage::getModel('measurement/measurementforreadymade')->setData($measurementforreadymade)->setId($data['readymade_id'])->save();
		
		$message = $this->__('Information Updated Successfully.');
		Mage::getSingleton('checkout/session')->addSuccess($message);
		
	    }
	     $redirect_url = "sales/order/view/order_id/".$data['order_id']."/";
	  
	    $this->_redirect($redirect_url); 
	}
	
	
	
    	
    	
    }
	
	
}