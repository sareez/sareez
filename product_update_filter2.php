<?php
require_once 'app/Mage.php';
Mage::app();
// Added OsCommerce Order ID into Magento Order Table
//ALTER TABLE `sales_flat_order_grid` ADD `osc_order_id` INT(15) NOT NULL AFTER `increment_id`;

/*$host = "localhost";
$user = "root";
$pwd = "rootwdp";
$dbname = "sareez_db_bk";

$conn = mysql_connect("$host","$user","$pwd") or die("ERROR::Not connected to SERVER");	
$db = mysql_select_db("$dbname",$conn) or die("ERROR::Not connected to DATABASE");*/


for($i=1; $i<=2; $i++){
	
$product = Mage::getModel('catalog/product')->load($i);
        $product->setFabric('50,51,52,53');
		$product->save();	

	
	
	}

?>