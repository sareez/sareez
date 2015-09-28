<?php
require_once 'app/Mage.php';
Mage::app();

$x=0;
$y=0;
for ($i=64322; $i<=64479; $i++){
	$product = Mage::getModel('catalog/product')->load($i);
	$prod_desc = $product->getDescription();
	
	if(strlen($prod_desc)>2){ 
	$prod_sku = $product->getSku(); 
	//echo $prod_sku."=====".$prod_desc."<br><br>";
	
	$prod_desc = str_replace("Time to deliver: 25 days.", "", $prod_desc);
	$prod_desc = str_replace("Time to deliver: 15 days.", "", $prod_desc);
	$prod_desc = str_replace("Time to deliver: 10 days.", "", $prod_desc);
	$prod_desc = str_replace("Time to deliver: 7 days.", "", $prod_desc);
	
	$newDescription = $prod_desc;
	//echo $newDescription; //die;
	
	$simpleProduct = Mage::getModel('catalog/product')->load($i);
	//echo "<pre>"; print_r($simpleProduct);	
	if($simpleProduct) { //echo "Naba"; die;
		$simpleProduct->setDescription($newDescription);
		$simpleProduct->save();
		echo "Updated product desc" . $prod_sku . "<br>"; 
		$x++;
	}
	}

$y++;
}

echo $x."= ROWS UPDATED!!<br>";
echo $y."= TOTAL ROWS!!";
?>