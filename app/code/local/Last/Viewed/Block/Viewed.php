<?php
class Last_Viewed_Block_Viewed extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getViewed()     
     { 
        if (!$this->hasData('viewed')) {
            $this->setData('viewed', Mage::registry('viewed'));
        }
        return $this->getData('viewed');
        
    }
	
	
	
	public function getMostViewedSeven(){
		
	///////////////////////////// Most Viewd Last 7 days >>
	$productCount = 12;
	// store ID
	$storeId    = Mage::app()->getStore()->getId();
	// get today and last 30 days time
	$today = time();
	$last = $today - (60*60*24*7);
	
	
	$from = date("Y-m-d", $last);
	$to = date("Y-m-d", $today);
	// get most viewed products for last 30 days
	$products_most_viewed7 = Mage::getResourceModel('reports/product_collection')
		->addAttributeToSelect('*')	
		->setStoreId($storeId)
		->addStoreFilter($storeId)
		->addViewsCount()
		->addViewsCount($from, $to)
		->addAttributeToSort("entity_id","desc")
		->setPageSize($productCount);
		Mage::getSingleton('catalog/product_status')
		->addVisibleFilterToCollection($products_most_viewed7);
		Mage::getSingleton('catalog/product_visibility')
		->addVisibleInCatalogFilterToCollection($products_most_viewed7);
		return $products_most_viewed7;
                
               // print_r($products_most_viewed7);                exit();
	}
	
	
	
	
	public function getMostViewedFourteen(){
		
	///////////////////////////// Most Viewd Last 14 days >>
	// ->addAttributeToSort('news_from_date', 'asc')
	$productCount14 = 12;
	// store ID
	$storeId14    = Mage::app()->getStore()->getId();
	// get today and last 30 days time
	//  - (6 * 24 * 60 * 60)
	$today14 = time();
	$last14 = $today14 - (60*60*24*14);
	
	$from14 = date("Y-m-d", $last14);
	$to14 = date("Y-m-d", $today14);
	// get most viewed products for last 30 days
	$products_most_viewed14 = Mage::getResourceModel('reports/product_collection')
		->addAttributeToSelect('*')	
		->setStoreId($storeId14)
		->addStoreFilter($storeId14)
		->addViewsCount()
		->addViewsCount($from14, $to14)
		->addAttributeToSort("entity_id","desc")
		->setPageSize($productCount14);
		Mage::getSingleton('catalog/product_status')
		->addVisibleFilterToCollection($products_most_viewed14);
		Mage::getSingleton('catalog/product_visibility')
		->addVisibleInCatalogFilterToCollection($products_most_viewed14); 
	
	return $products_most_viewed14;
	}
	
	
	public function getMostViewedThirty(){
		// ->addAttributeToSort('news_from_date', 'desc')
	///////////////////////////// Most Viewd Last 30 days >>
	$productCount = 12;
	// store ID
	$storeId    = Mage::app()->getStore()->getId();
	// get today and last 30 days time
	// - (3 * 24 * 60 * 60)
	$today = time();
	$last = $today - (60*60*24*30);
	
	$from = date("Y-m-d", $last);
	$to = date("Y-m-d", $today);
	// get most viewed products for last 30 days
	$products_most_viewed30 = Mage::getResourceModel('reports/product_collection')
	->addAttributeToSelect('*')	
	->setStoreId($storeId)
	->addStoreFilter($storeId)
	->addViewsCount()
	->addViewsCount($from, $to)
	
	
	->addAttributeToSort("entity_id","desc")
	->setPageSize($productCount);
	
	
	
	Mage::getSingleton('catalog/product_status')
	->addVisibleFilterToCollection($products_most_viewed30);
	Mage::getSingleton('catalog/product_visibility')
	->addVisibleInCatalogFilterToCollection($products_most_viewed30);
	
	return $products_most_viewed30;
	}
	
	
	
	public function getMostPurchasedSeven(){
	//////////////////////////////// Best Selling Products For 7 Days
	// number of products to display
	$productCount_bs7 = 12;
	// store ID
	$storeId_bs7 = Mage::app()->getStore()->getId();
	
	// get today and last 30 days time
	$today_bs7 = time();
	$last_bs7 = $today_bs7 - (60*60*24*7);
	
	$from_bs7 = date("Y-m-d", $last_bs7);
	$to_bs7 = date("Y-m-d", $today_bs7);
	// get most viewed products for current category
	$products_bs7 = Mage::getResourceModel('reports/product_collection')
		->addAttributeToSelect('*')	
		->addOrderedQty($from_bs7, $to_bs7)
		->setStoreId($storeId_bs7)
		->addStoreFilter($storeId_bs7)	
		->setOrder('ordered_qty', 'desc')
		->setPageSize($productCount_bs7);
		Mage::getSingleton('catalog/product_status')
		->addVisibleFilterToCollection($products_bs7);
		Mage::getSingleton('catalog/product_visibility')
		->addVisibleInCatalogFilterToCollection($products_bs7);
	
	return $products_bs7;
	 }
	
	public function getMostPurchasedFourteen(){
		 
	//////////////////////////////// Best Selling Products For 14 Days
	// number of products to display
	$productCount_bs14 = 12;
	// store ID
	$storeId_bs14 = Mage::app()->getStore()->getId();
	
	// get today and last 30 days time
	//  - (6 * 24 * 60 * 60)
	$today_bs14 = time();
	$last_bs14 = $today_bs14 - (60*60*24*14);
	
	$from_bs14 = date("Y-m-d", $last_bs14);
	$to_bs14 = date("Y-m-d", $today_bs14);
	// get most viewed products for current category
	$products_bs14 = Mage::getResourceModel('reports/product_collection')
		->addAttributeToSelect('*')	
		->addOrderedQty($from_bs14, $to_bs14)
		->setStoreId($storeId_bs14)
		->addStoreFilter($storeId_bs14)	
		->setOrder('ordered_qty', 'desc')
		->setPageSize($productCount_bs14);
		Mage::getSingleton('catalog/product_status')
		->addVisibleFilterToCollection($products_bs14);
		Mage::getSingleton('catalog/product_visibility')
		->addVisibleInCatalogFilterToCollection($products_bs14);

	  return $products_bs14;
	 }
	 
	public function getMostPurchasedThirty(){
		
//////////////////////////////// Best Selling Products For 30 Days
	// number of products to display
	$productCount_bs30 = 12;
	// store ID
	$storeId_bs30 = Mage::app()->getStore()->getId();
	 
	// get today and last 30 days time
	// $today_bs30 = time() - (12 * 24 * 60 * 60);
	//  - (3 * 24 * 60 * 60)
	 $today_bs30 = time();
	$last_bs30 = $today_bs30 - (60*60*24*30);
	 
	$from_bs30 = date("Y-m-d", $last_bs30);
	$to_bs30 = date("Y-m-d", $today_bs30);
	// get most viewed products for current category
	$products_bs30 = Mage::getResourceModel('reports/product_collection')
		->addAttributeToSelect('*')	
		->addOrderedQty($from_bs30, $to_bs30)
		->setStoreId($storeId_bs30)
		->addStoreFilter($storeId_bs30)	
		->setOrder('ordered_qty', 'desc')
		->setPageSize($productCount_bs30);
		Mage::getSingleton('catalog/product_status')
		->addVisibleFilterToCollection($products_bs30);
		Mage::getSingleton('catalog/product_visibility')
		->addVisibleInCatalogFilterToCollection($products_bs30);

return $products_bs30;
	 }
	 
	 
	 
	 
}