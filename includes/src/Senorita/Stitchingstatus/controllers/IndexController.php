<?php
class Senorita_Stitchingstatus_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/stitchingstatus?id=15 
    	 *  or
    	 * http://site.com/stitchingstatus/id/15 	
    	 */
    	/* 
		$stitchingstatus_id = $this->getRequest()->getParam('id');

  		if($stitchingstatus_id != null && $stitchingstatus_id != '')	{
			$stitchingstatus = Mage::getModel('stitchingstatus/stitchingstatus')->load($stitchingstatus_id)->getData();
		} else {
			$stitchingstatus = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($stitchingstatus == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$stitchingstatusTable = $resource->getTableName('stitchingstatus');
			
			$select = $read->select()
			   ->from($stitchingstatusTable,array('stitchingstatus_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$stitchingstatus = $read->fetchRow($select);
		}
		Mage::register('stitchingstatus', $stitchingstatus);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}