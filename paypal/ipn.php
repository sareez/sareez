<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once '../app/Mage.php';
    umask(0);
    $app = Mage::app('default');
    if ($app->getRequest()->isPost()) {
       return;
    }
    try {
        $data = $app->getRequest()->getPost();
        Mage::getModel('paypal/ipn')->processIpnRequest($data, new Varien_Http_Adapter_Curl());
    } catch (Exception $e) {
        Mage::logException($e);
        $app->getResponse()->setHttpResponseCode(500);
    } 
?>