<?php
//Added OsCommerce Order ID into Magento Order Table
//ALTER TABLE `sales_flat_order_grid` ADD `osc_order_id` INT(15) NOT NULL AFTER `increment_id`;
require_once 'app/Mage.php';
Mage::app();

$host = "localhost";
$user = "hbanfvqkdv";
$pwd = "tXySfqDmQ3";
$dbname = "hbanfvqkdv";

$productID = array(471,472,473,474,475,476,477,478,479,480,481,482,483,484,485,486,487,488,489,490,491);
//echo "<pre>"; print_r($productID); die;


$x=0;
//for ($i=65030; $i<=65075; $i++){
foreach($productID as $prod){	
	$i=$prod;
	//echo $i."KKKKK"; die;
	$product = Mage::getModel('catalog/product')->load($i);
	$prod_sku = $product->getSku(); 
	
	$conn = mysql_connect("$host","$user","$pwd") or die("ERROR::Not connected to SERVER");	
	$db = mysql_select_db("$dbname",$conn) or die("ERROR::Not connected to DATABASE");
   
	$sql="SELECT * FROM `products` WHERE `products_model`='".$prod_sku."'"; 
	//echo $sql;
	$res=mysql_query($sql) or die("ERROR::".mysql_error());
	$row=mysql_fetch_array($res);
	
	$manufacturer_model = $row['manufacturer_model'];
	$products_model = $row['products_model'];
	$products_man_price = $row['products_man_price'];
	$products_fabric = $row['products_fabric']; 
	$products_work = $row['products_work'];
	$products_type = $row['products_type']; 
	$products_occaison = $row['products_occaison']; 
	$products_weight = $row['products_weight']; 
	$products_measurable = $row['products_measurable']; 
	$products_express = $row['products_express'];
	$products_dimension = $row['products_dimension']; 
	$manufacturers_id = $row['manufacturers_id']; 
	$catalog_id = $row['catalog_id'];
	$products_colour = $row['products_colour'];
	
	
		if($products_express==0){
			$products_express='75';
		} else if($products_express==1){
			$products_express='33';
		} else if($products_express==2){
			$products_express='34';
		} else if($products_express==3){
			$products_express='35';
		} else {
			$products_express='75';
		}
	
	
		$simpleProduct = Mage::getModel('catalog/product')->loadByAttribute('sku',$prod_sku);	
		if($simpleProduct) {
			//$simpleProduct->setDescription($newDescription);
			$simpleProduct->setManufacturerDesign($manufacturer_model);
			$simpleProduct->setMsrp($products_man_price);
			$simpleProduct->setProductFabricDesc($products_fabric);
			$simpleProduct->setWork($products_work);
			$simpleProduct->setProductType($products_type);
			$simpleProduct->setProductOccasionDesc($products_occaison);
			$simpleProduct->setWeight($products_weight);
			$simpleProduct->setProductsMeasurable($products_measurable); 
			$simpleProduct->setExpreesShippingAvailable($products_express);
			$simpleProduct->setDimension($products_dimension);
			$simpleProduct->setManufacturersId($manufacturers_id); 
			$simpleProduct->setCatalogmasterId($catalog_id);
			$simpleProduct->setColorOld($products_colour);
			$simpleProduct->save();
			echo "Updated product " . $prod_sku . "<br>"; 
			$x++;
		}

}

echo $x."= ROWS UPDATED!!"
?>