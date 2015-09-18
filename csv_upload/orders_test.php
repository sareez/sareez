<?php 
// print_r($this->orderProcess());
require_once("app/Mage.php");
$app = Mage::app('');


    $resource = Mage::getSingleton('core/resource');
    $readConnection = $resource->getConnection('core_read');

$salesModel=Mage::getModel("sales/order");
$salesCollection = $salesModel->getCollection();

$i=1;
foreach($salesCollection as $order)
{
    
    $orderId= $order->getIncrementId();
    //echo $orderId;
    $orderId;
    $orderIncrementId = $orderId;
   // $orderIncrementId = $i;
    
    
    $order = Mage::getModel('sales/order')->loadByIncrementId($orderIncrementId);
    $items = $order->getAllVisibleItems();
   
  
    
    
       // foreach($items as $item):
    foreach($items as $item){
              ?>

<table width="100%" border="0" cellpadding="3" cellspacing="3" style="display: none;">

  <tr>
    <td><b>Item Id</b></td>
    <td><b>Product Id</b></td>
    <td><b>Name</b></td>
    <td><b>SKU</b></td>
    <td><b>Quantity</b></td>
    <td><b>Stock</b></td>
    <td><b>Option Product</b></td>
    <td><b>Option Product Price</b></td>
    <td><b>Catalog Name</b></td>
    <td><b>Manufacturers / Vendor</b></td>
    <td><b>Manufacturer Design</b></td>
    <td><b>Order Date</b></td>
  </tr>
  <tr>
    <td><?php echo $item->getItemId(); ?></td>
    <td><?php echo $item->getProductId(); ?></td>
    <td><?php echo $item->getName(); $GLOBALS['name'] = $item->getName(); ?></td>
    <td><?php echo $item->getSku(); $GLOBALS['sku'] = $item->getSku(); ?></td>
    <td><?php echo $item->getQtyOrdered(); ?></td>
      <td><?php  
      $product = Mage::getModel('catalog/product')->load($item->getProductId());
      echo $qty = $product->getStockItem()->getQty(); 
      $GLOBALS['qty_avaliable']=$qty;
      ?></td>
      
      <td><?php
    $product = Mage::getModel("catalog/product")->load($item->getId()); //product id
    foreach ($product->getOptions() as $_option) {
        $values = $_option->getValues();
        
        $GLOBALS['option_value'] = $values;
        foreach ($values as $v) {
            print_r($v->getTitle());
            //echo " | ";
            //echo $v->price; 
            echo "<br />";
        }
    }
?></td>
      
      <td><?php
    $product = Mage::getModel("catalog/product")->load($item->getId()); //product id
    foreach ($product->getOptions() as $_option) {
        $values = $_option->getValues();
        foreach ($values as $v) {
            //print_r($v->getTitle());
            //echo " | ";
            echo $v->price; 
            echo "<br />";
        }
    }
?></td>
      
      <td>
          <?php
          $_id = $item->getProductId();
$_resource = Mage::getSingleton('catalog/product')->getResource();
$optionValue = $_resource->getAttributeRawValue($_id,  'catalogmaster_id', Mage::app()->getStore());
$optionValue;
      


    $query = "SELECT * FROM int_catalogmaster where catalog_id = '".$optionValue."'";
    $results = $readConnection->fetchAll($query);
    foreach($results as $r) { echo $r['catalog_name']; $GLOBALS['catalog_name']=$r['catalog_name']; }


      ?></td>
      
      <td>
                    <?php
          $_id = $item->getProductId();
$_resource = Mage::getSingleton('catalog/product')->getResource();
$optionValue = $_resource->getAttributeRawValue($_id,  'manufacturers_id', Mage::app()->getStore());
$optionValue;


    $query = "SELECT * FROM manufacturers where manufacturers_id = '".$optionValue."'";
    $results = $readConnection->fetchAll($query);
    foreach($results as $r) { echo $r['manufacturers_name']; $GLOBALS['manufac_name'] = $r['manufacturers_name']; }

?>
          
          </td>
          
          <td> <?php
          $_id = $item->getProductId();
$_resource = Mage::getSingleton('catalog/product')->getResource();
$manufact_design = $_resource->getAttributeRawValue($_id,  'manufacturer_design', Mage::app()->getStore());
echo $manufact_design;
$GLOBALS['design'] = $manufact_design;


//    $query = "SELECT * FROM manufacturers where manufacturers_id = '".$optionValue."'";
//    $results = $readConnection->fetchAll($query);
//    foreach($results as $r) { echo $r['manufacturers_name']; }

?></td>
          
     
          <td><?php echo $order->getCreatedAt(); $GLOBALS['orderdate'] = $order->getCreatedAt();  ?></td>
      
  </tr>
</table>
<?php

$connection = Mage::getSingleton('core/resource')->getConnection('core_write');
// insert

foreach ($GLOBALS['option_value'] as $v) {
            $optionName .= $v->getTitle()." (".$v->price."), ";
            // echo " | ";
            // echo $v->price; 
            // echo "<br />";
        }

        
        
    $query = "SELECT * FROM ordercsv where order_id = '".$orderId."' and sku = '".$GLOBALS['sku']."'";
    $results = $readConnection->fetchAll($query);
    
    //echo count($results); exit;
    //foreach($results as $r) { echo $r['manufacturers_name']; }
?>