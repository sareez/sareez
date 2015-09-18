<?php
class LatestTrendingDesigns_LatestTrendingDesigns_Block_LatestTrendingDesigns extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getLatestTrendingDesigns()     
     { 
       /* 
	    if (!$this->hasData('latesttrendingdesigns')) {
            $this->setData('latesttrendingdesigns', Mage::registry('latesttrendingdesigns'));
        }
        return $this->getData('latesttrendingdesigns');
        */
		
		
		//////////////////////////////// Best Selling Saree Category 
// order_id
// ->setOrder('ordered_qty', 'desc')
/*$saree = 9;
$_sareeCategory = Mage::getModel('catalog/category')->load(4);

$_sareeCollection = Mage::getResourceModel('catalog/product_collection')
->addCategoryFilter($_sareeCategory)
->addAttributeToSelect('*')
->setOrder('order_id', 'desc')
->setPageSize($saree);
$_sareeCollection->load();

return $_sareeCollection;*/


	$arrayValue = array('1'=>'One', '2'=>'Two', '3'=>'Three');
		 return $arrayValue;




    }
	
	
	   public function getDesigns()     
     {
		 	$arrayValue = array('1'=>'One', '2'=>'Two', '3'=>'Three');
		 return $arrayValue;
	 }
	
	
/*public function getLatestTrendingDesignsSalwar()     
     { 
//////////////	  Best Selling SALWAR KAMEEZ Category 

$salwar = 9;
$_salwarCategory = Mage::getModel('catalog/category')->load(41);

$_salwarCollection = Mage::getResourceModel('catalog/product_collection')
->addCategoryFilter($_salwarCategory)
->addAttributeToSelect('*')
->setOrder('order_id', 'desc')
->setPageSize($salwar);
$_salwarCollection->load();

return $_salwarCollection;
	 }*/
	
	
	
/*	
	public function getLatestTrendingDesignsLehenga()     
     { 

//////////////////////////////// Best Selling LEHENGA CHOLI Category 

$lehenga = 9;
$_lehengaCategory = Mage::getModel('catalog/category')->load(73);

$_lehengaCollection = Mage::getResourceModel('catalog/product_collection')
->addCategoryFilter($_lehengaCategory)
->addAttributeToSelect('*')
->setOrder('order_id', 'desc')
->setPageSize($lehenga);
$_lehengaCollection->load();

return $_lehengaCollection;
	 }*/
	
	
	
	
	
	
	
}