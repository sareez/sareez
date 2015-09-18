<?php
class Sareez_Ordercsv_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/ordercsv?id=15 
    	 *  or
    	 * http://site.com/ordercsv/id/15 	
    	 */
    	/* 
		$ordercsv_id = $this->getRequest()->getParam('id');

  		if($ordercsv_id != null && $ordercsv_id != '')	{
			$ordercsv = Mage::getModel('ordercsv/ordercsv')->load($ordercsv_id)->getData();
		} else {
			$ordercsv = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($ordercsv == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$ordercsvTable = $resource->getTableName('ordercsv');
			
			$select = $read->select()
			   ->from($ordercsvTable,array('ordercsv_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$ordercsv = $read->fetchRow($select);
		}
		Mage::register('ordercsv', $ordercsv);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}