<?php
require_once 'app/Mage.php';
Mage::app();


$customer = Mage::getModel('customer/customer')
->setWebsiteId(1)
->loadByEmail($_POST['emailId']);


$hash = $customer->getData("password_hash");
$decrypted = Mage::getModel('core/encryption')->decrypt($customer->getData("password_hash"));
$dbpass = strstr($hash,":",true);

$password = $_POST['Pass'];
$key = (string)Mage::getConfig()->getNode('global/crypt/key');
$hashArr = explode(':', $hash);
$salt = $hashArr[1];
$passlog = md5($salt . $password);



if($passlog==$dbpass){
	 echo "b";
	exit;
}else if($passlog!=$dbpass){
	echo "a";
	exit;
}




//echo $_POST['Pass'];
//echo $_POST['emailId'];
//exit;
 //return $_POST['emailId'];
?>
