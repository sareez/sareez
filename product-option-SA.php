<?php
require_once 'app/Mage.php';
Mage::app();


$products = Mage::getModel('catalog/product')->getCollection()->addAttributeToSelect('*');
//$products = Mage::getModel('catalog/product')->getCollection()->addAttributeToSelect('*');
//Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);

$m=0;
foreach ($products as $product) {
	//echo "<pre>";
	//print_r($product);
	//echo "<pre>";
	echo 'chinmay'.$product['sku'];
	echo "</br>";
	$pos = strpos($product['sku'], 'SA');
	if($pos==true){
		$product_id=$product['entity_id'];
		//$product_id=1;
		if($product_id>63722 && $product_id<64642){
			
			
		error_reporting(0);
//$conn = mysql_connect("localhost","root","") or die("ERROR::Not connected to SERVER"); 
//$db = mysql_select_db("sarees_bkpdb_09_05",$conn) or die("ERROR::Not connected to DATABASE");

 $conn = mysql_connect("localhost","hbanfvqkdv","tXySfqDmQ3") or die("ERROR_QTY::Not connected to SERVER"); 
 $db = mysql_select_db("hbanfvqkdv",$conn) or die("ERROR_QTY::Not connected to DATABASE");
 
 echo 'chinmay'.$product_id;
 

		 echo $catalog_product_option="INSERT INTO `catalog_product_option` (`option_id`, `product_id`, `type`, `is_require`, `sku`, `max_characters`, `file_extension`, `image_size_x`, `image_size_y`, `sort_order`, `customoptions_is_onetime`, `image_path`, `customer_groups`, `qnty_input`, `in_group_id`, `is_dependent`, `div_class`, `sku_policy`, `image_mode`, `exclude_first_image`) 
		VALUES ('', '".$product_id."', 'checkbox', '0', NULL, NULL, NULL, NULL, NULL, '1', '0', '', '', '0', '131070', '0', '', '0', '1', '0')";
		
		exit;
	//mysql_query($catalog_product_option);
	 $catalog_last_Id = mysql_insert_id();
		//exit;
		
		
		
		
		$catalog_mode="INSERT INTO `custom_options_option_view_mode` (`view_mode_id`, `option_id`, `store_id`, `view_mode`) VALUES ('', '".$catalog_last_Id."', '0', '1')";
		mysql_query($catalog_mode);
		
		
		$catalog_title="INSERT INTO `catalog_product_option_title` (`option_title_id`, `option_id`, `store_id`, `title`) VALUES ('', '".$catalog_last_Id."', '0', 'EASY CUSTOMIZATION OPTION')";
		mysql_query($catalog_title);
	//$title_last_Id = mysql_insert_id();
	
	
			for($i=0;$i<4;$i++){
				
				if($i==0){
				 $catalog_value="INSERT INTO `catalog_product_option_type_value` (`option_type_id`, `option_id`, `sku`, `sort_order`, `customoptions_qty`, `default`, `in_group_id`, `dependent_ids`, `weight`, `cost`) VALUES
			('', '".$catalog_last_Id."', '', 1, '', 1, 65536, '', '0.0000', '0.0000')";
				mysql_query($catalog_value);
				}else if($i==1){
					 $catalog_value="INSERT INTO `catalog_product_option_type_value` (`option_type_id`, `option_id`, `sku`, `sort_order`, `customoptions_qty`, `default`, `in_group_id`, `dependent_ids`, `weight`, `cost`) VALUES
			('', '".$catalog_last_Id."', '', 2, '', 1, 65536, '', '0.0000', '0.0000')";
				mysql_query($catalog_value);
				}else if($i==2){
						
					$catalog_value="INSERT INTO `catalog_product_option_type_value` (`option_type_id`, `option_id`, `sku`, `sort_order`, `customoptions_qty`, `default`, `in_group_id`, `dependent_ids`, `weight`, `cost`) VALUES
			('', '".$catalog_last_Id."', '', 3, '', 0, 65536, '', '0.0000', '0.0000')";
				mysql_query($catalog_value);
						
					}else{
						
					$catalog_value="INSERT INTO `catalog_product_option_type_value` (`option_type_id`, `option_id`, `sku`, `sort_order`, `customoptions_qty`, `default`, `in_group_id`, `dependent_ids`, `weight`, `cost`) VALUES
			('', '".$catalog_last_Id."', '', 4, '', 0, 65536, '', '0.0000', '0.0000')";
				mysql_query($catalog_value);
					
				}
			//echo $value_last_Id = mysql_insert_id();
			
			//$write = Mage::getSingleton('core/resource')->getConnection('core_read');	
			
			//echo "1111";exit;
			
			$sql1=mysql_query("SELECT max(option_type_id) FROM catalog_product_option_type_value");
			
			
				while ($row = mysql_fetch_array($sql1) ) {
						print_r($row[0]);
						if($i==0){					
							  $catalog_value="INSERT INTO `catalog_product_option_type_title` (`option_type_title_id`, `option_type_id`, `store_id`, `title`) VALUES ('', '".$row[0]."', 0, 'Blouse Stitching')";
							mysql_query($catalog_value);
							
							
							$catalog_price="INSERT INTO `catalog_product_option_type_price` (`option_type_price_id`, `option_type_id`, `store_id`, `price`, `price_type`) VALUES ('', '".$row[0]."', '0', '9.00', 'fixed')";
							mysql_query($catalog_price);
							
						}else if($i==1){
							
							  $catalog_value="INSERT INTO `catalog_product_option_type_title` (`option_type_title_id`, `option_type_id`, `store_id`, `title`) VALUES ('', '".$row[0]."', 0, 'Standard Petticoat')";
							mysql_query($catalog_value);
							
							$catalog_price="INSERT INTO `catalog_product_option_type_price` (`option_type_price_id`, `option_type_id`, `store_id`, `price`, `price_type`) VALUES ('', '".$row[0]."', '0', '5.00', 'fixed')";
							mysql_query($catalog_price);
							
						}else if($i==2){
							
							  $catalog_value="INSERT INTO `catalog_product_option_type_title` (`option_type_title_id`, `option_type_id`, `store_id`, `title`) VALUES ('', '".$row[0]."', 0, 'Customize Petticoat')";
							mysql_query($catalog_value);
							
							$catalog_price="INSERT INTO `catalog_product_option_type_price` (`option_type_price_id`, `option_type_id`, `store_id`, `price`, `price_type`) VALUES ('', '".$row[0]."', '0', '8.00', 'fixed')";
							mysql_query($catalog_price);
							
						}else{
							
							  $catalog_value="INSERT INTO `catalog_product_option_type_title` (`option_type_title_id`, `option_type_id`, `store_id`, `title`) VALUES ('', '".$row[0]."', 0, 'Pre-Stitching')";
							mysql_query($catalog_value);
							
							$catalog_price="INSERT INTO `catalog_product_option_type_price` (`option_type_price_id`, `option_type_id`, `store_id`, `price`, `price_type`) VALUES ('', '".$row[0]."', '0', '9.00', 'fixed')";
							mysql_query($catalog_price);
						}
					//exit;
					
					
					
					
					
					}
			
			
			
			
			}
	
	
		$product->save();
		
		
	$m++;	
	}
	}
}
echo $m;




























