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
    
	public function submitAction()
    {
    	
    	$data = $this->getRequest()->getParams();
    	unset($data['measurement_id']);
    	
    	try{
    		Mage::getModel('measurement/measurement')->setData($data)->save();
    		$msg = "Data has been successfully saved";
    		Mage::getSingleton('core/session')->addSuccess($msg);
    		return $this->_redirect('measurement/index/'.$data['measurement_type']);
    	} catch(Exception $e){
    		$msg = "Data has not been saved";
    		Mage::getSingleton('core/session')->addError($msg);
    		return $this->_redirect('measurement/index/'.$data['measurement_type']);	
    	}
    	
    }
    
 	public function formPostAction()
    {
    	print_r($_REQUEST);
    	exit();
    	
    }
}