<?php
require_once 'app/Mage.php';
Mage::app();

$host = "localhost";
$user = "hbanfvqkdv";
$pwd = "tXySfqDmQ3";
$dbname = "hbanfvqkdv";

$productID = array(66968,66969,66970,66971,66972,66973,66974,66975,66976,66977,66978,66979,66980,66981,66982,66983,66984,66985,66986,66987,66988,66989,66990,66991,66992,66993,66994,66995,66996,66997,66998,66999,67000,67001,67002,67003,67004,67005,67006,67007,67008,67009,67010,67011,67012,67013,67014,67015,67016,67017,67018,67019,67020,67021,67022,67023,67024,67025,67026,67027,67028,67029,67030,67031);
//echo "<pre>"; print_r($productID); die;


$x=0;
//for ($i=65030; $i<=65075; $i++){
foreach($productID as $prod){	
	$i=$prod;
	//echo $i."KKKKK"; die;
	$product = Mage::getModel('catalog/product')->load($i);
	$prod_sku = $product->getSku(); 
	$prod_name = $product->getName(); 
	$prod_name = strtolower($prod_name);
	$final_prod_name = str_replace(" ", "-", $prod_name);

	//echo $prod_sku."PPP".$prod_name."||Naba".$final_prod_name; die;
	
	$conn = mysql_connect("$host","$user","$pwd") or die("ERROR::Not connected to SERVER");	
	$db = mysql_select_db("$dbname",$conn) or die("ERROR::Not connected to DATABASE");
   

	
	
		$simpleProduct = Mage::getModel('catalog/product')->loadByAttribute('sku',$prod_sku);	
		if($simpleProduct) {
			//$simpleProduct->setDescription($newDescription);
			$simpleProduct->setUrlKey($final_prod_name);
			$simpleProduct->save();
			echo "Updated product " . $prod_sku . "<br>"; 
			$x++;
		}

}

echo $x."= ROWS UPDATED!!"
?>