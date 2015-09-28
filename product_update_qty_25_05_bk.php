<?php
// Added OsCommerce Order ID into Magento Order Table
//ALTER TABLE `sales_flat_order_grid` ADD `osc_order_id` INT(15) NOT NULL AFTER `increment_id`;
require_once 'app/Mage.php';
Mage::app();

$host = "localhost";
$user = "root";
$pwd = "rootwdp";
$dbname = "sareez_db_bk";

$x=0;
for ($i=29001; $i<=29500; $i++){
	$product = Mage::getModel('catalog/product')->load($i);
	$prod_sku = $product->getSku(); 
	
	$conn = mysql_connect("$host","$user","$pwd") or die("ERROR::Not connected to SERVER");	
	$db = mysql_select_db("$dbname",$conn) or die("ERROR::Not connected to DATABASE");
   
	$sql="SELECT * FROM `ims_stock_manager` WHERE `products_model`='".$prod_sku."'"; 
	//echo $sql;
	$res=mysql_query($sql) or die("ERROR::".mysql_error());
	if(mysql_num_rows($res)>0){
		$row=mysql_fetch_array($res);
		//$products_model = $row['products_model'];
		$stock_qty = $row['stock_qty'];
		//echo $stock_qty."Naba11<br>";
		
		if($stock_qty < 0){
			$stock_qty = 0;
		} else {
			$stock_qty = $stock_qty;
		}
	} else {
		$stock_qty = 0;
	}
	
	$productId = $i;
	$stockItem =Mage::getModel('cataloginventory/stock_item')->loadByProduct($productId);
	//$stockItemId = $stockItem->getId();
	//$stockItem->setData('manage_stock', 1);
	$stockItem->setData('qty', (integer)$stock_qty);
	$stockItem->save();			
	
	echo "Updated product:" . $prod_sku . " AND Quantity:".$stock_qty."<br>"; 
	$x++;
		

}

echo $x."= ROWS UPDATED!!"
?>