<?php
class Int_Dailydeals_Block_Sidebarone extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
	
    public function todayDeal() {
	
    	$collection = Mage::getModel('dailydeals/dailydeals')->getCollection()->addFieldToFilter('deal_status' ,'Running')->getData(); 
         		foreach($collection as $each):
				 $startdate=$each['date_start'];
				 $enddate=$each['date_end'];
				 $id=$each['dailydeals_id'];
				 $qty=$each['deal_qty'];
				 $storeId= Mage::app()->getStore()->getStoreId();
					$storename=Mage::getModel('core/store')->load($storeId)->getName();
					$deal_store_id=$each['store_id'];
					$ret_comma=strpos($deal_store_id,',');
					if($ret_comma==1){
					$storeIdss=explode(",",$deal_store_id);
					}else{
					$storeIdss[]=$deal_store_id;					
					}
					
					
					
				 if(in_array($storeId,$storeIdss) || in_array('0',$storeIdss)){
				 
				 if($qty>0){
				 $read = Mage::getSingleton('core/resource')->getConnection('core_read');
				$query=$read->fetchAll("SELECT TIMEDIFF('".$enddate."',NOW( )) AS diff");
				$compdate[$id]=$query[0]['diff'];
				
				
		        $min_comp= min($compdate);
		        $key = array_search($min_comp, $compdate); 
				}
				}
		 endforeach;
		 return $key ;
		// return $collection ;
		
    }
    
   
    
    
    
}