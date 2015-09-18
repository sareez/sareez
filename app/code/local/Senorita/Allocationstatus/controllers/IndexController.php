<?php
class Senorita_Allocationstatus_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/allocationstatus?id=15 
    	 *  or
    	 * http://site.com/allocationstatus/id/15 	
    	 */
    	/* 
		$allocationstatus_id = $this->getRequest()->getParam('id');

  		if($allocationstatus_id != null && $allocationstatus_id != '')	{
			$allocationstatus = Mage::getModel('allocationstatus/allocationstatus')->load($allocationstatus_id)->getData();
		} else {
			$allocationstatus = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($allocationstatus == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$allocationstatusTable = $resource->getTableName('allocationstatus');
			
			$select = $read->select()
			   ->from($allocationstatusTable,array('allocationstatus_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$allocationstatus = $read->fetchRow($select);
		}
		Mage::register('allocationstatus', $allocationstatus);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}