<?php
// Added OsCommerce Order ID into Magento Order Table
//ALTER TABLE `sales_flat_order_grid` ADD `osc_order_id` INT(15) NOT NULL AFTER `increment_id`;

$host = "localhost";
$user = "root";
$pwd = "rootwdp";
$dbname = "sareez_db_bk";

$conn = mysql_connect("$host","$user","$pwd") or die("ERROR::Not connected to SERVER");	
$db = mysql_select_db("$dbname",$conn) or die("ERROR::Not connected to DATABASE");

//$sql="SELECT * FROM `products` WHERE `products_id`>=169231 AND `products_id`<=169242";
$sql="SELECT * FROM `products` WHERE `products_model`='79-5341SA582746'";
//echo $sql;
$res=mysql_query($sql) or die("ERROR::".mysql_error());
$i=0;
while($row=mysql_fetch_array($res)){
	$manufacturer_model = $row['manufacturer_model'];
	$products_model = $row['products_model'];
	$products_man_price = $row['products_man_price'];
	//echo $manufacturer_model."KKKKKKK".$products_model."<br>"; //die;
	
	require_once 'app/Mage.php';
	Mage::app();
	
	echo "Naba";
	$simpleProduct = Mage::getModel('catalog/product')->loadByAttribute('sku',$products_model);	
	if($simpleProduct) {
		echo "Naba11";
		//$simpleProduct->setDescription($newDescription);
		$simpleProduct->setManufacturerDesign($manufacturer_model);
		$simpleProduct->setMsrp($products_man_price);
		$simpleProduct->save();
		echo "Updated product " . $products_model . "<br>";
	}
	
	//$sql1="UPDATE `sales_flat_order_grid` SET `osc_order_id`='$osc_order_id' WHERE `increment_id`='$mage_order_id'";
	//$res1=mysql_query($sql1) or die("ERROR11::".mysql_error());
	$i++;
}

echo $i."= ROWS UPDATED!!"
?>