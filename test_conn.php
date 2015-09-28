<?php
// Added OsCommerce Order ID into Magento Order Table
//ALTER TABLE `sales_flat_order_grid` ADD `osc_order_id` INT(15) NOT NULL AFTER `increment_id`;
require_once 'app/Mage.php';
Mage::app();

 $conn_sareez = mysql_connect("localhost", 'root', 'rootwdp') or die("ERROR::Not connected to SERVER");
$db = mysql_select_db("sareees_db",$conn_sareez ) or die("ERROR::Not connected to DATABASE"); 

$sql = mysql_query("SELECT id from measurement_for_user WHERE flag = 0 LIMIT 0,10000");
while($ex = mysql_fetch_assoc($sql))
{
	$sql1 =  "SELECT b.mage_customers_id from measurement_for_user AS a INNER JOIN ezmage_customers as b ON a.user_id = b.osc_customers_id WHERE a.id = ".$ex['id'];
	$mageUserId = mysql_fetch_array(mysql_query($sql1));
	
	if(!empty($mageUserId['mage_customers_id']))
	{
		$mageUserId = $mageUserId['mage_customers_id'];
	}
	else
	{
		$mageUserId = 0;
	}
	
	$sQLMeasur = mysql_query("UPDATE measurement_for_user SET user_id = ".$mageUserId." WHERE id = ".$ex['id']);
	
	$sql3 = mysql_query("UPDATE measurement_for_user SET flag = 1 WHERE id = ".$ex['id']);
	
	echo "id ".$ex['id']." UPDATED WITH USER =".$mageUserId."</br>";
}


 ?>