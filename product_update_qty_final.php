<?php
require_once 'app/Mage.php';
Mage::app();

/*$host = "localhost";
$user = "root";
$pwd = "rootwdp";
$dbname = "sareez_db_bk";*/

$x=0;
$y=0;

for ($i=29001; $i<=23500; $i++){
	$product = Mage::getModel('catalog/product')->load($i);
	$prod_sku = $product->getSku(); 
	
	$conn = mysql_connect("localhost","hbanfvqkdv","tXySfqDmQ3") or die("ERROR_QTY::Not connected to SERVER"); 
	$db = mysql_select_db("hbanfvqkdv",$conn) or die("ERROR_QTY::Not connected to DATABASE");
   
	//$sql="SELECT * FROM `ims_stock_manager` WHERE `products_model`='".$prod_sku."' AND `stock_qty` >=1"; 
	$sql="SELECT * FROM `ims_stock_manager` WHERE `products_model`='".$prod_sku."'"; 
	//echo $sql;
	$res=mysql_query($sql) or die("ERROR::".mysql_error());
	if(mysql_num_rows($res)>0){
		$row=mysql_fetch_array($res);
		//$products_model = $row['products_model'];
		$stock_qty = $row['stock_qty'];
		//echo $stock_qty."Naba11<br>";
		
		$productId = $i;
		$stockItem =Mage::getModel('cataloginventory/stock_item')->loadByProduct($productId);
		//$stockItemId = $stockItem->getId();
		//$stockItem->setData('manage_stock', 1);
		$stockItem->setData('qty', (integer)$stock_qty);
		$stockItem->save();			
		
		//echo "Updated product:" . $prod_sku . " AND Quantity:".$stock_qty."<br>"; 
		$x++;

	} else {
		//echo "NOT Updated product:" . $prod_sku . " AND Quantity:".$stock_qty."<br>";
		$y++;
	}

}

echo $x."= ROWS UPDATED!!<br>";
echo $y."= ROWS NOT UPDATED!!";
?>