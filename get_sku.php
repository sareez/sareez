<?php
require_once('app/Mage.php');
umask(0);
Mage::app();

$collection = Mage::getModel('catalog/product')
     ->getCollection()
     ->addAttributeToSelect('*')
     ->joinField('qty',
                 'cataloginventory/stock_item',
                 'qty',
                 'product_id=entity_id',
                 '{{table}}.stock_id=1',
                 'left')
     ->addAttributeToFilter('qty', array("gt" => 35))
	 ->addAttributeToFilter('status', 1)
  ->addAttributeToFilter('visibility', 4)
   ->load();
   $i=0;
foreach($collection as $p_sku) {
		//echo "chinmay";
	$sku_code1=$p_sku->getExpreesShippingAvailable();
	if($sku_code1==33){
	  echo $sku_code=$p_sku->getSku()."<br>";
	  //echo "--"."<br>";
	  
	  $i++;
	}
}
echo $i;
?>