<?php 
$conn = mysql_connect("localhost","root","rootwdp");
mysql_select_db("sareees_db", $conn);

//echo "chinmay";
// INSERT  MEASUREMENT//
$sql = mysql_query("INSERT INTO anik.measurement SELECT * FROM sareees_db.measurement WHERE sareees_db.measurement.flag = 0");
$query = mysql_query("SELECT sareees_db.measurement.measurement_id from sareees_db.measurement WHERE sareees_db.measurement.flag = 0");
while($measurement = mysql_fetch_array($query))
{
	$sql = mysql_query("UPDATE sareees_db.measurement SET sareees_db.measurement.flag = 1 WHERE sareees_db.measurement.measurement_id = ".$measurement['measurement_id']);
}
// END Measurement Insert//

// INSERT MANUFACTURER//
$query1 = mysql_query("SELECT * from sareees_db.manufacturers WHERE sareees_db.manufacturers.flag=0");
while($manufacturers = mysql_fetch_assoc($query1))
{
	$sql = mysql_query("INSERT into anik.manufacturers(manufacturers_id,manufacturers_name,manufacturers_email,manufacturers_phone,manufacturers_address,manufacturers_image,
			date_added,last_modified,flag) VALUES ('".$manufacturers['manufacturers_id']."', '".$manufacturers['manufacturers_name']."','".$manufacturers['manufacturers_email']."'
			,'".$manufacturers['manufacturers_phone']."','".$manufacturers['manufacturers_address']."','".$manufacturers['manufacturers_image']."','".$manufacturers['date_added']."'
			,'".$manufacturers['last_modified']."', 1)");
	$update = mysql_query("UPDATE sareees_db.manufacturers SET sareees_db.manufacturers.flag = 1 WHERE sareees_db.manufacturers.manufacturers_id = ".$manufacturers['manufacturers_id']);
}
// END MANUFACTURER INSERT//

// INSERT CATALOG//
$query2 = mysql_query("SELECT * from sareees_db.int_catalogmaster WHERE sareees_db.int_catalogmaster.flag=0");
while($catalog = mysql_fetch_assoc($query2))
{
	$sql_insert = mysql_query("INSERT into anik.t_catalog(catalog_id,manufacturer_id,catalog_name,catalog_description,status,doc,dom,received_by,edited_by
			,edited_on,written_by,written_on,upload_by,upload_on,fabric,price,no_of_products,products_type,catalog_cutt_off_time,process_status,flag) 
			VALUES ('".$catalog['catalog_id']."', '".$catalog['manufacturer_id']."','".$catalog['catalog_name']."','".$catalog['catalog_description']."'
			,'".$catalog['status']."','".$catalog['doc']."','".$catalog['dom']."','".$catalog['received_by']."','".$catalog['edited_by']."','".$catalog['edited_on']."'
			,'".$catalog['written_by']."','".$catalog['written_on']."','".$catalog['upload_by']."','".$catalog['upload_on']."','".$catalog['fabric']."','".$catalog['price']."'
			,'".$catalog['no_of_products']."','".$catalog['products_type']."','".$catalog['catalog_cutt_off_time']."','".$catalog['process_status']."',1)");
	
	$update = mysql_query("UPDATE sareees_db.int_catalogmaster SET sareees_db.int_catalogmaster.flag = 1 WHERE sareees_db.int_catalogmaster.catalog_id = ".$catalog['catalog_id']);
}
// END CATALOG INSERT//

// INSERT READYMADE MEASUREMENT//
$sql = mysql_query("INSERT INTO anik.readymade_measurement SELECT * FROM sareees_db.measurement_for_readymade WHERE sareees_db.measurement_for_readymade.flag = 0");
$query = mysql_query("SELECT sareees_db.measurement_for_readymade.readymade_id from sareees_db.measurement_for_readymade WHERE sareees_db.measurement_for_readymade.flag = 0");
while($measurement_readymade = mysql_fetch_array($query))
{
	$sql = mysql_query("UPDATE sareees_db.measurement_for_readymade SET sareees_db.measurement_for_readymade.flag = 1 WHERE sareees_db.measurement_for_readymade.readymade_id = ".$measurement_readymade['readymade_id']);
}
// END READYMADE INSERT//

// INSERT USER MEASUREMENT//
$sql = mysql_query("INSERT INTO anik.user_measurement SELECT * FROM sareees_db.measurement_for_user WHERE sareees_db.measurement_for_user.flag = 0");
$query = mysql_query("SELECT sareees_db.measurement_for_user.id from sareees_db.measurement_for_user WHERE sareees_db.measurement_for_user.flag = 0");
while($measurement_user = mysql_fetch_array($query))
{
	$sql = mysql_query("UPDATE sareees_db.measurement_for_user SET sareees_db.measurement_for_user.flag = 1 WHERE sareees_db.measurement_for_user.id = ".$measurement_user['id']);
}
// END USER INSERT//


?>