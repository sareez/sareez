<?php
// Added OsCommerce Order ID into Magento Order Table
//ALTER TABLE `sales_flat_order_grid` ADD `osc_order_id` INT(15) NOT NULL AFTER `increment_id`;

$host = "localhost";
$user = "root";
$pwd = "rootwdp";
$dbname = "sareez_db_bk";

$conn = mysql_connect("$host","$user","$pwd") or die("ERROR::Not connected to SERVER");	
$db = mysql_select_db("$dbname",$conn) or die("ERROR::Not connected to DATABASE");

$sql="SELECT * FROM `products` WHERE `products_status`=1 AND `products_id`>=165864 AND `products_id`<=169242"; //169242
//$sql="SELECT * FROM `products` WHERE `products_id`>=70001 AND `products_id`<=75000";
//$sql="SELECT * FROM `products` WHERE `products_model`='79-5341SA582746'"; 
//echo $sql;
$res=mysql_query($sql) or die("ERROR::".mysql_error());
$i=0;
while($row=mysql_fetch_array($res)){
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
	
	//echo $manufacturer_model."KKKKKKK".$products_model."<br>"; //die; 
	
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
	
	require_once 'app/Mage.php';
	Mage::app();
	
	$simpleProduct = Mage::getModel('catalog/product')->loadByAttribute('sku',$products_model);	
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
		echo "Updated product " . $products_model . "<br>"; 
		$i++;
	}
	
}

echo $i."= ROWS UPDATED!!"
?>