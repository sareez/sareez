<?php 

require_once '../app/Mage.php';
Mage::app();

$conn = mysql_connect("localhost","hbanfvqkdv","tXySfqDmQ3") or die("ERROR::Not connected to SERVER"); 
$db = mysql_select_db("hbanfvqkdv",$conn) or die("ERROR::Not connected to DATABASE");


$local_conn = mysql_connect("www.babulall.com","root","rootwdp") or die("ERROR::Not connected to SERVER"); 
$db = mysql_select_db("local_sareez_db",$local_conn) or die("ERROR::Not connected to DATABASE");



//=======================MEASUREMENT================================

$chkMasurement = "SELECT * from measurement WHERE flag = 0";
$checkmsr = mysql_query($chkMasurement,$conn);
//$checkExists = mysql_fetch_assoc($checkmsr);

while($r = mysql_fetch_assoc($checkmsr)){
	
	echo $sql = "INSERT INTO local_sareez_db.measurement(measurement_name, measurement_type, body_garment, around_bust, around_bottom, around_thigh, around_knee,around_calf, around_ankle, churidar_style,lehenga_length,around_above_waist, shoulder,sleeve_length,sleeve_style,around_arm_hole, around_arm,front_neck_style, front_neck_depth,back_neck_style, back_neck_depth, blouse_length, closing_side, closing_with, lining, around_waist, around_hips, petticoat_length, your_height, kameez_length, kameez_style, salwar_length, salwar_style, salwar_fitings, choli_length, lehnga_style, elastic, instructions, doi, dou,flag)
				
				VALUES ('".$r['measurement_name']."', '".$r['measurement_type']."', '".$r['body_garment']."', '".$r['around_bust']."', '".$r['around_bottom']."', '".$r['around_thigh']."', '".$r['around_knee']."', '".$r['around_calf']."', '".$r['around_ankle']."', '".$r['churidar_style']."', '".$r['lehenga_length']."', '".$r['around_above_waist']."', '".$r['shoulder']."', '".$r['sleeve_length']."', '".$r['sleeve_style']."', '".$r['around_arm_hole']."', '".$r['around_arm']."', '".$r['front_neck_style']."', '".$r['front_neck_depth']."', '".$r['back_neck_style']."', '".$r['back_neck_depth']."', '".$r['blouse_length']."', '".$r['closing_side']."', '".$r['closing_with']."', '".$r['lining']."', '".$r['around_waist']."', '".$r['around_hips']."', '".$r['petticoat_length']."', '".$r['your_height']."', '".$r['kameez_length']."', '".$r['kameez_style']."', '".$r['salwar_length']."', '".$r['salwar_style']."', '".$r['salwar_fitings']."', '".$r['choli_length']."', '".$r['lehnga_style']."', '".$r['elastic']."', '".$r['instructions']."', '".$r['doi']."', '".$r['dou']."',1)";
				
$massql = mysql_query($sql,$local_conn);


	$sqlupd = "UPDATE measurement SET flag = 1 WHERE measurement_id = '".$r['measurement_id']."' ";
	$upquery = mysql_query($sqlupd,$conn);	
}



//=========================MANUFACTURER===========================


$query1 ="SELECT * from manufacturers WHERE flag=0";
$query1_my= mysql_query($query1,$conn);
while($manufacturers = mysql_fetch_assoc($query1_my))
{
	$sql = mysql_query("INSERT into local_sareez_db.manufacturers(manufacturers_id,manufacturers_name,manufacturers_email,manufacturers_phone,manufacturers_address,manufacturers_image,
			date_added,last_modified,flag) VALUES ('".$manufacturers['manufacturers_id']."', '".$manufacturers['manufacturers_name']."','".$manufacturers['manufacturers_email']."'
			,'".$manufacturers['manufacturers_phone']."','".$manufacturers['manufacturers_address']."','".$manufacturers['manufacturers_image']."','".$manufacturers['date_added']."'
			,'".$manufacturers['last_modified']."', 1)",$local_conn);
			
			
			
			
	$update = mysql_query("UPDATE manufacturers SET flag = 1 WHERE manufacturers_id = '".$manufacturers['manufacturers_id']."' " , $conn);
	
}

//=========================CATALOG==================================


