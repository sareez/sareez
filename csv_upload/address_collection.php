<?php //require_once '../app/Mage.php';Mage::app(); require_once '../db/connection.php';


require_once '../app/Mage.php';
//require_once '../db/connection.php';
Mage::app();

/*$conn = mysql_connect("localhost","hbanfvqkdv","tXySfqDmQ3") or die("ERROR::Not connected to SERVER"); 
$db = mysql_select_db("hbanfvqkdv",$conn) or die("ERROR::Not connected to DATABASE");
*/



$local_conn = mysql_connect("www.babulall.com","anik","pass") or die("ERROR::Not connected to SERVER"); 
$db = mysql_select_db("anik",$local_conn) or die("ERROR::Not connected to DATABASE");





$addressesCollection = Mage::getResourceModel('customer/address_collection');
  $addressesCollection->addAttributeToSelect('*');
/* for particular address 
$addressesCollection->addFieldToFilter('id','12'); */

/*echo "<pre>";
print_r($addressesCollection->getData());
echo "</pre>";*/

foreach ($addressesCollection as $address) {
	echo "chinmay111";
	
	echo "<pre>"; 
  print_r($address->getData());

	echo $addsql = "SELECT address_book_id from anik.address_book where address_book_id = '".$address['entity_id']."' ";
	exit;
	$AddressSql = mysql_query($addsql,$local_conn);
	$r = mysql_fetch_assoc($AddressSql);
	if($r == '' || empty($r))
	{
$AddressInsert = "Insert into anik.address_book(address_book_id,customers_id, entry_company,entry_firstname, entry_lastname, entry_street_address,
					entry_postcode,entry_city,entry_state,entry_country_id,flag) VALUES ('".$address['entity_id']."','".$address['parent_id']."', '".$address['company']."'
					, '".$address['firstname']."', '".$address['lastname']."', '".$address['street']."'
					, '".$address['postcode']."', '".$address['city']."', '".$address['region']."'
					, '".$address['country_id']."',1)";
			if(!mysql_query($AddressInsert))
			{
				$sqlUpdate = "UPDATE anik.customers SET customers_telephone = '".$address['telephone']."' WHERE customers_id =".$address['entity_id'];
				if(!mysql_query($sqlUpdate))
				{
					echo $sqlUpdate;
				}
			}				
	}

}
?>