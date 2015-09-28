<?php
//error_reporting(E_ALL ^ E_DEPRECATED);

//$host = "localhost";
$host = "184.106.45.117";

$user = "magento";

$pwd = "magento_pass";

$dbname = "sareez_db";



$conn = mysql_connect("$host","$user","$pwd"); //or die("ERROR::Not connected to SERVER");	
if($conn){
	$db = mysql_select_db("$dbname",$conn); //or die("ERROR::Not connected to DATABASE");
    if($db){
			echo "successfully connected to DB";
	} else {
		echo "Not connected to DATABASE";
	}
} else {
	echo "Not connected to SERVER";
}

?>