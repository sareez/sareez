<?php
class Senorita_Tailormaster_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/tailormaster?id=15 
    	 *  or
    	 * http://site.com/tailormaster/id/15 	
    	 */
    	/* 
		$tailormaster_id = $this->getRequest()->getParam('id');

  		if($tailormaster_id != null && $tailormaster_id != '')	{
			$tailormaster = Mage::getModel('tailormaster/tailormaster')->load($tailormaster_id)->getData();
		} else {
			$tailormaster = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($tailormaster == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$tailormasterTable = $resource->getTableName('tailormaster');
			
			$select = $read->select()
			   ->from($tailormasterTable,array('tailormaster_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$tailormaster = $read->fetchRow($select);
		}
		Mage::register('tailormaster', $tailormaster);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}