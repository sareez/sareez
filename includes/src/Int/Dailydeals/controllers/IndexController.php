<?php
class Int_Dailydeals_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
			//$model->setData($data)
				
				//$model->save();
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/dailydeals?id=15 
    	 *  or
    	 * http://site.com/dailydeals/id/15 	
    	 */
    	/* 
		$dailydeals_id = $this->getRequest()->getParam('id');

  		if($dailydeals_id != null && $dailydeals_id != '')	{
			$dailydeals = Mage::getModel('dailydeals/dailydeals')->load($dailydeals_id)->getData();
		} else {
			$dailydeals = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($dailydeals == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$dailydealsTable = $resource->getTableName('dailydeals');
			
			$select = $read->select()
			   ->from($dailydealsTable,array('dailydeals_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$dailydeals = $read->fetchRow($select);
		}
		Mage::register('dailydeals', $dailydeals);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}
?>