<?php
require_once  $_SERVER['DOCUMENT_ROOT'] . '/app/Mage.php';

Mage::app();

// Get session
//Mage::getSingleton('core/session', array('name'=>'frontend'));
// Check for a product id
if(isset($_REQUEST['productId']))
{

    // Product ID and Quantity
    $pid = $_REQUEST['productId'];
    $qnt = $_REQUEST['qty'];

	$stockItem = (int)Mage::getModel('cataloginventory/stock_item')
               ->loadByProduct($pid)->getQty();
			   
    if($stockItem > 0 && $qnt > $stockItem ){
		echo 'The available quantity for this product is '.$stockItem.' . Please input the available quantity and Update Shopping Cart.';}
};
?>