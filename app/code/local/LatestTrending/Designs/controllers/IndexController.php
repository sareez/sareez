<?php
class LatestTrending_Designs_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/designs?id=15 
    	 *  or
    	 * http://site.com/designs/id/15 	
    	 */
    	/* 
		$designs_id = $this->getRequest()->getParam('id');

  		if($designs_id != null && $designs_id != '')	{
			$designs = Mage::getModel('designs/designs')->load($designs_id)->getData();
		} else {
			$designs = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($designs == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$designsTable = $resource->getTableName('designs');
			
			$select = $read->select()
			   ->from($designsTable,array('designs_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$designs = $read->fetchRow($select);
		}
		Mage::register('designs', $designs);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}