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

//$sql="SELECT `stock_qty`,`products_model` FROM `ims_stock_manager` WHERE `stock_qty` >=1 ORDER BY `stock_manager_id` ASC LIMIT 1,10";
//$sql="SELECT `stock_qty`,`products_model` FROM `ims_stock_manager` WHERE `stock_qty` >=1 AND `products_model`='122SL1113'";
$sql="SELECT `stock_qty`,`products_model` FROM `ims_stock_manager` WHERE `stock_qty` >=1 AND `products_model` IN ('6LL102','122SL1113') ORDER BY `stock_manager_id` DESC";
echo $sql.'<br>';
$res=mysql_query($sql) or die("ERROR::".mysql_error()); 

while($row=mysql_fetch_array($res)){
	$stock_qty = $row['stock_qty']; 
	$prod_sku = $row['products_model']; 
	echo $prod_sku;
	$simpleProduct = Mage::getModel('catalog/product')->loadByAttribute('sku',$prod_sku);
	echo "<pre>"; echo count($simpleProduct);
	//echo $simpleProduct->getSku(); die;
	//print_r($simpleProduct);
	$MageSku = $simpleProduct->getSku();
	echo $MageSku."HH<br>";
	
	if($MageSku <> ''){
		echo "Naba222"; die;
		$productId = $simpleProduct->getId(); 
		//echo $productId."HH"; die;
		$stockItem =Mage::getModel('cataloginventory/stock_item')->loadByProduct($productId);
		//$stockItemId = $stockItem->getId();
		//$stockItem->setData('manage_stock', 1);
		$stockItem->setData('qty', (integer)$stock_qty);
		$stockItem->save();			
		
		echo "Updated product:" . $prod_sku . " AND Quantity:".$stock_qty."<br>"; 
		$x++;
	} else {
		echo "Naba"; die;
		echo "NOT Updated product:" . $prod_sku . " AND Quantity:".$stock_qty."<br>";
		$y++;
	}
}

echo $x."= ROWS UPDATED!!<br>";
echo $y."= ROWS NOT UPDATED!!";
?>