<?php
class Sn_Sorder_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/sorder?id=15 
    	 *  or
    	 * http://site.com/sorder/id/15 	
    	 */
    	/* 
		$id = $this->getRequest()->getParam('id');

  		if($id != null && $id != '')	{
			$sorder = Mage::getModel('sorder/sorder')->load($id)->getData();
		} else {
			$sorder = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($sorder == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$sorderTable = $resource->getTableName('sorder');
			
			$select = $read->select()
			   ->from($sorderTable,array('id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$sorder = $read->fetchRow($select);
		}
		Mage::register('sorder', $sorder);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}