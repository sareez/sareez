<?php
require_once 'app/Mage.php';
Mage::app();

echo $sku = Mage::getModel('catalog/product')->load(9437)->getSku();
?>