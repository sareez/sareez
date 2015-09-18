<?php

require_once '../app/Mage.php';
//require_once '../db/connection.php';
Mage::app();

$conn = mysql_connect("localhost","hbanfvqkdv","tXySfqDmQ3") or die("ERROR::Not connected to SERVER"); 
$db = mysql_select_db("hbanfvqkdv",$conn) or die("ERROR::Not connected to DATABASE");




$local_conn = mysql_connect("www.babulall.com","anik","pass") or die("ERROR::Not connected to SERVER"); 
$db = mysql_select_db("anik",$local_conn) or die("ERROR::Not connected to DATABASE");
?>
<form name="upload_form" method="POST" ation="http://www.sareees.com/csv_upload/orders.php" enctype="multipart/form-data">
	<input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Excel" name="submit">
</form>
<?php
 if($_REQUEST['submit'])
{ 
	$postValues = $_POST;
	$target_dir = "order_excel/";
	$filename = explode(".", basename($_FILES["fileToUpload"]["name"]));
	$newfilename = time() . '.' .end($filename);
	$target_file = $target_dir . $newfilename;
	$uploadOk = 1;
	// Check if image file is a actual image or fake image
 	if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
	{
		echo "The file  has been uploaded.";
	} 
	else 
	{
		echo $_FILES["fileToUpload"]["name"]." Upload Error";
	} 
	require_once('excel_reader/excel_reader.php');
	$excel = new PhpExcelReader;
	$excel->read('order_excel/'.$newfilename);
	//$excel->read('order_excel/1431079053.xls');
	$excel_data = $excel->sheets;

	$count = count($excel_data[0]['cells']);
	echo "<pre>";
	print_r($excel_data);
	echo "</pre>"; 
	//$countorder = 1;
	$orders=array();
	$j = 0;
for($i=2; $i<=5; $i++)
{

	$order = Mage::getModel('sales/order')->loadByIncrementId($excel_data[0]['cells'][$i][1]);

	$email = $order->getCustomerEmail();
	$customer_name = $order->getCustomerName();
	$customer_id = $order->getCustomerId();
	
	/* $visitorData = Mage::getModel('customer/customer')->load($customer_id);
	$billingaddress = Mage::getModel('customer/address')->load($visitorData->default_billing); */
	$billingAddressData = $order->getBillingAddress()->getData();
	
	//shippingAddress = Mage::getModel('customer/address')->load($visitorData->default_shipping);
	//$shippingAddressData = $shippingAddress ->getData();
	$shippingAddressData = $order->getShippingAddress()->getData();
		
	 $orders[$j]['orders_id'] .= $excel_data[0]['cells'][$i][1];
	//exit;
	$orders[$j]['customers_id'] .= $customer_id;
	$orders[$j]['customer_name'] .= $customer_name;
	$orders[$j]['customers_email_address'] .= $email;
	$orders[$j]['payment_method'] .= $payment_method_code = $order->getPayment()->getMethodInstance()->getCode();
	$orders[$j]['date_purchased'] .= $order->getCreatedAt();
	$orders[$j]['orders_status'] .= $order->getStatus();
	$orders[$j]['currency'] .= $order->getOrderCurrencyCode();
	
	$orders[$j]['customers_address'] = array(
											"customers_company" => $billingAddressData['company'],
											"customers_street_address" => $billingAddressData['street'],
											"customers_suburb" => "",
											"customers_city" => $billingAddressData['city'],
											"customers_postcode" => $billingAddressData['postcode'],
											"customers_state" => $billingAddressData['region'],
											"customers_country" => $billingAddressData['country_id'],
											"customers_telephone" => $billingAddressData['telephone'],
										);
	
	$orders[$j]['delivery_address'] = array(
											"delivery_name" => $shippingAddressData['firstname'].$shippingAddressData['lastname'],
											"delivery_company" => $shippingAddressData['company'],
											"delivery_street_address" => $shippingAddressData['street'],
											"delivery_suburb" => '',
											"delivery_city" => $shippingAddressData['city'],
											"delivery_country" => $shippingAddressData['country_id'],
											"delivery_state" => $shippingAddressData['region'],
											"delivery_postcode" => $shippingAddressData['postcode'],
										);
										
	$orders[$j]['billing_address'] = array(
											"billing_name" => $billingAddressData['firstname'].$billingAddressData['lastname'],
											"billing_company" => $billingAddressData['company'],
											"billing_street_address" => $billingAddressData['street'],
											"billing_suburb" => "",
											"billing_city" => $billingAddressData['city'],
											"billing_postcode" => $billingAddressData['postcode'],
											"billing_state" => $billingAddressData['region'],
											"billing_country" => $billingAddressData['country_id'],
											"billing_telephone" => $billingAddressData['telephone'],
										);	
										
										
	//$orderItems = $order->getItemsCollection();
	$orderItems = $order->getAllItems();

	$orders[$j]['pricing'] = array(
									"ot_total" => number_format ($order->getGrandTotal(), 2, '.' , $thousands_sep = ''),
									"base_ot_total" => number_format ($order->getbaseGrandTotal(), 2, '.' , $thousands_sep = ''),
									"ot_shipping" => number_format ($order->getShippingAmount(), 2, '.' , $thousands_sep = ''),
									"base_ot_shipping" => number_format ($order->getbaseShippingAmount(), 2, '.' , $thousands_sep = ''),
									"ot_subtotal" => number_format ($order->getSubtotal(), 2, '.' , $thousands_sep = ''),
									"ot_subtotal" => number_format ($order->getSubtotal(), 2, '.' , $thousands_sep = ''),
									"base_ot_subtotal" => number_format ($order->getBaseSubtotal(), 2, '.' , $thousands_sep = ''),
									"coupon_code" => $order->getCouponCode(),
									"base_discount_amount" =>  number_format ($order->getBaseDiscountAmount(), 2, '.' , $thousands_sep = ''),
									"discount_amount" =>  number_format ($order->getDiscountAmount(), 2, '.' , $thousands_sep = '')

									);

 	 foreach ($orderItems as $item){
		$productid=$item->getProductId();
		$model = Mage::getModel('catalog/product');
		$_product = $model->load($productid);
		

		$orders[$j]['products'][] = array(
											"orders_products_id" => $item->getItemId(),
											"orders_id" => $item->getOrderId(),
											"products_id" => $item->getProductId(),
											"products_model" => $item->getSku(),
											"products_name" => $item->getName(),
											"products_image" => $_product->getSmallImage(),
											"normal_products_price" => $_product->getPrice(),
											"final_price" => ($_product->getSpecialPrice() == '') ? $_product->getPrice() : $_product->getSpecialPrice(),
											"products_quantity" => $item->getQtyOrdered(),
											"products_express" => $_product->getExpreesShippingAvailable()
										); 
		
		
		 $attributes = $item->getProductOptions();
		//$productID = $item->product_id;
		//echo "22222";
		//print_r($attributes['options']);
		
		$product = Mage::getModel('catalog/product')->load($productid);
		$options = Mage::getModel('catalog/product_option')->getProductOptionCollection($product);
		if(isset($attributes['options']))
		{
			
			foreach ($options as $option) {
				$values = Mage::getSingleton('catalog/product_option_value')->getValuesCollection($option);
				foreach ($values as $value) {
					if(in_array($value->getId(), explode(',', $attributes['options'][0]['option_value'])))
					{
						$orders[$j]['attributes'][] = array(
															"orders_id" => $orders[$j]['orders_id'],
															"orders_products_id" => $item->getItemId(),
															"products_options" => $value->getTitle(),
															"products_options_values" => $value->getTitle(),
															"options_values_price" => $value->getPrice()//*$order->getStoreToOrderRate() //uncomment to get the rate in the order currency
															
														);
					}
				}
			}
			
		} 
		
		//echo "22222";exit;
    }	 
	
	$chkSorder = "SELECT * from anik.orders WHERE orders_id ='".$orders[$j]['orders_id']."' ";

	$checkOrder = mysql_query($chkSorder);
	$orderExists = mysql_fetch_assoc($checkOrder);
	//print_r($orderExists);
	if(empty($orderExists))
	{
		
		
		
		$orderSql = "INSERT into anik.orders(orders_id, customers_id, customers_name, customers_company, customers_street_address, customers_suburb, customers_city, 
		customers_postcode, customers_state, customers_country, customers_telephone, customers_email_address, delivery_name, delivery_company, delivery_street_address,
		delivery_suburb, delivery_city, delivery_postcode, delivery_state, delivery_country, billing_name, billing_company, billing_street_address, billing_suburb
		,billing_city, billing_postcode, billing_state, billing_country, payment_method, date_purchased, orders_status, currency, flag) VALUES (
		'".$orders[$j]['orders_id']."','".$orders[$j]['customers_id']."','".$orders[$j]['customer_name']."','".$orders[$j]['customers_address']['customers_company']."','".$orders[$j]['customers_address']['customers_street_address']."','".$orders[$j]['customers_address']['customers_suburb']."','".$orders[$j]['customers_address']['customers_city']."',
		'".$orders[$j]['customers_address']['customers_postcode']."','".$orders[$j][$j]['customers_address']['customers_state']."','".$orders[$j]['customers_address']['customers_country']."','".$orders[$j]['customers_address']['customers_telephone']."','".$orders[$j]['customers_email_address']."','".$orders[$j]['delivery_address']['delivery_name']."',
		'".$orders[$j]['delivery_address']['delivery_company']."','".$orders[$j]['delivery_address']['delivery_street_address']."','".$orders[$j]['delivery_address']['delivery_suburb']."','".$orders[$j]['delivery_address']['delivery_city']."','".$orders[$j]['delivery_address']['delivery_postcode']."','".$orders[$j]['delivery_address']['delivery_state']."','".$orders[$j]['delivery_address']['delivery_country']."',
		'".$orders[$j]['billing_address']['billing_name']."','".$orders[$j]['billing_address']['billing_company']."','".$orders[$j]['billing_address']['billing_street_address']."','".$orders[$j]['billing_address']['billing_suburb']."','".$orders[$j]['billing_address']['billing_city']."','".$orders[$j]['billing_address']['billing_postcode']."','".$orders[$j]['billing_address']['billing_state']."',
		'".$orders[$j]['billing_address']['billing_country']."', '".$orders[$j]['payment_method']."', '".$orders[$j]['date_purchased']."', '".$orders[$j]['orders_status']."', '".$orders[$j]['currency']."', 1
		)";
			
		if(mysql_query($orderSql, $local_conn))
		{
			$query1 = "Insert into anik.orders_total VALUES ('','".$orders[$j]['orders_id']."','Sub-Total:','".$orders[$j]['currency'].$orders[$j]['pricing']['ot_subtotal']."', '".$orders[$j]['pricing']['base_ot_subtotal']."', 'ot_subtotal', 0, 1)";
			if(!mysql_query($query1, $local_conn))
			{
				echo $query1;
			}
			$query2 = mysql_query("Insert into anik.orders_total VALUES ('','".$orders[$j]['orders_id']."','Shipping:','".$orders[$j]['currency'].$orders[$j]['pricing']['ot_shipping']."', '".$orders[$j]['pricing']['base_ot_shipping']."', 'ot_shipping', 0, 1)", $local_conn);
			$query3 = mysql_query("Insert into anik.orders_total VALUES ('','".$orders[$j]['orders_id']."','Total:','".$orders[$j]['currency'].$orders[$j]['pricing']['ot_total']."', '".$orders[$j]['pricing']['base_ot_total']."', 'ot_total', 0, 1)", $local_conn);
			if($orders[$j]['pricing']['coupon_code'] !== '')
			{
				$query4 = mysql_query("Insert into orders_total VALUES ('','".$orders[$j]['orders_id']."','Discount:".$orders[$j]['currency'].$orders[$j]['pricing']['coupon_code']."','".$orders[$j]['pricing']['discount_amount']."', '".$orders[$j]['pricing']['base_discount_amount']."', 'ot_subtotal', 0, 1)", $local_conn);
			}
			foreach($orders[$j]['products'] as $product)
			{
				$orderProductsSql = "Insert into anik.orders_products (orders_products_id,orders_id,products_id,products_model,products_name,products_image,normal_product_price,products_price,final_price,products_quantity,flag,products_status,products_express) VALUES ('".$product['orders_products_id']."', '".$product['orders_id']."', '".$product['products_id']."',
				'".$product['products_model']."', '".$product['products_name']."' ,'".$product['products_image']."', '".$product['normal_products_price']."' ,'".$product['normal_products_price']."', '".$product['final_price']."','".$product['products_quantity']."' ,1, 1,'".$product['products_express']."' 
				)";
				
				if(!mysql_query($orderProductsSql, $local_conn))
				{
					echo $orderProductsSql;
				}
			}
			
			
			if(isset($order['attributes']))
			{
				foreach($order['attributes'] as $attribute)
				{
					$query5 = "Insert into anik.orders_products_attributes(orders_id,orders_products_id,products_options,products_options_values,options_values_price,price_prefix
					,flag) VALUES ('".$attribute['orders_id']."','".$attribute['orders_products_id']."','".$attribute['products_options']."','".$attribute['products_options_values']."','".$attribute['options_values_price']."', '+', 1)";
					if(!mysql_query($query5, $local_conn))
					{
						echo $query5;
					}
				}
			}
			
			//echo "chinmay *****************************************************"; 
			
			
			 $custTest= "SELECT * from sales_flat_order_item_stitching where increment_order_id = ".$orders[$j]['orders_id']."";
			
		
			//exit;
			$query6 = mysql_query($custTest,$conn) or die('error');
			
			while($r = mysql_fetch_assoc($query6))
			{
				
				if(preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $r['reciving_date']))
				{
					//echo "chinmay 2222*****************************************************"; 
					$receiving_status = 1;
					//exit;
				}
				else
				{
					//echo "chinmay 1111 *****************************************************"; 
					$receiving_status = 0;
						//exit;
				}
				
				echo "Test *****************************************************"; 
				echo $query7 = "INSERT INTO anik.ims_stitching_master(products_model, orders_products_id, products_id, orders_id, sending_date,receiving_date,tailor_master_id,stitching_status_id, stitching_comments,receiving_status)
				VALUES ('".$r['sku']."','".$r['item_id']."', '".$r['product_id']."', '".$r['order_id']."', '".$r['sending_date']."', '".$r['reciving_date']."', '".$r['tailormaster_id']."', '".$r['stitchingstatus_id']."', '".$r['comment']."', '".$receiving_status."' )";
				
				if(!mysql_query($query7,$local_conn))
				{
					echo $query7;
					//exit;
				}
					
			}
			
			
			
			
			
			
			
			
			
			
			
			
			 $sqlTest18 = "SELECT * from sales_flat_order where increment_id = '".$orders[$j]['orders_id']."'";
		$queryTest18 = mysql_query($sqlTest18,$conn) or die('error');
			while($tetr = mysql_fetch_assoc($queryTest18))
			{
				
				
			 $sqlquery8 = "SELECT * from sales_flat_order_status_history where parent_id = '".$tetr['entity_id']."'";
			//exit;
				$query8 = mysql_query($sqlquery8,$conn) or die('error');
				while($r = mysql_fetch_assoc($query8))
				{
					//echo "query8";exit;
					$query9 = "INSERT INTO anik.orders_status_history(orders_id, orders_status_id, date_added, customer_notified, comments, flag)
					VALUES ('".$r['parent_id']."','".$r['status']."', '".$r['created_at']."', '".$r['is_customer_notified']."', '".$r['comment']."',1)";
					if(!mysql_query($query9,$local_conn))
					{
						echo $query9;
					}
						
				}
				
				
				
			
		}
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
		
		
			 
			//echo "77777";exit;
			
			
		}
		else
		{
			//echo "<pre>";
			//echo $orderSql;
			//echo "</pre>"; 
		}
		
		$query10 = "UPDATE sales_flat_order_grid SET import_flag = 'Y' where increment_id = '".$orders[$j]['orders_id']."'";
		if(!mysql_query($query10,$conn))
		{
			echo $query10;
		}
		
	}
	$j++;
}
}



?>
