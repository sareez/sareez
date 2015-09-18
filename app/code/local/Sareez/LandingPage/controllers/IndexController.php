<?php
class Sareez_LandingPage_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
      
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("LandingPage"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("landingpage", array(
                "label" => $this->__("LandingPage"),
                "title" => $this->__("LandingPage")
		   ));

      $this->renderLayout(); 
	  
    }
	
	
	public function sareesAction(){
		//$this->loadLayout();
	//////////////////////////////// Best Selling Saree Category 
	$saree = 3;
	$_sareeCategory = Mage::getModel('catalog/category')->load(4);
	
	$_sareeCollection = Mage::getResourceModel('catalog/product_collection')
	->addCategoryFilter($_sareeCategory)
	->addAttributeToSelect('*')
	->setOrder('ordered_qty', 'desc')
	->setPageSize($saree);
	$_sareeCollection->load();
	// $this->renderLayout();
	
	//return $_sareeCategory;
	
	
	
	$this->loadLayout();
$listBlock = $this->getLayout()
            ->setTemplate('landingpage/index.phtml')
            ->setCollection($_sareeCollection);

    $this->getLayout()->getBlock('content')->append($listBlock);
    $this->renderLayout();
	
	
	
	
	
	
	
	
	
	/* $this->loadLayout();
    $this->renderLayout();*/
	
	
	/*
	echo '<pre>';
	print_r($_sareeCategory);
	echo '</pre>';
	*/
		}
	
	
}