/*
$orders = Mage::getModel('sales/order')->getCollection();
foreach ($orders as $order) {
    $email = $order->getCustomerEmail();
    echo $order->getId() . ": '" . $order->getIncrementId() . "', " . $email . "\n";
}*/



/*INSERT INTO `sarees_bkpdb_09_05`.`catalog_product_option` (`option_id`, `product_id`, `type`, `is_require`, `sku`, `max_characters`, `file_extension`, `image_size_x`, `image_size_y`, `sort_order`, `customoptions_is_onetime`, `image_path`, `customer_groups`, `qnty_input`, `in_group_id`, `is_dependent`, `div_class`, `sku_policy`, `image_mode`, `exclude_first_image`) VALUES (NULL, '1', 'checkbox', '0', NULL, NULL, NULL, NULL, NULL, '1', '0', '', '', '0', '131070', '0', '', '0', '1', '0');




INSERT INTO `sarees_bkpdb_09_05`.`catalog_product_option_title` (`option_title_id`, `option_id`, `store_id`, `title`) VALUES (NULL, '43', '0', 'EASY CUSTOMIZATION OPTION');




INSERT INTO `catalog_product_option_type_value` (`option_type_id`, `option_id`, `sku`, `sort_order`, `customoptions_qty`, `default`, `in_group_id`, `dependent_ids`, `weight`, `cost`) VALUES
(107, 43, '', 1, '', 1, 65536, '', '0.0000', '0.0000'),
(108, 43, '', 2, '', 1, 65542, '', '0.0000', '0.0000'),
(109, 43, '', 3, '', 0, 65543, '', '0.0000', '0.0000'),
(110, 43, '', 4, '', 0, 65539, '', '0.0000', '0.0000');




INSERT INTO `catalog_product_option_type_title` (`option_type_title_id`, `option_type_id`, `store_id`, `title`) VALUES
(111, 107, 0, 'Blowse Stitching'),
(112, 108, 0, 'Standard Petticoat'),
(113, 109, 0, 'Customize Petticoat'),
(114, 110, 0, 'Pre-Stitching');
*/

?>