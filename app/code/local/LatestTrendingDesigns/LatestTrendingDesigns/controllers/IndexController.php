<?php
class LatestTrendingDesigns_LatestTrendingDesigns_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/latesttrendingdesigns?id=15 
    	 *  or
    	 * http://site.com/latesttrendingdesigns/id/15 	
    	 */
    	/* 
		$latesttrendingdesigns_id = $this->getRequest()->getParam('id');

  		if($latesttrendingdesigns_id != null && $latesttrendingdesigns_id != '')	{
			$latesttrendingdesigns = Mage::getModel('latesttrendingdesigns/latesttrendingdesigns')->load($latesttrendingdesigns_id)->getData();
		} else {
			$latesttrendingdesigns = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($latesttrendingdesigns == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$latesttrendingdesignsTable = $resource->getTableName('latesttrendingdesigns');
			
			$select = $read->select()
			   ->from($latesttrendingdesignsTable,array('latesttrendingdesigns_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$latesttrendingdesigns = $read->fetchRow($select);
		}
		Mage::register('latesttrendingdesigns', $latesttrendingdesigns);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}