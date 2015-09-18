<?php
require_once '../app/Mage.php';
umask(0);
Mage::app();


$products = Mage::getModel('catalog/product')->getCollection()->addAttributeToSelect('*');
//$products = Mage::getModel('catalog/product')->getCollection()->addAttributeToSelect('*');
//Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);

//print_r($products);
echo "ABC";
$m=0;
foreach ($products as $product) {
	echo "<pre>";
	print_r($product);
	echo "<pre>";
	echo 'chinmay'.$product['sku'];
	echo "</br>";
	$pos = strpos($product['sku'], 'SA');
	if($pos==true){
		$product_id=$product['entity_id'];
		//$product_id=1;63644
		if($product_id>0 && $product_id<65100){
			
			/*	$product123 = Mage::getModel('catalog/product')->load($product_id);
				if ($product123->hasOptions()) {
					foreach ($product123->getOptions() as $option) {
						//if ($option->getTitle() === 'Custom Size') {
							echo 'Product Name '. $product123->getName() . ' has a custom size option!';
							echo 'Product ID '. $product123->getId() . ' has a custom size option!';
							
							echo 'chinmay'.$product_id;
						//}
					}
				}*/
							
			
			}
	}
}
echo $m;







?>