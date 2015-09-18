<?php
class Most_ViewPurchased_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/viewpurchased?id=15 
    	 *  or
    	 * http://site.com/viewpurchased/id/15 	
    	 */
    	/* 
		$viewpurchased_id = $this->getRequest()->getParam('id');

  		if($viewpurchased_id != null && $viewpurchased_id != '')	{
			$viewpurchased = Mage::getModel('viewpurchased/viewpurchased')->load($viewpurchased_id)->getData();
		} else {
			$viewpurchased = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($viewpurchased == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$viewpurchasedTable = $resource->getTableName('viewpurchased');
			
			$select = $read->select()
			   ->from($viewpurchasedTable,array('viewpurchased_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$viewpurchased = $read->fetchRow($select);
		}
		Mage::register('viewpurchased', $viewpurchased);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}