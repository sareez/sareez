<?php
class Int_Dailydeals_Block_Sidebar extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
	
    public function runningDeal() {
	
	  $show_leftside = Mage::getStoreConfig('dailydeals/sidebar_settings/leftside');
	  $qty_num = Mage::getStoreConfig('dailydeals/sidebar_settings/qty_num');
	  
	  if($show_leftside==1){
    	$collection = Mage::getModel('dailydeals/dailydeals')->getCollection()->addFieldToFilter('deal_status' ,'Running')->setPageSize($qty_num)->getData();   
			return $collection;
		}
    }
    
     public function ispopular() {
    	$is_popular = Mage::getStoreConfig('dailydeals/settings/populared');
    	return $is_popular;
    }
    
    
    
}