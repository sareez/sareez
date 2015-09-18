<?php
class Last_Viewed_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/viewed?id=15 
    	 *  or
    	 * http://site.com/viewed/id/15 	
    	 */
    	/* 
		$viewed_id = $this->getRequest()->getParam('id');

  		if($viewed_id != null && $viewed_id != '')	{
			$viewed = Mage::getModel('viewed/viewed')->load($viewed_id)->getData();
		} else {
			$viewed = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($viewed == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$viewedTable = $resource->getTableName('viewed');
			
			$select = $read->select()
			   ->from($viewedTable,array('viewed_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$viewed = $read->fetchRow($select);
		}
		Mage::register('viewed', $viewed);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}