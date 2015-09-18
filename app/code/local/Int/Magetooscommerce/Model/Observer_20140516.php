<?php

class Int_Magetooscommerce_Model_Observer extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('magetooscommerce/magetooscommerce');
    }
    
    /* Function addOrderData() add order data to 
     * oscommners structured table
     * 
     *
     */
    public function addOrderDataToOS($observer){
		
			
		$order = $observer->getOrder(); // Get order-id when order is made by user from frontend
		
		/* Insert data into table orders 
		 * */
		$customer 			= Mage::getModel('customer/customer')->load($order->getCustomerId()); 
		$customers_id 		= $order->getCustomerId();
			
		$shipping_address	= $order->getShippingAddress();
		
		$customers_name  	= $shipping_address->getName();
		//customers_company = 
		$customers_street_address = $shipping_address->getData('street');
		//customers_suburb
		$customers_city  	= $shipping_address->getCity();
		$customers_postcode = $shipping_address->getPostcode();
		$customers_state 	= $shipping_address->getData('region');
		$customers_country 	= Mage::getModel('directory/country')->load($shipping_address->getCountry())->getName();
		$customers_telephone =$shipping_address->getTelephone();
		$customers_email_address = $customer->getEmail();
		//customers_address_format_id
				
		$delivery_name  	= $shipping_address->getName();
		$delivery_company  	= $shipping_address->getCompany();
		$delivery_street_address = $shipping_address->getData('street');
		//$delivery_suburb
		$delivery_city  	= $shipping_address->getCity();
		$delivery_postcode 	= $shipping_address->getPostcode();
		$delivery_state 	= $shipping_address->getData('region');
		$delivery_country 	= Mage::getModel('directory/country')->load($shipping_address->getCountry())->getName();
		//$delivery_address_format_id
		
		$billing_address	= $order->getBillingAddress();
		
		$billing_name 		= $billing_address->getName();
		$billing_company 	= $billing_address->getCompany();
		$billing_street_address = $billing_address->getData('street');
		//$billing_suburb = $billing_address->getCompany();
		$billing_city 		= $billing_address->getCity();
		$billing_postcode 	= $billing_address->getPostcode();
		$billing_state 		= $billing_address->getData('region');
		$billing_country 	= Mage::getModel('directory/country')->load($billing_address->getCountry())->getName();
		//$billing_address_format_id = $billing_address->getCompany();
		
		
		$payment_method 	=  $order->getPayment()->getMethodInstance()->getCode();
		$date_purchased 	=  $order->getCreatedAt();
		$currency			=  $order->getOrderCurrencyCode();
		$currency_value 	=  $order->getStoreToOrderRate();
		
		//Connect to database	
		$dbConnection = Mage::getSingleton('core/resource')->getConnection('core_write');

		$query = "INSERT INTO orders set
		customers_id 		= '{$customers_id}',
		customers_name  	= '{$customers_name}',
		
		customers_street_address = '{$customers_street_address}',
		
		customers_city  	= '{$customers_city}',
		customers_postcode  = '{$customers_postcode}',
		customers_state 	= '{$customers_state}',
		customers_country 	= '{$customers_country}',
		customers_telephone = '{$customers_telephone}',
		customers_email_address = '{$customers_email_address}',
		
		
		
		delivery_name  	='{$delivery_name}',
		delivery_company  	= '{$delivery_company}',
		delivery_street_address = '{$delivery_street_address}',
		
		delivery_city  	= '{$delivery_city}',
		delivery_postcode 	= '{$delivery_postcode}',
		delivery_state 	= '{$delivery_state}',
		delivery_country 	= '{$delivery_country}',
			
		
		billing_name 		= '{$billing_name}',
		billing_company 	= '{$billing_company}',
		billing_street_address = '{$billing_street_address}',
		
		billing_city 		= '{$billing_city}',
		billing_postcode 	= '{$billing_postcode}',
		billing_state 		= '{$billing_state}',
		billing_country 	= '{$billing_country}',
		
		payment_method 	= '{$payment_method}',
		date_purchased 	= '{$date_purchased}',
		currency		= '{$currency}',
		currency_value 	= '{$currency_value}'			
		";
		
		//Excute query to insert order data in orders table		
		$dbConnection->query($query);  
		$oscOrderId = $dbConnection->lastInsertId(); // Order_id of table orders which is order-id of oscommerce structure table
		
		/*=================================================
		orders_status_history
		=================================================
		orders_status_history_id
		orders_id
		orders_status_id
		date_added
		customer_notified
		comments
		flag
		*/	
		
		$query = "INSERT INTO orders_status_history set
		orders_id 			= '{$oscOrderId}',
		orders_status_id 	= 1,
		date_added			= '{$date_purchased}',
		customer_notified	= 1"; 
		 
		//Excute query to order data in orders table		
		$dbConnection->query($query);
		
		
		/* ===================================================================
		 * Insert data into table orders_products, fields of table are as : 
		 * ===================================================================
		
		orders_products_id
		orders_id
		products_id
		products_model
		products_name
		products_image
		normal_product_price
		products_price
		final_price
		products_tax
		products_quantity
		flag
		products_status (Descending 1=processing, 10=cancel, 11=replacement, 12=shipped, 0=No status)
		products_express
		*/
		
		
		
		$productsItems = $order->getAllVisibleItems();

		foreach ($productsItems as $item) {
			$arrItem = $item->getData(); 
		  //$total+=($qty); 
		  
			$orders_id 			= $oscOrderId;
			$products_id 		= $arrItem['item_id'];
			$products_model 	= $arrItem['sku'];
			$products_name  	= $arrItem['name']; 
			//$products_image	= $arrItem['item_id'];
			$normal_product_price =  Mage::getModel('catalog/product')->load($arrItem['item_id'])->getPrice(); 
			$products_price	= $arrItem['price'];
			$final_price		= $arrItem['price'];
			$products_tax		= $arrItem['tax_amount'];
			$products_quantity	= $arrItem['qty_ordered'];
			$products_status	= 1; 
			//$products_express 
			
			$query = "INSERT INTO orders_products set
			orders_id 		= '{$orders_id}',
			products_id 	= '{$products_id}',
			products_model 	= '{$products_model}',
			products_name  	= '{$products_name}',
			
			normal_product_price = '{$normal_product_price}',
			products_price	= '{$products_price}',
			final_price		= '{$final_price}',
			products_tax	= '{$products_tax}',
			products_quantity= '{$products_quantity}',
			products_status	= 1	"; 
			 
			//Excute query to order data in orders table		
			$dbConnection->query($query);
			
			/*==============================================
			 * Insert data into table orders_products_attributes, fields of table are as : 
			 * =============================================
			
			orders_products_attributes_id
			orders_id
			orders_products_id
			products_options
			products_options_values
			options_values_price
			price_prefix
			flag
			*/
			
			$options = $item->getProductOptions();
			try{
				foreach($options['options']  as $option){
					//print_r($option[0]);
					//exit();
					$arrOptVal  = explode('-',$option['value']);
					$arrProdOption = explode(' ',trim($arrOptVal[0]));
					$ProdOptions = $arrProdOption[0];
					$products_options = $ProdOptions[0];
					$options_values_price = substr(trim($arrOptVal[1]),1);
					
					$query = "INSERT INTO orders_products_attributes set
					orders_id 		= '{$orders_id}',
					orders_products_id 	= '{$arrItem["item_id"]}',
					products_options 	= '{$products_options}',
					products_options_values  	= '{$arrOptVal[0]}',
					options_values_price = '{$options_values_price}',
					price_prefix	= '+'"; 
					 
					//Excute query to order data in orders table		
					$dbConnection->query($query);
					
				}
			}catch(Exception $e){
				echo "Error : ", $e->getMessage();
			}
						  
		} 
		/*================================================
			 orders_total
			================================================
			orders_total_id
			orders_id
			title
			text
			value
			class
			sort_order
			flag
			* $order->getSubtotal() $order->getGrandTotal() - $order->getShippingAmount();
			* 
		*/           
		
	
		
		
	}
}

