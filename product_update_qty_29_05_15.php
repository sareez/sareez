<?php
// Added OsCommerce Order ID into Magento Order Table
//ALTER TABLE `sales_flat_order_grid` ADD `osc_order_id` INT(15) NOT NULL AFTER `increment_id`;
require_once 'app/Mage.php';
Mage::app();

$host = "localhost";
$user = "root";
$pwd = "rootwdp";
$dbname = "sareez_db_bk";

$conn = mysql_connect("$host","$user","$pwd") or die("ERROR::Not connected to SERVER");	
$db = mysql_select_db("$dbname",$conn) or die("ERROR::Not connected to DATABASE");

$x=0;
$y=0;

$sql="SELECT `stock_qty`,`products_model` FROM `ims_stock_manager` WHERE `stock_qty` >=1 LIMIT 0,5040";
//echo $sql;
$res=mysql_query($sql) or die("ERROR::".mysql_error());

while($row=mysql_fetch_array($res)){
	$stock_qty = $row['stock_qty']; 
	$prod_sku = $row['products_model']; 
	$simpleProduct = Mage::getModel('catalog/product')->loadByAttribute('sku',$prod_sku);
	//echo "<pre>"; echo count($simpleProduct); print_r($simpleProduct); die;
	
	if(count($simpleProduct)>0){
		/*$productId = $simpleProduct->getId(); 
		//echo $productId."HH"; die;
		$stockItem =Mage::getModel('cataloginventory/stock_item')->loadByProduct($productId);
		//$stockItemId = $stockItem->getId();
		//$stockItem->setData('manage_stock', 1);
		$stockItem->setData('qty', (integer)$stock_qty);
		$stockItem->save();*/			
		
		echo "Updated product:" . $prod_sku . " AND Quantity:".$stock_qty."<br>"; 
		$x++;
	} else {
		$y++;
		echo "NOT Updated product:" . $prod_sku . " AND Quantity:".$stock_qty."<br>";
	}
}

echo $x."= ROWS UPDATED!!<br>";
echo $y."= ROWS NOT UPDATED!!";
?>