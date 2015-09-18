<?php
// Added OsCommerce Order ID into Magento Order Table
//ALTER TABLE `sales_flat_order_grid` ADD `osc_order_id` INT(15) NOT NULL AFTER `increment_id`;

$host = "localhost";
$user = "hbanfvqkdv";
$pwd = "tXySfqDmQ3";
$dbname = "hbanfvqkdv";

$conn = mysql_connect("$host","$user","$pwd") or die("ERROR::Not connected to SERVER");	
$db = mysql_select_db("$dbname",$conn) or die("ERROR::Not connected to DATABASE");

$sql="SELECT * FROM `ezmage_orders` WHERE `osc_order_id`>=123543 AND `osc_order_id`<=123624 AND `order_imported`='y'";
$res=mysql_query($sql) or die("ERROR::".mysql_error());
$i=0;
while($row=mysql_fetch_array($res)){
	$osc_order_id = $row['osc_order_id'];
	$mage_order_id = $row['mage_order_id'];
	
	$sql1="UPDATE `sales_flat_order_grid` SET `osc_order_id`='$osc_order_id' WHERE `increment_id`='$mage_order_id'";
	$res1=mysql_query($sql1) or die("ERROR11::".mysql_error());
	$i++;
}

echo $i."= ROWS UPDATED!!"
?>