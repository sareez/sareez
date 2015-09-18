<?php
class Int_Catalogmaster_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/catalogmaster?id=15 
    	 *  or
    	 * http://site.com/catalogmaster/id/15 	
    	 */
    	/* 
		$catalogmaster_id = $this->getRequest()->getParam('id');

  		if($catalogmaster_id != null && $catalogmaster_id != '')	{
			$catalogmaster = Mage::getModel('catalogmaster/catalogmaster')->load($catalogmaster_id)->getData();
		} else {
			$catalogmaster = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($catalogmaster == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$catalogmasterTable = $resource->getTableName('catalogmaster');
			
			$select = $read->select()
			   ->from($catalogmasterTable,array('catalogmaster_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$catalogmaster = $read->fetchRow($select);
		}
		Mage::register('catalogmaster', $catalogmaster);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}