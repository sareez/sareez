<?php
class Int_Dailydeals_Block_Dailydeals extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
	
		$this->getLayout()->getBlock('head')->setTitle('Active Deals'); 
		$this->getLayout()->getBlock('breadcrumbs')
                ->addCrumb('home', array('label' => Mage::helper('catalogsearch')->__('Home'),
                    'title' => Mage::helper('catalogsearch')->__('Go to Home Page'),
                    'link' => Mage::getBaseUrl())
                )
                ->addCrumb('dailydeals', array('label' => Mage::helper('dailydeals')->__('Dailydeals'))
        );
     
		return parent::_prepareLayout();
    }
    
     public function getDailydeals()     
     { 
        if (!$this->hasData('dailydeals')) {
            $this->setData('dailydeals', Mage::registry('dailydeals'));
        }
        return $this->getData('dailydeals');
        
    }
	public function getDailydealsCollection()     
     { 
     
     	$currentdate =  Date('m/d/y g:i A');
     	$convertcurrentdate = strtotime($currentdate);
     	
        if (!$this->hasData('dailydeals')) {
		 $collection = Mage::getModel('dailydeals/dailydeals')->getCollection();
            }
            
            foreach($collection as $each):			
				$qty 				= $each['deal_qty'];
				$datestart 			= $each['date_start'];
				$status 			= $each['status'];
				$dateend 			= $each['date_end'];
				$dealStatus 		= $each['deal_status'];
				$productVisibility	= Mage::getModel('catalog/product')->load($each['related_product'])->getVisibility(); 
				
				$date_start=date('Y-m-d H:i:s' ,strtotime($datestart));
				$date_end=date('Y-m-d H:i:s' ,strtotime($dateend));

				$read = Mage::getSingleton('core/resource')->getConnection('core_read');
				$query=$read->fetchAll("SELECT TIMEDIFF( NOW() , '".$date_start."') AS diff");					
				$query1=$read->fetchAll("SELECT TIMEDIFF('".$date_end."', NOW( )) AS diffend");
				$diff=$query[0]['diff'];
				$diffend=$query1[0]['diffend'];
									
             if($productVisibility != 1 && $diff > 0 && $diffend >= 0 && $qty > 0 && $status==1 && $dealStatus == 'Running') {
            	$deals[] = $each['dailydeals_id'];
             }
            endforeach;
        
            
            
            return $deals;
    }
	
	 public function columncountlist(){
	//$template = Mage::getStoreConfig('dailydeals/list_settings/dailydeals_list_layout');
$pageLayout=$this->getLayout()->getBlock('root')->getTemplate();
$template = str_replace("page/","",$pageLayout);
	if($template=="1column.phtml"){
		$column=5;
	} else if($template=="2columns-left.phtml"){
		$column=4;
	} else if($template=="2columns-right.phtml"){
		$column=4;
	} else if($template=="3columns.phtml"){
		$column=3;
	} else {
		$column=4;
	}
		return $column;
	}
}