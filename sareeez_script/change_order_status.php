<?php
$host = "localhost";
$user = "hbanfvqkdv";
$pwd = "tXySfqDmQ3";
$dbname = "hbanfvqkdv";

$conn = mysql_connect("$host","$user","$pwd") or die("ERROR::Not connected to SERVER");	
$db = mysql_select_db("$dbname",$conn) or die("ERROR::Not connected to DATABASE");

$sql="SELECT * FROM `mage_osc_processing` WHERE `id`>=11001 AND `id`<=11600";
//$sql="SELECT * FROM `mage_osc_processing` WHERE `id`=11527";
$res=mysql_query($sql) or die("ERROR::".mysql_error());
$i=0;
while($row=mysql_fetch_array($res)){
	$osc_order_id = $row['osc_order_id'];
	$mage_order_id = $row['mage_order_id'];
	$entity_id = $row['entity_id'];
	
	$sql1="UPDATE `sales_flat_order` SET `status`='processing',`state`='processing' WHERE `increment_id`='$mage_order_id'";
	$res1=mysql_query($sql1) or die("ERROR11::".mysql_error());
	
	$sql3="SELECT * FROM  `sales_flat_order_status_history` WHERE `parent_id`='$entity_id' ORDER BY `entity_id` DESC limit 0,1";
	//echo $sql3;
	$res3=mysql_query($sql3) or die("ERROR33::".mysql_error());	
	$row3=mysql_fetch_array($res3);
	$sales_flat_order_status_history_entity_id = $row3['entity_id'];
	//echo $sales_flat_order_status_history_entity_id."KKK"; die;
	
	$sql2="DELETE FROM `sales_flat_order_status_history` WHERE `entity_id`='$sales_flat_order_status_history_entity_id'";
	$res2=mysql_query($sql2) or die("ERROR22::".mysql_error());
	
	$sql4="UPDATE `mage_osc_processing` SET `status`='processing',`state`='processing' WHERE `mage_order_id`='$mage_order_id'";
	$res4=mysql_query($sql4) or die("ERROR44::".mysql_error());
	
	
	$i++;
}

echo $i."= ROWS UPDATED!!"
?>