$query2 = mysql_query("SELECT * from int_catalogmaster WHERE flag=0",$conn);
while($catalog = mysql_fetch_assoc($query2))
{
	$sql_insert = mysql_query("INSERT into local_sareez_db.t_catalog(catalog_id,manufacturer_id,catalog_name,catalog_description,status,doc,dom,received_by,edited_by
			,edited_on,written_by,written_on,upload_by,upload_on,fabric,price,no_of_products,products_type,catalog_cutt_off_time,process_status,flag) 
			VALUES ('".$catalog['catalog_id']."', '".$catalog['manufacturer_id']."','".$catalog['catalog_name']."','".$catalog['catalog_description']."'
			,'".$catalog['status']."','".$catalog['doc']."','".$catalog['dom']."','".$catalog['received_by']."','".$catalog['edited_by']."','".$catalog['edited_on']."'
			,'".$catalog['written_by']."','".$catalog['written_on']."','".$catalog['upload_by']."','".$catalog['upload_on']."','".$catalog['fabric']."','".$catalog['price']."'
			,'".$catalog['no_of_products']."','".$catalog['products_type']."','".$catalog['catalog_cutt_off_time']."','".$catalog['process_status']."',1)",$local_conn);
	
	$update = mysql_query("UPDATE int_catalogmaster SET flag = 1 WHERE catalog_id = ".$catalog['catalog_id']." ",$conn);
	
}



//======================READYMADE MEASUREMENT=================================


$query3="SELECT * FROM measurement_for_readymade WHERE flag = 0";
$query3_sql = mysql_query($query3,$conn);
while($query3_r = mysql_fetch_assoc($query3_sql)){
	$query3_babulall = mysql_query("INSERT INTO local_sareez_db.readymade_measurement(readymade_type,blouse_rdmd_reasymade_size,blouse_rdmd_sleeves_length,blouse_rdmd_length,petticoat_rdmd_length,suit_rdmd_readymade_size,suit_rdmd_height,suit_rdmd_height_2,suit_rdmd_sleeves_length, 	lehenga_rdmd_readymade_size,lehenga_rdmd_sleeves_length,lehenga_rdmd_height,lehenga_rdmd_height_2, 	choli_rdmd_length,lehenga_rdmd_waist,sherwani_rdmd_chest,sherwani_rdmd_shoulders,sherwani_rdmd_height,sherwani_rdmd_height_2,sherwani_rdmd_sleeve_length,sherwani_rdmd_kameez_length,instructions,doc,dom,flag) 
	values('".$query3_r['readymade_type']."','".$query3_r['blouse_rdmd_reasymade_size']."','".$query3_r['blouse_rdmd_sleeves_length']."','".$query3_r['blouse_rdmd_length']."','".$query3_r['petticoat_rdmd_length']."','".$query3_r['suit_rdmd_readymade_size']."','".$query3_r['suit_rdmd_height']."','".$query3_r['suit_rdmd_height_2']."','".$query3_r['suit_rdmd_sleeves_length']."','".$query3_r['lehenga_rdmd_readymade_size']."','".$query3_r['lehenga_rdmd_sleeves_length']."','".$query3_r['lehenga_rdmd_height']."','".$query3_r['lehenga_rdmd_height_2']."','".$query3_r['choli_rdmd_length']."','".$query3_r['lehenga_rdmd_waist']."','".$query3_r['sherwani_rdmd_chest']."','".$query3_r['sherwani_rdmd_shoulders']."','".$query3_r['sherwani_rdmd_height']."','".$query3_r['sherwani_rdmd_height_2']."','".$query3_r['sherwani_rdmd_sleeve_length']."','".$query3_r['sherwani_rdmd_kameez_length']."','".$query3_r['instructions']."','".$query3_r['doc']."','".$query3_r['dom']."',1) ", $local_conn);
	
	
	$query3_sareez = mysql_query("UPDATE measurement_for_readymade SET flag = 1 WHERE readymade_id = ".$query3_r['readymade_id']." ", $conn);
	
}



//=====================USER MEASUREMENT==========================


$query4="SELECT * FROM measurement_for_user WHERE flag = 0";
$query4_sql = mysql_query($query4,$conn);
while($query4_r = mysql_fetch_assoc($query4_sql)){


$query4_babulall = mysql_query("INSERT into local_sareez_db.user_measurement(user_id,products_id,measurement_id, 	readymade_id,order_status,order_id,flag) VALUES ('".$query4_r['user_id']."', '".$query4_r['products_id']."','".$query4_r['measurement_id']."','".$query4_r['readymade_id']."','".$query4_r['order_status']."','".$query4_r['order_id']."', 1)",$local_conn);

$sql = mysql_query("UPDATE measurement_for_user SET flag = 1 WHERE id = ".$query4_r['id']."", $conn);
	
}




?>