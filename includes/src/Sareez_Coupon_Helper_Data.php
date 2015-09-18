<?php

class Sareez_Coupon_Helper_Data extends Mage_Core_Helper_Abstract
{
static function getCategoryOptionValues($inlcudeNone = false) {
$collection = Mage::getModel('coupon/coupon')->getCollection();


////////////////////////////////////////// << Product Category call

$category = Mage::getModel('catalog/category');
$catTree = $category->getTreeModel()->load();
$catIds = $catTree->getCollection()->getAllIds();

$cats = array();
if ($catIds){
	
	    if ($inlcudeNone){
        //$values[] = array('label' => "--None--", 'value' => '');
    }
    foreach ($catIds as $id){
        $cat = Mage::getModel('catalog/category');
        $cat->load($id);
        // $cats[$cat->getId()] = $cat->getName();
		$values[] = array('label' => $cat->getName(), 'value' => $cat->getId(), 'selected' => 'selected' );
    }
}

    return $values;
 }
 
 
 static function getUserOptionValues($inlcudeNone = false) {
    $collection = Mage::getModel('coupon/coupon')->getCollection();
	
	
	
	
	
	
	$users = mage::getModel('customer/customer')->getCollection()
           ->addAttributeToSelect('email');
	
//	echo "<pre>";
//	print_r($users);
//	echo "</pre>";
	
	
	
 $values = array();
    if ($inlcudeNone){
        $values[] = array('label' => "--Logged Out--", 'value' => '0');
    }
    foreach ($users as $user) {
        $values[] = array('value' => $user->getId(), 'label' => $user->getEmail(), 'selected' => 'selected' );
    }
	
	
    return $values;
 }
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
/*static function getCategoryOptionCategories($inlcudeNone = false) {
    $collection = Mage::getModel('coupon/coupon')->getCollection();
	
 $values = array();
    if ($inlcudeNone){
        $values[] = array('label' => "--None--", 'value' => 0);
    }
    foreach ($collection as $category) {
        $values[] = array('value' => $category->getId(), 'label' => $category->getName());
    }
	
	
    return $values;
 }
 */
}