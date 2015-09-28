<?php
require_once('app/Mage.php');
umask(0);
Mage::app('admin');
set_time_limit(0);

$category = Mage::getModel('catalog/category');
$tree = $category->getTreeModel();
$tree->load();

$ids = $tree->getCollection()->getAllIds();

if ($ids)
{
     foreach ($ids as $id)
  {
     $cat = Mage::getModel('catalog/category');
     $cat->load($id);
     if($cat->getLevel()==3 && $cat->getIsActive()==1)
     {
        $category1 = Mage::getModel('catalog/category')->load($cat->getId());
        $products = Mage::getResourceModel('catalog/product_collection')
                                ->addAttributeToSelect('name')
                             ->addCategoryFilter($category1);
        echo "<b>".$cat->getName()."</b><br>";
        foreach ($products as $product) { //print_r($product->getData());exit;
                echo " &nbsp; &nbsp; &nbsp; " . $product->getName() . " - ". $product->getSku() . "<br/>";
        }
     }
  }
}
?>