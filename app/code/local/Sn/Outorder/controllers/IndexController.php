<?php
class Sn_Outorder_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/outorder?id=15 
    	 *  or
    	 * http://site.com/outorder/id/15 	
    	 */
    	/* 
		$outorder_id = $this->getRequest()->getParam('id');

  		if($outorder_id != null && $outorder_id != '')	{
			$outorder = Mage::getModel('outorder/outorder')->load($outorder_id)->getData();
		} else {
			$outorder = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($outorder == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$outorderTable = $resource->getTableName('outorder');
			
			$select = $read->select()
			   ->from($outorderTable,array('outorder_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$outorder = $read->fetchRow($select);
		}
		Mage::register('outorder', $outorder);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}