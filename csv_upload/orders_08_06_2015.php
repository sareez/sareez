<?php
require_once '../app/Mage.php';
require_once '../db/connection.php';
Mage::app();
?>
<form name="upload_form" method="POST" ation="http://sareees.com/csv_upload/orders.php" enctype="multipart/form-data">
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
	//$excel->read('order_excel/1430480227.xls');
	$excel_data = $excel->sheets;

	$count = count($excel_data[0]['cells']);
	print($count);
	//$countorder = 1;
	$j = 0;
for($i=2; $i<=$count; $i++)
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
		
	$orders[$j]['orders_id'] = $excel_data[0]['cells'][$i][2];
	$orders[$j]['customers_id'] = $customer_id;
	$orders[$j]['customer_name'] = $customer_name;
	$orders[$j]['customers_email_address'] = $email;
	$orders[$j]['payment_method'] = $payment_method_code = $order->getPayment()->getMethodInstance()->getCode();
	$orders[$j]['date_purchased'] = $order->getCreatedAt();
	$orders[$j]['orders_status'] = $order->getStatus();
	$orders[$j]['currency'] = $order->getOrderCurrencyCode();
	
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
		
		
    }
		
   	$j++;
}
echo "<pre>";
print_r($orders);
echo "</pre>";


foreach($orders as $order)
{
	$checkOrder = mysql_query("SELECT * from anik.orders WHERE orders_id =". $order['orders_id']);
	$orderExists = mysql_fetch_assoc($checkOrder);
	
	if(empty($orderExists))
	{
		$orderSql = "INSERT into anik.orders(orders_id, customers_id, customers_name, customers_company, customers_street_address, customers_suburb, customers_city, 
		customers_postcode, customers_state, customers_country, customers_telephone, customers_email_address, delivery_name, delivery_company, delivery_street_address,
		delivery_suburb, delivery_city, delivery_postcode, delivery_state, delivery_country, billing_name, billing_company, billing_street_address, billing_suburb
		,billing_city, billing_postcode, billing_state, billing_country, payment_method, date_purchased, orders_status, currency, flag) VALUES (
		'".$order['orders_id']."','".$order['customers_id']."','".$order['customer_name']."','".$order['customers_address']['customers_company']."','".$order['customers_address']['customers_street_address']."','".$order['customers_address']['customers_suburb']."','".$order['customers_address']['customers_city']."',
		'".$order['customers_address']['customers_postcode']."','".$order[$j]['customers_address']['customers_state']."','".$order['customers_address']['customers_country']."','".$order['customers_address']['customers_telephone']."','".$order['customers_email_address']."','".$order['delivery_address']['delivery_name']."',
		'".$order['delivery_address']['delivery_company']."','".$order['delivery_address']['delivery_street_address']."','".$order['delivery_address']['delivery_suburb']."','".$order['delivery_address']['delivery_city']."','".$order['delivery_address']['delivery_postcode']."','".$order['delivery_address']['delivery_state']."','".$order['delivery_address']['delivery_country']."',
		'".$order['billing_address']['billing_name']."','".$order['billing_address']['billing_company']."','".$order['billing_address']['billing_street_address']."','".$order['billing_address']['billing_suburb']."','".$order['billing_address']['billing_city']."','".$order['billing_address']['billing_postcode']."','".$order['billing_address']['billing_state']."',
		'".$order['billing_address']['billing_country']."', '".$order['payment_method']."', '".$order['date_purchased']."', '".$order['orders_status']."', '".$order['currency']."', 1
		)";
			
		if(mysql_query($orderSql))
		{
			$query1 = "Insert into anik.orders_total VALUES ('','".$order['orders_id']."','Sub-Total:','".$order['currency'].$order['pricing']['ot_subtotal']."', '".$order['pricing']['base_ot_subtotal']."', 'ot_subtotal', 0, 1)";
			if(!mysql_query($query1))
			{
				echo $query1;
			}
			$query2 = mysql_query("Insert into anik.orders_total VALUES ('','".$order['orders_id']."','Shipping:','".$order['currency'].$order['pricing']['ot_shipping']."', '".$order['pricing']['base_ot_shipping']."', 'ot_shipping', 0, 1)");
			$query3 = mysql_query("Insert into anik.orders_total VALUES ('','".$order['orders_id']."','Total:','".$order['currency'].$order['pricing']['ot_total']."', '".$order['pricing']['base_ot_total']."', 'ot_total', 0, 1)");
			if($order['pricing']['coupon_code'] !== '')
			{
				$query4 = mysql_query("Insert into orders_total VALUES ('','".$order['orders_id']."','Discount:".$order['currency'].$order['pricing']['coupon_code']."','".$order['pricing']['discount_amount']."', '".$order['pricing']['base_discount_amount']."', 'ot_subtotal', 0, 1)");
			}
			foreach($order['products'] as $product)
			{
				$orderProductsSql = "Insert into anik.orders_products (orders_products_id,orders_id,products_id,products_model,products_name,products_image,normal_product_price,products_price,final_price,products_quantity,flag,products_status,products_express) VALUES ('".$product['orders_products_id']."', '".$product['orders_id']."', '".$product['products_id']."',
				'".$product['products_model']."', '".$product['products_name']."' ,'".$product['products_image']."', '".$product['normal_products_price']."' ,'".$product['normal_products_price']."', '".$product['final_price']."','".$product['products_quantity']."' ,1, 1,'".$product['products_express']."' 
				)";
				
				if(!mysql_query($orderProductsSql))
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
					if(!mysql_query($query5))
					{
						echo $query5;
					}
				}
			}
			
			$query6 = mysql_query("SELECT * from sareees_db.sales_flat_order_item_stitching where order_id = ".$order['orders_id']);
			while($r = mysql_fetch_assoc($query6))
			{
				if(preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $r['reciving_date']))
				{
					$receiving_status = 1;
				}
				else
				{
					$receiving_status = 0;
				}
				$query7 = "INSERT INTO anik.ims_stitching_master(products_model, orders_products_id, products_id, orders_id, sending_date,receiving_date,tailor_master_id,stitching_status_id, stitching_comments,receiving_status)
				VALUES ('".$r['sku']."','".$r['item_id']."', '".$r['product_id']."', '".$r['order_id']."', '".$r['sending_date']."', '".$r['reciving_date']."', '".$r['tailormaster_id']."', '".$r['stitchingstatus_id']."', '".$r['comment']."', '".$receiving_status."' )";
				if(!mysql_query($query7))
				{
					echo $query7;
				}
					
			}
			$query8 = mysql_query("SELECT * from sareees_db.sales_flat_order_status_history where parent_id = ".$order['orders_id']);
			while($r = mysql_fetch_assoc($query8))
			{
				$query9 = "INSERT INTO anik.orders_status_history(orders_id, orders_status_id, date_added, customer_notified, comments, flag)
				VALUES ('".$r['parent_id']."','".$r['status']."', '".$r['created_at']."', '".$r['is_customer_notified']."', '".$r['comment']."',1)";
				if(!mysql_query($query9))
				{
					echo $query9;
				}
					
			}
		}
		else
		{
			echo "<pre>";
			echo $orderSql;
			echo "</pre>"; 
		}
		
		$query10 = "UPDATE sales_flat_order_grid SET import_flag = 1 where entity_id = '".$order['orders_id']."'";
		if(!mysql_query($query10))
		{
			echo $query10;
		}
		
	}
} 
}



?>