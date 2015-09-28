	<?php
require_once  $_SERVER['DOCUMENT_ROOT'] . '/app/Mage.php';

Mage::app();

$orderIncrementId =100086931;
$order = Mage::getModel('sales/order')->loadByIncrementId($orderIncrementId);
$order->setState(Mage_Sales_Model_Order::STATE_PROCESSING, true)->save();
?>