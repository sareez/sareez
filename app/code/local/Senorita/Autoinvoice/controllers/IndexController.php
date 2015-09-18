<?php
class Senorita_Autoinvoice_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/autoinvoice?id=15 
    	 *  or
    	 * http://site.com/autoinvoice/id/15 	
    	 */
    	/* 
		$autoinvoice_id = $this->getRequest()->getParam('id');

  		if($autoinvoice_id != null && $autoinvoice_id != '')	{
			$autoinvoice = Mage::getModel('autoinvoice/autoinvoice')->load($autoinvoice_id)->getData();
		} else {
			$autoinvoice = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($autoinvoice == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$autoinvoiceTable = $resource->getTableName('autoinvoice');
			
			$select = $read->select()
			   ->from($autoinvoiceTable,array('autoinvoice_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$autoinvoice = $read->fetchRow($select);
		}
		Mage::register('autoinvoice', $autoinvoice);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}