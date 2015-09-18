<?php 
require_once '../app/Mage.php';
umask(0);
Mage::app();







 $customer = mage::getModel('customer/customer')->getCollection()->getData();


foreach ($customer as $address)
{
	$visitorData = Mage::getModel('customer/customer')->load($address['entity_id']);
foreach ($visitorData->getAddresses() as $address)
{
    $data = $address->toArray();
	echo '<pre>';
    print_r($data['entity_id']);
	echo '<pre/>';
	
	//exit;
	
	$local_conn = mysql_connect("www.babulall.com","anik","pass") or die("ERROR::Not connected to SERVER"); 
$db = mysql_select_db("local_sareez_db",$local_conn) or die("ERROR::Not connected to DATABASE");
	
	$AddressInsert = "Insert into local_sareez_db.address_book(address_book_id,customers_id, entry_company,entry_firstname, entry_lastname, entry_street_address,
					entry_postcode,entry_city,entry_state,entry_country_id,flag) VALUES ('".$data['entity_id']."','".$data['parent_id']."', '".$data['company']."'
					, '".$data['firstname']."', '".$data['lastname']."', '".$data['street']."'
					, '".$data['postcode']."', '".$data['city']."', '".$data['region']."'
					, '".$data['country_id']."',1)";
			if(!mysql_query($AddressInsert,$local_conn))
			{
				$sqlUpdate = "UPDATE local_sareez_db.customers SET customers_telephone = '".$data['telephone']."' WHERE customers_id =".$data['entity_id'];
				if(!mysql_query($sqlUpdate,$local_conn))
				{
					echo $sqlUpdate;
				}
			}
	
	
	
}

}
#displaying the array
//echo '<pre/>';print_r($customerAddress );exit;









?>