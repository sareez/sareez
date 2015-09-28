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

$collection = Mage::getModel('customer/customer')->getCollection()
   ->addAttributeToSelect('firstname')
   ->addAttributeToSelect('lastname')
   ->addAttributeToSelect('email');

//$allCustomers = Mage::getModel('customer/customer')->getCollection();

//echo "Naba11"; die;
//echo count($collection); 
//echo "<pre>"; print_r($collection); die;

$conn = mysql_connect("$host","$user","$pwd") or die("ERROR::Not connected to SERVER");	
$db = mysql_select_db("$dbname",$conn) or die("ERROR::Not connected to DATABASE");
$x=0;
foreach ($collection as $item)
{
   /*echo "<pre>"; print_r($item->getEntityId()); 
   echo "<pre>"; print_r($item->getName()); 
   echo "<pre>"; print_r($item->getEmail()); 
   echo "<pre>"; print_r($item->getFirstname()); die;
   break;*/ // just display one item
   
   $mage_id = $item->getEntityId();
   
   if($mage_id>=53001 && $mage_id<=60000){
   $full_name = addslashes($item->getName());
   $email_id = $item->getEmail();
   $first_name = addslashes($item->getFirstname());
   $last_name = addslashes($item->getLastname());
   $sql="INSERT INTO `tbl_magento_customer_new` SET `mage_id`='".$mage_id."',`first_name`='".$first_name."',`last_name`='".$last_name."',`email`='".$email_id."',`full_name`='".$full_name."'";
   $q=mysql_query($sql) or die("ERROR:".mysql_error());
   $x++;
   }
}


/*$collection = Mage::getModel('customer/customer')->getCollection()->addAttributeToSelect('*');
echo count($collection); die;
//echo "<pre>"; print_r($customer );
$customer->getPrefix();
$customer->getName(); // Full Name
$customer->getFirstname(); // First Name
$customer->getMiddlename(); // Middle Name
$customer->getLastname(); // Last Name
$customer->getSuffix();*/
 


echo $x."= ROWS UPDATED!!"
?>