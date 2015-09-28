<?php
require_once 'app/Mage.php';
Mage::app();


$sku='135-4520SA888557';


$attributeValue = Mage::getModel('catalog/product')->load('8539')->getAttributeText('color');
			
echo "<pre>"; print_r($attributeValue); die;





$_product=Mage::getModel('catalog/product')->load($sku, 'sku'); 
$amazonlink = $_product->getData('color');

echo "<pre>";
print_r($_product->getData());
echo "<pre>";
print_r($amazonlink);

?>