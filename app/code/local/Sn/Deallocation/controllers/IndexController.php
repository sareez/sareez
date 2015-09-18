<?php
class Sn_Deallocation_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/deallocation?id=15 
    	 *  or
    	 * http://site.com/deallocation/id/15 	
    	 */
    	/* 
		$deallocation_id = $this->getRequest()->getParam('id');

  		if($deallocation_id != null && $deallocation_id != '')	{
			$deallocation = Mage::getModel('deallocation/deallocation')->load($deallocation_id)->getData();
		} else {
			$deallocation = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($deallocation == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$deallocationTable = $resource->getTableName('deallocation');
			
			$select = $read->select()
			   ->from($deallocationTable,array('deallocation_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$deallocation = $read->fetchRow($select);
		}
		Mage::register('deallocation', $deallocation);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}