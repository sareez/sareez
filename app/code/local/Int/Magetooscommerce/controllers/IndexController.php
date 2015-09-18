<?php
class Int_Magetooscommerce_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/magetooscommerce?id=15 
    	 *  or
    	 * http://site.com/magetooscommerce/id/15 	
    	 */
    	/* 
		$magetooscommerce_id = $this->getRequest()->getParam('id');

  		if($magetooscommerce_id != null && $magetooscommerce_id != '')	{
			$magetooscommerce = Mage::getModel('magetooscommerce/magetooscommerce')->load($magetooscommerce_id)->getData();
		} else {
			$magetooscommerce = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($magetooscommerce == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$magetooscommerceTable = $resource->getTableName('magetooscommerce');
			
			$select = $read->select()
			   ->from($magetooscommerceTable,array('magetooscommerce_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$magetooscommerce = $read->fetchRow($select);
		}
		Mage::register('magetooscommerce', $magetooscommerce);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}