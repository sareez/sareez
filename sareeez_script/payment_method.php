<?php
$host = "localhost";
$user = "hbanfvqkdv";
$pwd = "tXySfqDmQ3";
$dbname = "hbanfvqkdv";

$conn = mysql_connect("$host","$user","$pwd") or die("ERROR::Not connected to SERVER");	
$db = mysql_select_db("$dbname",$conn) or die("ERROR::Not connected to DATABASE");

$sql="SELECT `entity_id`,`osc_order_id`,`increment_id` FROM `sales_flat_order_grid` WHERE `osc_order_id` <>0 AND `osc_order_id`>=123000 AND `osc_order_id`<=123624";
//$sql="SELECT `entity_id`,`osc_order_id`,`increment_id` FROM `sales_flat_order_grid` WHERE `osc_order_id` = '121000'";
$res=mysql_query($sql) or die("ERROR::".mysql_error());
$i=0;
while($row=mysql_fetch_array($res)){
	$osc_order_id = $row['osc_order_id'];
	$mage_order_id = $row['increment_id'];
	$entity_id = $row['entity_id'];
	
	$sql2="SELECT O.`payment_method`,OS.`orders_status_name` FROM `orders` O JOIN `orders_status` OS ON O.`orders_status` = OS.`orders_status_id` WHERE O.`orders_id`='".$osc_order_id."'";
	$q2=mysql_query($sql2) or die("ERROR22::".mysql_error());
	$res2=mysql_fetch_array($q2);
	$payment_method = $res2['payment_method'];
	$orders_status_name = $res2['orders_status_name'];
	
	//if(strtoupper($payment_method) == strtoupper('PayPal (including Credit Cards and Debit Cards)')){
	if(substr_count($payment_method, 'PayPal')>0){
		$payment_method_str = 'paypal_standard';
	//} else if(strtoupper($payment_method) == strtoupper('Cash on Delivery - India Only')){
	} else if(substr_count($payment_method, 'Cash')>0){
		$payment_method_str = 'phoenix_cashondelivery';
	//} else if(strtoupper($payment_method) == strtoupper('CCAvenue :: e-Payments (in INR)')){
	} else if(substr_count($payment_method, 'CCAvenue')>0){
		$payment_method_str = 'ccavenue';
	//} else if(strtoupper($payment_method) == strtoupper('Bank Transfer Payment (Will take 2-3 days extra time to ship)')){
	} else if(substr_count($payment_method, 'Bank')>0){
		$payment_method_str = 'banktransfer';
	//} else if(strtoupper($payment_method) == strtoupper('2Checkout')){
	} else if(substr_count($payment_method, '2Checkout')>0){
		$payment_method_str = 'tco';
	} else {
		$payment_method_str = $payment_method; 
	}
	
	
	$sql1="UPDATE `sales_flat_order_grid` SET `status`='$orders_status_name' WHERE `entity_id`='$entity_id'";
	$res1=mysql_query($sql1) or die("ERROR11::".mysql_error());
	
	$sql2="UPDATE `sales_flat_order_payment` SET `method`='$payment_method_str' WHERE `parent_id`='$entity_id'";
	$res2=mysql_query($sql2) or die("ERROR33::".mysql_error());
	$i++;
}

echo $i."= ROWS UPDATED!!"
?>