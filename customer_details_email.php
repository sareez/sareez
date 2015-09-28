<?php
require_once 'app/Mage.php';
Mage::app();

$host = "localhost";
$user = "hbanfvqkdv";
$pwd = "tXySfqDmQ3";
$dbname = "hbanfvqkdv";

/*$host = "localhost";
$user = "root";
$pwd = "rootwdp";
$dbname = "sareees_db";*/
$eMailArr=array('smity.k@gmail.com','laxmi.7185@gmail.com','ami.l.mohandas@gmail.com','hina_saim@hotmail.com','ANSARISIL@ATT.NET','priya29may@gmail.com','pallavi.koneru@gmail.com','salma088@gmail.com');


$conn = mysql_connect("$host","$user","$pwd") or die("ERROR::Not connected to SERVER");	
$db = mysql_select_db("$dbname",$conn) or die("ERROR::Not connected to DATABASE");

$x=0;
for($i=0; $i<count($eMailArr); $i++){
	
	$email_id=$eMailArr[$i];
	//echo $email_id; die;
	$customer = Mage::getModel("customer/customer"); 
	$customer->setWebsiteId(1); 
	//$customer->loadByEmail('mpadmaja_2000@yahoo.com');
	$customer->loadByEmail($email_id);

   $mage_id = $customer->getEntityId();
   $full_name = addslashes($customer->getName());
   $email_id = $customer->getEmail();
   $first_name = addslashes($customer->getFirstname());
   $last_name = addslashes($customer->getLastname());
   //echo $mage_id."KKKK".$full_name."222".$email_id."333".$first_name."444".$last_name; die;
   
   $sql="INSERT INTO `tbl_magento_customer_new` SET `mage_id`='".$mage_id."',`first_name`='".$first_name."',`last_name`='".$last_name."',`email`='".$email_id."',`full_name`='".$full_name."'";
   $q=mysql_query($sql) or die("ERROR:".mysql_error());
   $x++;
}

echo $x."= ROWS UPDATED!!"
?>