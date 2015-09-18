<?php 
require('includes/application_top.php');
require('includes/functions/function_as.php');
include ('includes/functions/pagination3.php');

require("PHP_SMTP/class.phpmailer.php");
require(DIR_WS_CLASSES . 'currencies.php');
$currencies = new currencies();


	




if(isset($_REQUEST['page']) && $_REQUEST['page'] !='')
{
	$_SESSION['PAGE']=$_REQUEST['page'];
}

// update for shipping at db //
if($_POST['update_stithing']=='UPDATE')
{



include_once('../connection_include/connection_script.php');

$notify_customer=$_POST['chk_notify'];



if(isset($_POST['chkAssign']))
		{
		
		foreach ($_POST['chkAssign'] as $key => $value )
			{
				$shipping_id=$_POST['chkAssign'][$key];
				$products_model=$_POST['hidSku'][$key];
				//$tracking_id=$_POST['trackId'][$key];
				$tracking_id=$_POST['trackId'];
				//$shipDate=$_POST['shipDate'][$key];
				$shipDate=$_POST['shipDate'];
				$shipping_status=$_POST['selShippingStatus'][$key];
			
				
				$comments=trim($_POST['Comments'][$key]);
				//$courier=$_POST['selCourier'][$key];
				$courier=$_POST['selCourier'];
				$orders_id=$_POST['hidOrderId'][$value];
				
				$stitching_id=$_POST['hid_Stitchin_id'][$value];
					
					
						
					// yotpo code start here //
					/* if(isset($shipping_status) & $shipping_status=='2')
					{
						
						$rsOrderProductsInfo=mysql_fetch_array(mysql_query("select products_id, products_name, products_image, final_price from orders_products where products_model='".$products_model."'"));
						
						
						$customerEmailAddress=GetField('orders','orders_id','customers_email_address',$orders_id);//Getfield
						$customerName=GetField('orders','orders_id','customers_name',$orders_id);//Getfield
						$orderDate=GetField('orders','orders_id','date_purchased',$orders_id);//Getfield
						$productId=$rsOrderProductsInfo['products_id'];//orderProducts
						$productName=$rsOrderProductsInfo['products_name'];//orderProducts
						$productImageUrl="http://static.sareez.com/images/".$rsOrderProductsInfo['products_image'];//orderProducts
						$productDescription=GetField('products_description','products_id','products_description',$rsOrderProductsInfo['products_id']);//Getfield
						$productPrice=$rsOrderProductsInfo['final_price'];//orderProducts
						
						
						$checking= "{\n    \"utoken\": \"mVNHRywrV8SbvsElg7hxk4RD7Djg6DOBSB67MZA1\",\n    \"email\": \"$customerEmailAddress\",\n    \"customer_name\": \"$customerName\",\n    \"order_id\": \"$orders_id\",\n    \"platform\": \"general\",\n    \"order_date\": \"$orderDate\",\n    \"currency_iso\": \"USD\",\n    \"products\": {\n        \"$productId\": {\n            \"url\": \"http://www.sareez.com/product_info.php?products_id=$productId\",\n            \"name\": \"$productName\",\n            \"image\": \"$productImageUrl\",\n            \"description\": \"$productDescription\",\n            \"price\": \"$productPrice\"\n        }\n    }\n}";
						
						
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, "https://api.yotpo.com/apps/unnusoQavcxaMsYqujTnd4BmSzwKMcAwtBbEOvPy/purchases");
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
						curl_setopt($ch, CURLOPT_HEADER, FALSE);
						curl_setopt($ch, CURLOPT_POST, TRUE);
						curl_setopt($ch, CURLOPT_POSTFIELDS, $checking);
						/*curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n    \"utoken\": \"mVNHRywrV8SbvsElg7hxk4RD7Djg6DOBSB67MZA1\",\n    \"email\": \"$customerEmailAddress\",\n    \"customer_name\": \"$customerName\",\n    \"order_id\": \"$orders_id\",\n    \"platform\": \"general\",\n    \"order_date\": \"$orderDate\",\n    \"currency_iso\": \"USD\",\n    \"products\": {\n        \"$productId\": {\n            \"url\": \"http://www.sareez.com/product_info.php?products_id=$productId\",\n            \"name\": \"$productName\",\n            \"image\": \"$productImageUrl\",\n            \"description\": \"$productDescription\",\n            \"price\": \"$productPrice\"\n        }\n    }\n}");*/
						/*curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
						$response = curl_exec($ch);
						curl_close($ch);	
						
						var_dump($response);
						
						echo $checking= "{\n    \"utoken\": \"mVNHRywrV8SbvsElg7hxk4RD7Djg6DOBSB67MZA1\",\n    \"email\": \"$customerEmailAddress\",\n    \"customer_name\": \"$customerName\",\n    \"order_id\": \"$orders_id\",\n    \"platform\": \"general\",\n    \"order_date\": \"$orderDate\",\n    \"currency_iso\": \"USD\",\n    \"products\": {\n        \"$productId\": {\n            \"url\": \"http://www.sareez.com/product_info.php?products_id=$productId\",\n            \"name\": \"$productName\",\n            \"image\": \"$productImageUrl\",\n            \"description\": \"$productDescription\",\n            \"price\": \"$productPrice\"\n        }\n    }\n}";
						
						die();
					}*/
					
					
				
					// end: yotpo code start here //
					
											
				
				if(isset($tracking_id) && $tracking_id!='')
				{
			
					$sqlInsert="update ims_orders_shipping22 set  shipped_products_qty='1', tracking_id='$tracking_id'";
					
					if($shipDate!='')
					{
						$sqlInsert .=",shipped_date='$shipDate'";
					}	
					$sqlInsert .=",shipping_status='$shipping_status',comments='$comments',courier='$courier',dos=NOW() WHERE shipping_id='".$shipping_id."'";
					
					echo $sqlInsert;
					exit;
					mysql_query($sqlInsert,$conn_local) or die ($sqlInsert."Could not insert the details on local");
										
					// for remote server //
					mysql_query($sqlInsert,$conn_remote)  or die ($sqlInsert."Could not insert the details on Remote");
					
					if(isset($comments) && $comments!=''){
					// insert into shipping status history table //	
					$sqlInsertStatus="insert into  ims_shipping_status_history (shipping_id,shipping_status_id,stitching_id,shipping_comments,doc) values ('$shipping_id','$shipping_status','$stitching_id','$comments',NOW())";					
					mysql_query($sqlInsertStatus,$conn_local) or die ($sqlInsert."Could not insert the details on local");
					
					}					
										
					// update for product lavel status and stiting master table  after shipping the product //
					if($shipping_status=='2')
					{
						$sqlUpdate="update ims_products_level_status set orders_products_status_id='12' where stitching_id='".$stitching_id."'";
						mysql_query($sqlUpdate,$conn_local) or die ($sqlUpdate."Could not update the details on local");						
						
						$sqlUpdate2="update ims_stitching_master set stitching_status_id='15', orders_products_status_id='12' where stitching_id='".$stitching_id."'";
						mysql_query($sqlUpdate2,$conn_local) or die ($sqlUpdate2."Could not update the details on local");						
					
						$sqlUpdate3="update ims_stitching_master set orders_products_status_id='12' where stitching_id='".$stitching_id."'";
						mysql_query($sqlUpdate3,$conn_local) or die ($sqlUpdate3."Could not update the details on local");				
					
						// for live db update
						$orders_products_id=GetField(ims_orders_shipping,shipping_id,orders_products_id,$shipping_id);
						$UpdateStatus=mysql_query('update orders_products set products_status="12" where orders_products_id="'.$orders_products_id.'"',$conn_local);
						echo $conn_remote;
						echo 'update orders_products set products_status="12" where orders_products_id="'.$orders_products_id.'"',$conn_remote;
						exit;
						$UpdateStatus=mysql_query('update orders_products set products_status="12" where orders_products_id="'.$orders_products_id.'"',$conn_remote);					
					
					}					
					//		
				}elseif($shipping_status=='3'){
				// update on present staus//
					$sqlUpdateStatus="update ims_orders_shipping set  shipping_status='$shipping_status',comments='$comments' WHERE shipping_id='".$shipping_id."'";					
					mysql_query($sqlUpdateStatus,$conn_local) or die ($sqlInsert."Could not insert the details on local");
				
				// insert into shipping status history table //	
					$sqlInsertStatus="insert into  ims_shipping_status_history (shipping_id,shipping_status_id,stitching_id,shipping_comments,doc) values ('$shipping_id','$shipping_status','$stitching_id','$comments',NOW())";					
					mysql_query($sqlInsertStatus,$conn_local) or die ($sqlInsert."Could not insert the details on local");
								
				} else{
					echo "<script>alert('Trackig ID can not be left blank !!');</script>";
					SendURL('orders_shipping.php?mode=open&orderId='.$orders_id);
					exit();
				}
						
			}
		
		
		// FOR EMAIL TO CUSTOMER AND UPDATE STATUS //
		$shipmentInfo = tep_db_query("select * from ims_orders_shipping where shipping_id = '" . (int)$shipping_id . "'");
		$rsShipment = tep_db_fetch_array($shipmentInfo);
	
	
		$oId=$HTTP_POST_VARS['orders_id_hid'];
	
		$check_status_query = tep_db_query("select customers_name, customers_email_address, orders_status, date_purchased from " . TABLE_ORDERS . " where orders_id = '" . (int)$oId . "'");
		$check_status = tep_db_fetch_array($check_status_query);
		
		
		
		//tep_db_query("update " . TABLE_ORDERS . " set orders_status = '4', last_modified = now() where orders_id = '" . (int)$oId . "'");
		
		if($shipping_status=='2')
		{
			mysql_query("update " . TABLE_ORDERS . " set orders_status = '4', last_modified = now() where orders_id = '" . (int)$oId . "'",$conn_local);
			mysql_query("update " . TABLE_ORDERS . " set orders_status = '4', last_modified = now() where orders_id = '" . (int)$oId . "'",$conn_remote);
		}
		
		//$emailed = STORE_NAME . "\n" . EMAIL_SEPARATOR . "\n" . EMAIL_TEXT_ORDER_NUMBER . ' ' . $oId . "\n" . EMAIL_TEXT_INVOICE_URL . ' ' . tep_catalog_href_link(FILENAME_CATALOG_ACCOUNT_HISTORY_INFO, 'order_id=' . $oId, 'SSL') . "\n" . EMAIL_TEXT_DATE_ORDERED . ' ' . tep_date_long($check_status['date_purchased']) . "\n";
		
		//$emailed = STORE_NAME . "\n" . "-------------------" . "\n" . "Order Number:" . ' ' . $oId . "\n" . "Detailed Invoice:" . ' ' . tep_catalog_href_link(FILENAME_CATALOG_ACCOUNT_HISTORY_INFO, 'order_id=' . $oId, 'SSL') . "\n" . "Date Ordered:" . ' ' . tep_date_long($check_status['date_purchased']) . "\n";

	$emailed = STORE_NAME . "\n" . "-------------------" . "\n" . "Order Number:" . ' ' . $oId . "\n" . "Detailed Invoice:" . ' ' . ' http://www.sareez.com/account_history_info.php?order_id=' . $oId . "\n" . "Date Ordered:" . ' ' . tep_date_long($check_status['date_purchased']) . "\n";

	
	$insertInDB ='The following product(s) has been shipped:'.'\n\n';


		$Info1 = mysql_query("select sum(shipped_products_qty) as qty,products_model,orders_id,tracking_id from ims_orders_shipping where tracking_id = '" . $rsShipment["tracking_id"] . "' and orders_id='$oId' group by products_model");
		
		while($rsInfoShi1p1 = mysql_fetch_array($Info1)){
		
	  $insertInDB .='SKU -'.$rsInfoShi1p1['products_model'].'\t\t [QTY- '.$rsInfoShi1p1['qty'].']\n';

	  }
	$insertInDB .='\n';
	
	if($rsShipment["courier"]=='handDelivery')
	{
    	$insertInDB .=' Courier By : '    .$rsShipment["courier"].'\n';
		$insertInDB .=' Delivery Boy :'.$rsShipment["tracking_id"].'\n\n';
	}else{
		$insertInDB .=' Courier Name :'    .$rsShipment["courier"].'\n';
		$insertInDB .=' Tracking ID :'   .$rsShipment["tracking_id"].'\n\n';	
	}
	
	$insertInDB .= 'Shipping Date : '.date('d M Y',strtotime($rsShipment["shipped_date"])).'\n\n';
	
	// for non shipped product(s) information // 
	
	$Info2 = mysql_query("select sum(shipped_products_qty) as qty,products_model,orders_id,tracking_id from ims_orders_shipping where shipped_products_qty = '0' and orders_id='$oId' and tracking_id='' and shipping_status!='4' group by products_model");
	
	if(mysql_num_rows($Info2) >='1')
	{	
		$insertInDB .='And the following remaining product(s) will be shipped very soon.'.'\n\n';
		while($rsInfoShi1p2 = mysql_fetch_array($Info2)){		
	  $insertInDB .='SKU -'.$rsInfoShi1p2['products_model'].'\n\n';
	  }
	}
	// end //
	
	$insertInDB .= 'You can track the progress of the parcel by visiting this link ';
	
	if($rsShipment["courier"]=='UPS')
		$insertInDB .='http://wwwapps.ups.com/WebTracking/track'.'\n\n';
	if($rsShipment["courier"]=='FedEx')
		$insertInDB .='http://www.fedex.com/in/'.'\n\n';
	if($rsShipment["courier"]=='TNT')
		$insertInDB .='http://www.tnt.com/express/en_in/site/home.html'.'\n\n';
	if($rsShipment["courier"]=='DHL')
		$insertInDB .='http://www.dhl.com/en.html'.'\n\n';
	if($rsShipment["courier"]=='Blue Dart')
		$insertInDB .='http://www.bluedart.com/'.'\n\n';
	if($rsShipment["courier"]=='FirstFlight')
		$insertInDB .='http://www.firstflight.net/'.'\n\n';	
	if($rsShipment["courier"]=='INDIA_POST')
		$insertInDB .='http://www.indiapost.gov.in/tracking.aspx/'.'\n\n';	
	if($rsShipment["courier"]=='FedEx_COD')
		$insertInDB .='http://www.fedex.com/in/'.'\n\n';
	if($rsShipment["courier"]=='FirstFlight_COD')
		$insertInDB .='http://www.firstflight.net/'.'\n\n';
	
	
	if($rsShipment["courier"]=='aramex')
		$insertInDB .='http://www.aramex.com//'.'\n\n';
	if($rsShipment["courier"]=='skynet')
		$insertInDB .='http://www.skynetwwe.info//'.'\n\n';
	if($rsShipment["courier"]=='megacitycourier')
		$insertInDB .='http://www.megacitycourier.in//'.'\n\n';
	if($rsShipment["courier"]=='SkyNetDomestic')
		$insertInDB .='http://www.skynetindia.com/'.'\n\n';	
	if($rsShipment["courier"]=='handDelivery')
		$insertInDB .='http://www.sareez.com/account_history.php/'.'\n\n';	
	
	
	if($_POST['cod']!='')
	{
		$insertInDB .= 'You Need to pay : '.$currencies->format($_POST['cod'], true,$_POST['hidcur'],'1').'\n\n';		
	
	}
 	//$insertInDB .= 'Please reply to this email if you have any questions.';
	$insertInDB .= 'You can also track your shipment after 12 hrs.'.'\n\n';			
	$insertInDB .= 'If you need any further information on this shipment feel free to contact us. Happy Shopping !';			
		

		
		
	
			
			// for remote server //
			
		echo $shipping_status;
		die('I am here');
			
		if($shipping_status!='3')
		{
			
			if($notify_customer=='on'){
			mysql_query("insert into " . TABLE_ORDERS_STATUS_HISTORY . " (orders_id, orders_status_id, date_added, customer_notified, comments) values ('" . (int)$orders_id . "', '4', now(), '1', '".$insertInDB."')",$conn_remote);
			$lastInsertIdRs=mysql_fetch_array(mysql_query('select max(orders_status_history_id) as orders_status_history_id from orders_status_history',$conn_remote));	
			$lastInsertId=$lastInsertIdRs['orders_status_history_id'];
			}else{
			mysql_query("insert into " . TABLE_ORDERS_STATUS_HISTORY . " (orders_id, orders_status_id, date_added, customer_notified, comments) values ('" . (int)$orders_id . "', '4', now(), '0', '".$insertInDB."')",$conn_remote);	
			//echo $lastInsertId=mysql_insert_id();
			$lastInsertIdRs=mysql_fetch_array(mysql_query('select max(orders_status_history_id) as orders_status_history_id from orders_status_history',$conn_remote));	
			$lastInsertId=$lastInsertIdRs['orders_status_history_id'];
			}				
	

		}
		//echo $lastInsertId=mysql_insert_id();
		//exit;
	
		$sqlEmail=mysql_fetch_array(mysql_query("select comments from orders_status_history where orders_status_history_id='".$lastInsertId."'",$conn_remote));
		
		$emailed .=$sqlEmail['comments'];

/*echo $email;
exit;*/
		if($notify_customer=='on' && $shipping_status=='2'){
			//tep_mail($check_status['customers_name'], $check_status['customers_email_address'], 'Shipment of items in order '. (int)$orders_id .' by Sareez.com'  , $email, 'Sareez.com', 'support@sareez.com');
						
			//tep_mail($check_status['customers_name'], 'asgar.ali.biswas@gmail.com', 'Shipment of items in order '. (int)$orders_id .' by Sareez.com'  , $email, 'Sareez.com', 'support@sareez.com');
		
		$error = false;	
			
		$CFG['smtp_debug']        = 1;
		$CFG['smtp_server']       = 'ssl://smtp.gmail.com';
		$CFG['smtp_port']         = '465';
		$CFG['smtp_authenticate'] = 'true';
		$CFG['smtp_username']     = 'shipping@sareez.com';
		$CFG['smtp_password']     = '$+shipping716#*';			
			
		
		//$to	= 'asgar.ali.biswas@gmail.com';
		$to	=trim($check_status['customers_email_address']);
		
		$name = 'Sareez';
	  	$email_address ='shipping@sareez.com';
	  	$enquiry = nl2br(tep_db_output($emailed));
			
	  	$subject =  'Shipment of items in order '. (int)$orders_id .' by Sareez.com';
	  	$order_no = (int)$orders_id;  
		
		 class phpmailerAppException extends Exception {
			public function errorMessage() {
			  $errorMsg = '<strong>' . $this->getMessage() . "</strong><br />";
			  return $errorMsg;
			}
		  }
		
		  try {
			$to = $to;
			if(filter_var($to, FILTER_VALIDATE_EMAIL) === FALSE) {
			  throw new phpmailerAppException("Email address " . $to . " is invalid -- aborting!<br />");
			}
		  } catch (phpmailerAppException $e) {
			echo $e->errorMessage();
			return false;
		  }  
		  
		  
		  
		  
		
		  $mail = new PHPMailer();
		/*print_r ($mail);
		exit;*/
	
		  $body = $enquiry;
		  
		  $test_type='smtp';
		  
		  if($test_type=='smtp')
		  {
			$mail->IsSMTP();  // telling the class to use SMTP
			$mail->SMTPDebug  = $_POST['smtp_debug'];
			$mail->SMTPAuth   = $_POST['smtp_authenticate'];     // enable SMTP authentication
			$mail->Port       = $_POST['smtp_port'];             // set the SMTP port
			$mail->Host       = $_POST['smtp_server'];           // SMTP server
			$mail->Username   = $_POST['authenticate_username']; // SMTP account username
			$mail->Password   = $_POST['authenticate_password']; // SMTP account password	  	
		  }
		  
		  
			$mail->AddReplyTo($email_address,$name);
			$mail->From       = $email_address;
			$mail->FromName   = $name;	
			
			$name=$check_status['customers_name'];
			$mail->AddAddress($to,$name,$subject);  
			//$mail->AddBCC('asgar_biswas@yahoo.co.in');
			//$mail->AddCC('amazon@sareez.com');			
			$mail->Subject  = $subject;
			$mail->To  = $name;
			$mail->WordWrap   = 80;
			$mail->MsgHTML($body);
			
		 /* $mail->AddAttachment("images/sareez-logo.jpg", "sareez-logo.jpg");  // optional name
		  $mail->AddAttachment("images/sareez-logo.jpg", "sareez-logo.jpg");  // optional name	*/
		  
		  
		  try {
			if ( !$mail->Send() ) {
			  $error = "Unable to send to: " . $to . "<br />";
			  throw new phpmailerAppException($error);
			} else {
			  echo 'Message has been sent using ' . strtoupper($test_type) . "<br /><br />";
			}
		  }
		  
		  
		  catch (phpmailerAppException $e) {
			$errorMsg[] = $e->errorMessage();
		  }  
		
			
		}	
			
				
	// END //

		
	}

	//exit();
	
	SendURL('orders_shipping.php?selShippingStatus=1&mode=open&orderId='.$orders_id);
	exit();
}
// end //

?>

<!-- THE PAGINATION IS DOWNLOADED FROM http://www.phpeasystep.com/phptu/29.html-->
<?php 
####################

	//strtotime(date('Y-m-d')) < strtotime(date('Y-m-d',strtotime(date('Y-m-d'))-(60*60*24*2)))
	


	/*
		Place code to connect to your DB here.
	*/
	//include('config.php');	// include your code to connect to DB.

	$tbl_name="orders o,ims_orders_shipping s";	//your table name
	// How many adjacent pages should be shown on each side?
	$adjacents = 7;
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	$query = "SELECT COUNT(distinct(o.orders_id)) as num FROM $tbl_name  where 1=1 ";
		
	if($_POST['orderId']!='')
		{
			$query .= " and s.orders_id='".$_POST['orderId']."'";
		}
		if($_POST['shippingId']!='')
		{
			$query .= " and s.orders_id in (select orders_id from ims_orders_shipping where shipping_id='".$_POST['shippingId']."')";
		}
						
		if($_REQUEST['selShippingStatus']!='')
		{
			$query .=" AND s.shipping_status='".$_REQUEST['selShippingStatus']."'";
	
		}
		
		if($_POST['dateTo']!='' and $_POST['dateFrom']!='')
		{
		$query .= " and s.orders_id in (select orders_id from ims_orders_shipping where dos >='".$_POST['dateTo']." "."00:00:00"."'
AND dos <='".$_POST['dateFrom']." "."23:59:59"."'  group by orders_id)";
		}
		if($_POST['dispatchDate']!='')
		{
		$query .= " and  s.dod >='".$_POST['dispatchDate']." "."00:00:00"."'
AND s.dod <='".$_POST['dispatchDate']." "."23:59:59"."'";
		}
			
	
		//$query .=" and o.orders_id=s.orders_id group by o.orders_id ";
		//$query .=" and o.orders_id=s.orders_id ";
		//asgar
		$query .=" and o.is_giftorder_flag=0 and o.orders_id=s.orders_id ";
		
	
	//echo $query."<br />";
	
	$total_pages = mysql_fetch_array(mysql_query($query));
	
	$total_pages = $total_pages[num];
	
	/* the following code is for records limit for per page*/
	$page_name="orders_shipping.php"; //  If you use this code with a different page ( or file ) name then change this 

@$column_name=$_GET['column_name']; // Read the column name from query string. 


@$limit=$_GET['limit']; // Read the limit value from query string. 



switch($limit)
{
case 5:
$select5="selected";
$select10="";
$select25="";
$select50="";
break;

case 10:
$select10="selected";
$select25="";
$select50="";
$select5="";
break;

case 25:
$select25="selected";
$select50="";
$select10="";
$select5="";
break;

case 50:
$select50="selected";
$select25="";
$select10="";
$select5="";
break;


default:
$select10="selected";
$select50="";
$select25="";
$select10="";
$select5="";
break;

}

$start=$_GET['start'];								// To take care global variable if OFF
if(!($start > 0)) {                         // This variable is set to zero for the first page
$start = 0;
}
///// End of drop down to select number of records per page ///////
$eu = ($start - 0); 
if(!$limit > 0 ){ // if limit value is not available then let us use a default value
//$limit = 5;    // No of records to be shown per page by default.
	if($_REQUEST['mode']=='Search' && $_REQUEST['selShippingStatus']!='')
	{
	$limit = 15;
	}else if($_REQUEST['mode']=='Search' && $_REQUEST['selShippingStatus']==''){
	$limit = 15;
	}else{
	$limit = 15;    // No of records to be shown per page by default.
	}
}                             
$this1 = $eu + $limit; 
$back = $eu - $limit; 
$next = $eu + $limit; 

/* end of page per record*/	
	
	
	/* Setup vars for query. */
	$targetpage = "orders_shipping.php"; 	//your file name  (the name of this file)
	//$limit = 4; 								//how many items to show per page
	$page = $_GET['page'];
	if($page) 
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0
	
	/* Get data. */
if($_GET['mode']=='Search')
{
	
	$sql = "SELECT * FROM $tbl_name where 1=1 ";
		if($_POST['orderId']!='')
		{
		$sql .= " and s.orders_id='".$_POST['orderId']."'";
		}
		if($_POST['shippingId']!='')
		{
		$sql .= " and s.orders_id in (select orders_id from ims_orders_shipping where shipping_id='".$_POST['shippingId']."')";
		}
						
		if($_REQUEST['selShippingStatus']!='')
		{
			$sql .=" AND s.shipping_status='".$_REQUEST['selShippingStatus']."'";
	
		}
		
		if($_POST['dateTo']!='' and $_POST['dateFrom']!='')
		{
		$sql .= " and s.orders_id in (select orders_id from ims_orders_shipping where dos >='".$_POST['dateTo']." "."00:00:00"."'
AND dos <='".$_POST['dateFrom']." "."23:59:59"."'  group by orders_id)";
		}
		if($_POST['dispatchDate']!='')
		{
		$sql .= " and  s.dod >='".$_POST['dispatchDate']." "."00:00:00"."'
AND s.dod <='".$_POST['dispatchDate']." "."23:59:59"."'";
		}		
		
	//$sql .="  and o.orders_id=s.orders_id group by o.orders_id order by s.orders_id desc LIMIT $start, $limit";
	//asgar
	$sql .="  and o.is_giftorder_flag=0 and o.orders_id=s.orders_id group by o.orders_id order by s.orders_id desc LIMIT $start, $limit";
}else{
	$sql = "SELECT * FROM $tbl_name where o.orders_id=s.orders_id ";
	if($_REQUEST['selShippingStatus']!='')
	{
		$sql .= " and o.is_giftorder_flag=0 AND s.shipping_status='".$_REQUEST['selShippingStatus']."' group by s.orders_id order by s.dod desc LIMIT $start, $limit";
	}
	if($_REQUEST['selShippingStatus']=='')
	{
		$sql .= " and o.is_giftorder_flag=0 group by s.orders_id order by s.dod desc LIMIT $start, $limit";
	}
	
	
		
}

	//echo "<br />".$sql;
	$result = mysql_query($sql);
	
	/* Setup page vars for display. */
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	
	/* 
		Now we apply our rules and draw the pagination object. 
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\">";
		//previous button
		if ($page > 1) 
			$pagination.= "<a href=\"$targetpage?page=$prev&limit=$limit\">« previous</a>";
		else
			$pagination.= "<span class=\"disabled\">« previous</span>";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage?page=$counter&limit=$limit&selShippingStatus=".$_REQUEST['selShippingStatus']."\">$counter</a>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter&limit=$limit&selShippingStatus=".$_REQUEST['selShippingStatus']."\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1&limit=$limit&selShippingStatus=".$_REQUEST['selShippingStatus']."\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage&limit=$limit&selShippingStatus=".$_REQUEST['selShippingStatus']."\">$lastpage</a>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a href=\"$targetpage?page=1&limit=$limit&selShippingStatus=".$_REQUEST['selShippingStatus']."\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2&limit=$limit&selShippingStatus=".$_REQUEST['selShippingStatus']."\">2</a>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter&limit=$limit&selShippingStatus=".$_REQUEST['selShippingStatus']."\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1&limit=$limit&selShippingStatus=".$_REQUEST['selShippingStatus']."\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage&limit=$limit&selShippingStatus=".$_REQUEST['selShippingStatus']."\">$lastpage</a>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter&selShippingStatus=".$_REQUEST['selShippingStatus']."\">$counter</a>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<a href=\"$targetpage?page=$next&selShippingStatus=".$_REQUEST['selShippingStatus']."\">next »</a>";
		else
			$pagination.= "<span class=\"disabled\">next »</span>";
		$pagination.= "</div>\n";		
	}
	
	///////////////////////////////////////////// end of pagination code //////////////
?>
<!-- THE PAGINATION END-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Order Shipping Console</title>


<link rel="stylesheet" href="css/main.css" type="text/css">
<link rel="stylesheet" href="css/format.css" type="text/css">
<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" type="text/css" href="includes/functions/paginate.css">

<!--FOR COD BOX OPEN-->
<script>
function codd(value)
{

	if(value=='FedEx_COD' || value=='FirstFlight_COD')
	{
	document.getElementById('cod_value').style.display='block';	
	}else{
	document.getElementById('cod_value').style.display='none';	
	}


}

</script>
<!-- END OF COD BOX OPEN-->

<script type="text/javascript" src="js/jquery.min.js"> </script>
<script type="text/javascript" src="js/javascript.js"> </script>
<!--<script type="text/javascript" src="http://jqueryjs.googlecode.com/files/jquery-1.3.2.js"></script>-->
<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$(".trigger").click(function(){
		$(".panel").toggle("fast");
		$(this).toggleClass("active");
		return false;
	});
});

$(document).ready(function(){
	$(".trigger2").click(function(){
		$(".pane2").toggle("fast");
		$(this).toggleClass("active");
		return false;
	});
});

</script>	
<!--For Date Picker-->
    <link rel="stylesheet" href="includes/datepicker/jquery-ui.css" />
    <script src="includes/datepicker/jquery-1.8.3.js"></script>
    <script src="includes/datepicker/jquery-ui.js"></script>
    
    <script>
    $(function() {
        $( "#datepicker" ).datepicker();
    });
	
	<!--shipping validation-->
	function validAssign(sId)
	{
		//alert(sId);
		if(document.getElementById('selCourier'+sId).value=='')
		{
			alert('Courier should not be blank.');
			document.getElementById('selCourier'+sId).focus();
			return false;
		}
		
		if(document.getElementById('trackId'+sId).value=='')
		{
			alert('Tracking ID should not be blank.');
			document.getElementById('trackId'+sId).focus();
			return false;
		}
		
		if(document.getElementById('selShippingStatus'+sId).value=='')
		{
			alert('Shipping Status should not be blank.');
			document.getElementById('selShippingStatus'+sId).focus();
			return false;
		}	
				
	return true;
	}
	
	<!--end -->
</script>

	<!--For popup comments display-->
<script type="text/javascript" language="JavaScript">
var cX = 0; var cY = 0; var rX = 0; var rY = 0;
function UpdateCursorPosition(e){ cX = e.pageX; cY = e.pageY;}
function UpdateCursorPositionDocAll(e){ cX = event.clientX; cY = event.clientY;}
if(document.all) { document.onmousemove = UpdateCursorPositionDocAll; }
else { document.onmousemove = UpdateCursorPosition; }
function AssignPosition(d) {
//alert(d);
if(self.pageYOffset) {
rX = self.pageXOffset;
rY = self.pageYOffset;
}
else if(document.documentElement && document.documentElement.scrollTop) {
rX = document.documentElement.scrollLeft;
rY = document.documentElement.scrollTop;
}
else if(document.body) {
rX = document.body.scrollLeft;
rY = document.body.scrollTop;
}
if(document.all) {
cX += rX;
cY += rY;
}
d.style.left = (cX+10) + "px";
d.style.top = (cY+10) + "px";
}
function HideText(d) {
if(d.length < 1) { return; }
document.getElementById(d).style.display = "none";
}
function CloseOrderInfo(d) {
if(d.length < 1) { return; }
document.getElementById(d).style.display = "none";
}

function ShowText(d) {
//alert(d);
if(d.length < 1) { return; }
var dd = document.getElementById(d);
AssignPosition(dd);
dd.style.display = "block";
}
function ReverseContentDisplay(d) {
if(d.length < 1) { return; }
var dd = document.getElementById(d);
AssignPosition(dd);
if(dd.style.display == "none") { dd.style.display = "block"; }
else { dd.style.display = "none"; }
}
//-->
</script>
	
	<!--end -->



<style>
div.pagination {
	padding: 3px;
	margin: 3px;
}

div.pagination a {
	padding: 2px 5px 2px 5px;
	margin: 2px;
	border: 1px solid #AAAADD;
	
	text-decoration: none; /* no underline */
	color: #000099;
}
div.pagination a:hover, div.pagination a:active {
	border: 1px solid #000099;

	color: #000;
}
div.pagination span.current {
	padding: 2px 5px 2px 5px;
	margin: 2px;
		border: 1px solid #000099;
		
		font-weight: bold;
		background-color: #000099;
		color: #FFF;
	}
	div.pagination span.disabled {
		padding: 2px 5px 2px 5px;
		margin: 2px;
		border: 1px solid #EEE;
	
		color: #DDD;
	}
	
	<!-- for word wrap-->
	p.test
{
width:11em; 
border:1px solid #000000;
word-wrap:break-word;
}
	
.smallText_3 {font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#666666; padding-left:5px; border-left:1px solid #e7e5e6; border-bottom:1px solid #e7e5e6; padding-bottom:5px; padding-top:5px  }
</style>




<script language="javascript" src="includes/general.js"></script>
<!--THIS SCRIPT FOR COPY TO CLIPBOARD-->
<script type="text/javascript">
		window.addEvent("load",function() {
			
			setTimeout(function() {
				//set path
				ZeroClipboard.setMoviePath('http://www.sareez.com/admin/flash/ZeroClipboard.swf');
				//create client
				var clip = new ZeroClipboard.Client();
				//event
				clip.addEventListener('mousedown',function() {
					clip.setText(document.getElementById('box-content').value);
				});
				clip.addEventListener('complete',function(client,text) {
					alert('copied: ' + text);
				});
				//glue it to the button
				clip.glue('copy');
			}, 2000);
			
		});
		
	</script>
<script type="text/javascript">
		// Simple Set Clipboard System
// Author: Joseph Huckaby

var ZeroClipboard = {
	
	version: "1.0.7",
	clients: {}, // registered upload clients on page, indexed by id
	//moviePath: 'ZeroClipboard.swf', // URL to movie
	moviePath: 'http://www.sareez.com/admin/flash/ZeroClipboard.swf', // URL to movie
	nextId: 1, // ID of next movie
	
	$: function(thingy) {
		// simple DOM lookup utility function
		if (typeof(thingy) == 'string') thingy = document.getElementById(thingy);
		if (!thingy.addClass) {
			// extend element with a few useful methods
			thingy.hide = function() { this.style.display = 'none'; };
			thingy.show = function() { this.style.display = ''; };
			thingy.addClass = function(name) { this.removeClass(name); this.className += ' ' + name; };
			thingy.removeClass = function(name) {
				var classes = this.className.split(/\s+/);
				var idx = -1;
				for (var k = 0; k < classes.length; k++) {
					if (classes[k] == name) { idx = k; k = classes.length; }
				}
				if (idx > -1) {
					classes.splice( idx, 1 );
					this.className = classes.join(' ');
				}
				return this;
			};
			thingy.hasClass = function(name) {
				return !!this.className.match( new RegExp("\\s*" + name + "\\s*") );
			};
		}
		return thingy;
	},
	
	setMoviePath: function(path) {
		// set path to ZeroClipboard.swf
		this.moviePath = path;
	},
	
	dispatch: function(id, eventName, args) {
		// receive event from flash movie, send to client		
		var client = this.clients[id];
		if (client) {
			client.receiveEvent(eventName, args);
		}
	},
	
	register: function(id, client) {
		// register new client to receive events
		this.clients[id] = client;
	},
	
	getDOMObjectPosition: function(obj, stopObj) {
		// get absolute coordinates for dom element
		var info = {
			left: 0, 
			top: 0, 
			width: obj.width ? obj.width : obj.offsetWidth, 
			height: obj.height ? obj.height : obj.offsetHeight
		};

		while (obj && (obj != stopObj)) {
			info.left += obj.offsetLeft;
			info.top += obj.offsetTop;
			obj = obj.offsetParent;
		}

		return info;
	},
	
	Client: function(elem) {
		// constructor for new simple upload client
		this.handlers = {};
		
		// unique ID
		this.id = ZeroClipboard.nextId++;
		this.movieId = 'ZeroClipboardMovie_' + this.id;
		
		// register client with singleton to receive flash events
		ZeroClipboard.register(this.id, this);
		
		// create movie
		if (elem) this.glue(elem);
	}
};

ZeroClipboard.Client.prototype = {
	
	id: 0, // unique ID for us
	ready: false, // whether movie is ready to receive events or not
	movie: null, // reference to movie object
	clipText: '', // text to copy to clipboard
	handCursorEnabled: true, // whether to show hand cursor, or default pointer cursor
	cssEffects: true, // enable CSS mouse effects on dom container
	handlers: null, // user event handlers
	
	glue: function(elem, appendElem, stylesToAdd) {
		// glue to DOM element
		// elem can be ID or actual DOM element object
		this.domElement = ZeroClipboard.$(elem);
		
		// float just above object, or zIndex 99 if dom element isn't set
		var zIndex = 99;
		if (this.domElement.style.zIndex) {
			zIndex = parseInt(this.domElement.style.zIndex, 10) + 1;
		}
		
		if (typeof(appendElem) == 'string') {
			appendElem = ZeroClipboard.$(appendElem);
		}
		else if (typeof(appendElem) == 'undefined') {
			appendElem = document.getElementsByTagName('body')[0];
		}
		
		// find X/Y position of domElement
		var box = ZeroClipboard.getDOMObjectPosition(this.domElement, appendElem);
		
		// create floating DIV above element
		this.div = document.createElement('div');
		var style = this.div.style;
		style.position = 'absolute';
		style.left = '' + box.left + 'px';
		style.top = '' + box.top + 'px';
		style.width = '' + box.width + 'px';
		style.height = '' + box.height + 'px';
		style.zIndex = zIndex;
		
		if (typeof(stylesToAdd) == 'object') {
			for (addedStyle in stylesToAdd) {
				style[addedStyle] = stylesToAdd[addedStyle];
			}
		}
		
		// style.backgroundColor = '#f00'; // debug
		
		appendElem.appendChild(this.div);
		
		this.div.innerHTML = this.getHTML( box.width, box.height );
	},
	
	getHTML: function(width, height) {
		// return HTML for movie
		var html = '';
		var flashvars = 'id=' + this.id + 
			'&width=' + width + 
			'&height=' + height;
			
		if (navigator.userAgent.match(/MSIE/)) {
			// IE gets an OBJECT tag
			var protocol = location.href.match(/^https/i) ? 'https://' : 'http://';
			html += '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="'+protocol+'download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="'+width+'" height="'+height+'" id="'+this.movieId+'" align="middle"><param name="allowScriptAccess" value="always" /><param name="allowFullScreen" value="false" /><param name="movie" value="'+ZeroClipboard.moviePath+'" /><param name="loop" value="false" /><param name="menu" value="false" /><param name="quality" value="best" /><param name="bgcolor" value="#ffffff" /><param name="flashvars" value="'+flashvars+'"/><param name="wmode" value="transparent"/></object>';
		}
		else {
			// all other browsers get an EMBED tag
			html += '<embed id="'+this.movieId+'" src="'+ZeroClipboard.moviePath+'" loop="false" menu="false" quality="best" bgcolor="#ffffff" width="'+width+'" height="'+height+'" name="'+this.movieId+'" align="middle" allowScriptAccess="always" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" flashvars="'+flashvars+'" wmode="transparent" />';
		}
		return html;
	},
	
	hide: function() {
		// temporarily hide floater offscreen
		if (this.div) {
			this.div.style.left = '-2000px';
		}
	},
	
	show: function() {
		// show ourselves after a call to hide()
		this.reposition();
	},
	
	destroy: function() {
		// destroy control and floater
		if (this.domElement && this.div) {
			this.hide();
			this.div.innerHTML = '';
			
			var body = document.getElementsByTagName('body')[0];
			try { body.removeChild( this.div ); } catch(e) {;}
			
			this.domElement = null;
			this.div = null;
		}
	},
	
	reposition: function(elem) {
		// reposition our floating div, optionally to new container
		// warning: container CANNOT change size, only position
		if (elem) {
			this.domElement = ZeroClipboard.$(elem);
			if (!this.domElement) this.hide();
		}
		
		if (this.domElement && this.div) {
			var box = ZeroClipboard.getDOMObjectPosition(this.domElement);
			var style = this.div.style;
			style.left = '' + box.left + 'px';
			style.top = '' + box.top + 'px';
		}
	},
	
	setText: function(newText) {
		// set text to be copied to clipboard
		this.clipText = newText;
		if (this.ready) this.movie.setText(newText);
	},
	
	addEventListener: function(eventName, func) {
		// add user event listener for event
		// event types: load, queueStart, fileStart, fileComplete, queueComplete, progress, error, cancel
		eventName = eventName.toString().toLowerCase().replace(/^on/, '');
		if (!this.handlers[eventName]) this.handlers[eventName] = [];
		this.handlers[eventName].push(func);
	},
	
	setHandCursor: function(enabled) {
		// enable hand cursor (true), or default arrow cursor (false)
		this.handCursorEnabled = enabled;
		if (this.ready) this.movie.setHandCursor(enabled);
	},
	
	setCSSEffects: function(enabled) {
		// enable or disable CSS effects on DOM container
		this.cssEffects = !!enabled;
	},
	
	receiveEvent: function(eventName, args) {
		// receive event from flash
		eventName = eventName.toString().toLowerCase().replace(/^on/, '');
				
		// special behavior for certain events
		switch (eventName) {
			case 'load':
				// movie claims it is ready, but in IE this isn't always the case...
				// bug fix: Cannot extend EMBED DOM elements in Firefox, must use traditional function
				this.movie = document.getElementById(this.movieId);
				if (!this.movie) {
					var self = this;
					setTimeout( function() { self.receiveEvent('load', null); }, 1 );
					return;
				}
				
				// firefox on pc needs a "kick" in order to set these in certain cases
				if (!this.ready && navigator.userAgent.match(/Firefox/) && navigator.userAgent.match(/Windows/)) {
					var self = this;
					setTimeout( function() { self.receiveEvent('load', null); }, 100 );
					this.ready = true;
					return;
				}
				
				this.ready = true;
				this.movie.setText( this.clipText );
				this.movie.setHandCursor( this.handCursorEnabled );
				break;
			
			case 'mouseover':
				if (this.domElement && this.cssEffects) {
					this.domElement.addClass('hover');
					if (this.recoverActive) this.domElement.addClass('active');
				}
				break;
			
			case 'mouseout':
				if (this.domElement && this.cssEffects) {
					this.recoverActive = false;
					if (this.domElement.hasClass('active')) {
						this.domElement.removeClass('active');
						this.recoverActive = true;
					}
					this.domElement.removeClass('hover');
				}
				break;
			
			case 'mousedown':
				if (this.domElement && this.cssEffects) {
					this.domElement.addClass('active');
				}
				break;
			
			case 'mouseup':
				if (this.domElement && this.cssEffects) {
					this.domElement.removeClass('active');
					this.recoverActive = false;
				}
				break;
		} // switch eventName
		
		if (this.handlers[eventName]) {
			for (var idx = 0, len = this.handlers[eventName].length; idx < len; idx++) {
				var func = this.handlers[eventName][idx];
			
				if (typeof(func) == 'function') {
					// actual function reference
					func(this, args);
				}
				else if ((typeof(func) == 'object') && (func.length == 2)) {
					// PHP style object + method, i.e. [myObject, 'myMethod']
					func[0][ func[1] ](this, args);
				}
				else if (typeof(func) == 'string') {
					// name of function
					window[func](this, args);
				}
			} // foreach event handler defined
		} // user defined handler for event
	}
	
};

</script>
	
	
<!-- END FOR COPY TO CLIPBOARD-->
<script type="text/javascript">
var xmlHttp;
var type;
function showCat(arg)
{
//alert(arg);
	document.getElementById("cat_text").value=arg;
}
function Showtable(OrdId,status)
{
/*alert(OrdId);
alert(status);
var smtp_debug=document.getElementById('smtp_debug').value;
var smtp_server=document.getElementById('smtp_server').value;
var smtp_port=document.getElementById('smtp_port').value;
var smtp_authenticate=document.getElementById('smtp_authenticate').value;
var authenticate_username=document.getElementById('authenticate_username').value;
var authenticate_password=document.getElementById(authenticate_password'').value;
*/



document.getElementById("loader"+OrdId).style.display="block";
type=2;
xmlHttp=GetXmlHttpObject()

	if (xmlHttp==null)
	{
		 alert ("Browser does not support HTTP Request")
		 return
	} 
	
	//var url="getOrderShipping.php?orderId="+OrdId+"&shippingStatus="+status+"&smtp_debug="+smtp_debug+"&smtp_server="+smtp_server+"&smtp_port="+smtp_port+"&smtp_authenticate="+smtp_authenticate+"&authenticate_username="+authenticate_username+"&authenticate_password="+authenticate_password;
	var url="getOrderShipping.php?orderId="+OrdId+"&shippingStatus="+status;
	
	//url=url+"&value="+strBillNo

	url=url+"&sid="+Math.random()
	 //alert(url);
	xmlHttp.onreadystatechange=stateChanged
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
}
function stateChanged()
{
	if(type==2)
	{
	//alert(xmlHttp.readyState);	
	if (xmlHttp.readyState=4)
		{
					
			var putval=document.getElementById("cat_text").value;
			//alert(putval);
			document.getElementById("showP"+putval).style.display="block";
			
			//alert(xmlHttp.responseText);
			document.getElementById("showP"+putval).innerHTML=xmlHttp.responseText;		
			document.getElementById("loader"+putval).style.display="none";	
			putval='';
		}
	}
	
	
}


function GetXmlHttpObject()
{ 
	var objXMLHttp=null
	if (window.XMLHttpRequest)
	{
		objXMLHttp=new XMLHttpRequest()
	}
	else if (window.ActiveXObject)
	{
	objXMLHttp=new ActiveXObject("Microsoft.XMLHTTP")
	}
	return objXMLHttp
}


//order_update_show

function CloseOrderInfo(d) {
//alert(d);
if(d.length < 1) { return; }
document.getElementById(d).style.display = "none";
}
</script>
<style type="text/css">
h2{
	    margin:auto;
		font-family:Tahoma, Geneva, sans-serif;
		font-weight:bold;
		color:#945d34;
		font-size:18px;}
		
.Details_table{
	   margin-top:20px;
	   border:1px solid #e1e1e1;
	   padding-bottom:10px;
	   }
	   
.id_text{
	  font-family:"Tahoma", Geneva, sans-serif;
	  font-size:12px;
	  color:#666;
	  font-weight:bold;
	  padding-top:10px;
	  padding-bottom:5px;
	  padding-left:15px;
	  /*border:1px solid #000000;*/}
	  
.search_text{
	  font-family:"Tahoma", Geneva, sans-serif;
	  font-size:12px;
	  color:#5a5959;
	  padding-top:10px;
	  padding-bottom:5px;
	  padding-left:15px;
	  /*border:1px solid #000000;*/}	
	  	  	
</style>

<style type="text/css">
.ds_box {
	background-color: #FFF;
	border: 1px solid #000;
	position: absolute;
	z-index: 32767;
}

.ds_tbl {
	background-color: #FFF;
}

.ds_head {
	background-color: #333;
	color: #FFF;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: bold;
	text-align: center;
	letter-spacing: 2px;
}

.ds_subhead {
	background-color: #CCC;
	color: #000;
	font-size: 9px;
	font-weight: bold;
	text-align: center;
	font-family: Arial, Helvetica, sans-serif;
	width: 22px;
}

.ds_cell {
	background-color: #EEE;
	color: #000;
	font-size: 9px;
	text-align: center;
	font-family: Arial, Helvetica, sans-serif;
	padding: 2px;
	cursor: pointer;
}

.ds_cell:hover {
	/*background-color: #F3F3F3;*/
	background-color:#333333;
	color:#FFFFFF
	
} /* This hover code won't work for IE */

.id_text1 {	  font-family:"Tahoma", Geneva, sans-serif;
	  font-size:12px;
	  color:#666;
	  font-weight:bold;
	  padding-top:10px;
	  padding-bottom:5px;
	  padding-left:15px;
}
</style>

</head>

<body>
 
 
 
	
	
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">

<tr>
   <td align="center" valign="top" style="padding-bottom:10px;">
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">

<tr>
     <td align="center" valign="top">
<?php include('includes/header_catalog.php'); ?>
<input type="hidden" id="acees_user" value="<?php echo $admin['username']; ?>" />
    </td>
</tr>
<!---->
</table>   
   
   </td>
</tr>

<!-- FOR CALENDER -->
 <tr>
    <td colspan="9"> 
	<table class="ds_box" cellpadding="0" cellspacing="0" id="ds_conclass" style="display: none;">
    	<tr>
        	<td id="ds_calclass"></td>
        </tr>
    </table>
    <!--FOR CALENDER -->
    <script type="text/javascript">
// <!-- <![CDATA[

// Project: Dynamic Date Selector (DtTvB) - 2006-03-16
// Script featured on JavaScript Kit- http://www.javascriptkit.com
// Code begin...
// Set the initial date.
var ds_i_date = new Date();
ds_c_month = ds_i_date.getMonth() + 1;
ds_c_year = ds_i_date.getFullYear();

// Get Element By Id
function ds_getel(id) {
	return document.getElementById(id);
}

// Get the left and the top of the element.
function ds_getleft(el) {
	var tmp = el.offsetLeft;
	el = el.offsetParent
	while(el) {
		tmp += el.offsetLeft;
		el = el.offsetParent;
	}
	return tmp;
}
function ds_gettop(el) {
	var tmp = el.offsetTop;
	el = el.offsetParent
	while(el) {
		tmp += el.offsetTop;
		el = el.offsetParent;
	}
	return tmp;
}

// Output Element
var ds_oe = ds_getel('ds_calclass');
// Container
var ds_ce = ds_getel('ds_conclass');

// Output Buffering
var ds_ob = ''; 
function ds_ob_clean() {
	ds_ob = '';
}
function ds_ob_flush() {
	ds_oe.innerHTML = ds_ob;
	ds_ob_clean();
}
function ds_echo(t) {
	ds_ob += t;
}

var ds_element; // Text Element...

var ds_monthnames = [
'January', 'February', 'March', 'April', 'May', 'June',
'July', 'August', 'September', 'October', 'November', 'December'
]; // You can translate it for your language.

var ds_daynames = [
'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'
]; // You can translate it for your language.

// Calendar template
function ds_template_main_above(t) {
	return '<table cellpadding="3" cellspacing="1" class="ds_tbl">'
	     + '<tr>'
		 + '<td class="ds_head" style="cursor: pointer" onclick="ds_py();"><<</td>'
		 + '<td class="ds_head" style="cursor: pointer" onclick="ds_pm();"><</td>'
		 + '<td class="ds_head" style="cursor: pointer" onclick="ds_hi();" colspan="3">[Close]</td>'
		 + '<td class="ds_head" style="cursor: pointer" onclick="ds_nm();">></td>'
		 + '<td class="ds_head" style="cursor: pointer" onclick="ds_ny();">>></td>'
		 + '</tr>'
	     + '<tr>'
		 + '<td colspan="7" class="ds_head">' + t + '</td>'
		 + '</tr>'
		 + '<tr>';
}

function ds_template_day_row(t) {
	return '<td class="ds_subhead">' + t + '</td>';
	// Define width in CSS, XHTML 1.0 Strict doesn't have width property for it.
}

function ds_template_new_week() {
	return '</tr><tr>';
}

function ds_template_blank_cell(colspan) {
	return '<td colspan="' + colspan + '"></td>'
}

function ds_template_day(d, m, y) {
	return '<td class="ds_cell" onclick="ds_onclick(' + d + ',' + m + ',' + y + ')">' + d + '</td>';
	// Define width the day row.
}

function ds_template_main_below() {
	return '</tr>'
	     + '</table>';
}

// This one draws calendar...
function ds_draw_calendar(m, y) {
	// First clean the output buffer.
	ds_ob_clean();
	// Here we go, do the header
	ds_echo (ds_template_main_above(ds_monthnames[m - 1] + ' ' + y));
	for (i = 0; i < 7; i ++) {
		ds_echo (ds_template_day_row(ds_daynames[i]));
	}
	// Make a date object.
	var ds_dc_date = new Date();
	ds_dc_date.setMonth(m - 1);
	ds_dc_date.setFullYear(y);
	ds_dc_date.setDate(1);
	if (m == 1 || m == 3 || m == 5 || m == 7 || m == 8 || m == 10 || m == 12) {
		days = 31;
	} else if (m == 4 || m == 6 || m == 9 || m == 11) {
		days = 30;
	} else {
		days = (y % 4 == 0) ? 29 : 28;
	}
	var first_day = ds_dc_date.getDay();
	var first_loop = 1;
	// Start the first week
	ds_echo (ds_template_new_week());
	// If sunday is not the first day of the month, make a blank cell...
	if (first_day != 0) {
		ds_echo (ds_template_blank_cell(first_day));
	}
	var j = first_day;
	for (i = 0; i < days; i ++) {
		// Today is sunday, make a new week.
		// If this sunday is the first day of the month,
		// we've made a new row for you already.
		if (j == 0 && !first_loop) {
			// New week!!
			ds_echo (ds_template_new_week());
		}
		// Make a row of that day!
		ds_echo (ds_template_day(i + 1, m, y));
		// This is not first loop anymore...
		first_loop = 0;
		// What is the next day?
		j ++;
		j %= 7;
	}
	// Do the footer
	ds_echo (ds_template_main_below());
	// And let's display..
	ds_ob_flush();
	// Scroll it into view.
	ds_ce.scrollIntoView();
}

// A function to show the calendar.
// When user click on the date, it will set the content of t.
function ds_sh(t) {
//alert(t)
	// Set the element to set...
	ds_element = t;
	// Make a new date, and set the current month and year.
	var ds_sh_date = new Date();
	ds_c_month = ds_sh_date.getMonth() + 1;
	ds_c_year = ds_sh_date.getFullYear();
	// Draw the calendar
	ds_draw_calendar(ds_c_month, ds_c_year);
	// To change the position properly, we must show it first.
	ds_ce.style.display = '';
	// Move the calendar container!
	the_left = ds_getleft(t);
	the_top = ds_gettop(t) + t.offsetHeight;
	ds_ce.style.left = the_left + 'px';
	ds_ce.style.top = the_top + 'px';
	// Scroll it into view.
	ds_ce.scrollIntoView();
}

// Hide the calendar.
function ds_hi() {
	ds_ce.style.display = 'none';
}

// Moves to the next month...
function ds_nm() {
	// Increase the current month.
	ds_c_month ++;
	// We have passed December, let's go to the next year.
	// Increase the current year, and set the current month to January.
	if (ds_c_month > 12) {
		ds_c_month = 1; 
		ds_c_year++;
	}
	// Redraw the calendar.
	ds_draw_calendar(ds_c_month, ds_c_year);
}

// Moves to the previous month...
function ds_pm() {
	ds_c_month = ds_c_month - 1; // Can't use dash-dash here, it will make the page invalid.
	// We have passed January, let's go back to the previous year.
	// Decrease the current year, and set the current month to December.
	if (ds_c_month < 1) {
		ds_c_month = 12; 
		ds_c_year = ds_c_year - 1; // Can't use dash-dash here, it will make the page invalid.
	}
	// Redraw the calendar.
	ds_draw_calendar(ds_c_month, ds_c_year);
}

// Moves to the next year...
function ds_ny() {
	// Increase the current year.
	ds_c_year++;
	// Redraw the calendar.
	ds_draw_calendar(ds_c_month, ds_c_year);
}

// Moves to the previous year...
function ds_py() {
	// Decrease the current year.
	ds_c_year = ds_c_year - 1; // Can't use dash-dash here, it will make the page invalid.
	// Redraw the calendar.
	ds_draw_calendar(ds_c_month, ds_c_year);
}

// Format the date to output.
function ds_format_date(d, m, y) {
	// 2 digits month.
	m2 = '00' + m;
	m2 = m2.substr(m2.length - 2);
	// 2 digits day.
	d2 = '00' + d;
	d2 = d2.substr(d2.length - 2);
	// YYYY-MM-DD
	return y + '-' + m2 + '-' + d2;
}

// When the user clicks the day.
function ds_onclick(d, m, y) {
	// Hide the calendar.
	ds_hi();
	// Set the value of it, if we can.
	if (typeof(ds_element.value) != 'undefined') {
		ds_element.value = ds_format_date(d, m, y);
	// Maybe we want to set the HTML in it.
	} else if (typeof(ds_element.innerHTML) != 'undefined') {
		ds_element.innerHTML = ds_format_date(d, m, y);
	// I don't know how should we display it, just alert it to user.
	} else {
		alert (ds_format_date(d, m, y));
	}
}

// And here is the end.

// ]]> -->
</script>
	<!--END OF CALENDER SCRIPT--></td>
  </tr>

<!-- END FOR CALENDER-->

<tr>
<td align="center" valign="top">
<h2>Order Shipping</h2>
</td>
</tr>

   <tr>
    <td align="center" valign="top">
	<!--search table-->
	<form name="frmSearch" action="?mode=Search" method="post">
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" class="Details_table">
   <tr>
     <td align="left" valign="top">
     
<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
<tr>
    <td align="center" valign="top">
      <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" style="border-bottom:1px dotted #ccc; padding-bottom:10px;">
<tr>
     <td width="26%"   align="left" valign="top" class="id_text">
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;Order ID
      </td>
     
     <td width="21%"   align="left" valign="top" class="id_text">
       &nbsp;&nbsp;&nbsp;&nbsp;Stitching ID
       </td>
     
     <td width="53%"  align="left" valign="top" class="id_text">
     &nbsp;&nbsp;&nbsp;Shipping Status</td>
 
     
</tr>
</table>
    </td>
</tr>
<tr>
<td align="center" valign="top">
     <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" style="padding-top:10px;">
<tr>
     <td width="26%"   align="left" valign="top" class="id_text">
      Search By : &nbsp;<input name="orderId" type="text" class="input" id="orderId" style="width:120px; border:1px solid #CCC; margin-top:-2px;" />
      </td>
     
     <td width="21%"   align="left" valign="top" class="id_text">
      or <input name="shippingId" type="text" class="input" id="shippingId" style="width:120px; border:1px solid #CCC; margin-top:-2px;" />
      </td>
     
     <td width="53%"  align="left" valign="top" class="id_text">& <select name="selShippingStatus" id="selShippingStatus" onchange="this.form.submit();">
         <option value="">All Orders</option>
         <option value="2" <?php if($_REQUEST['selShippingStatus']=='2'){?> selected="selected"<?php }?>> Shipped</option>
         <option value="1" <?php if($_REQUEST['selShippingStatus']=='1'){?> selected="selected"<?php }?>>Ready to Shipped</option>
         <option value="3" <?php if($_REQUEST['selShippingStatus']=='3'){?> selected="selected"<?php }?>>Issues</option>
       </select>
       <input name="submit" type="submit" class="button" style="background:#036eb4; border:none; color:#ffffff; width:85px; padding:3px; margin-left:15px; margin-top:-5px; cursor: pointer; font-weight:bold;" value="Search">
     </td>
 
     
</tr>
</table>
    </td>
</tr>
<tr>
  <td align="center" valign="top">
  <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
<tr>
     <td width="26%"   align="left" valign="top" class="id_text">
      Date        :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input name="dateTo" type="text"  class="input" id="dateTo" onclick="ds_sh(this);"   value="" style="width:120px; border:1px solid #CCC; margin-top:-2px;" />      </td>
     
       <td width="21%"   align="left" valign="top" class="id_text">
       to <input type="text" name="dateFrom" id="dateFrom" value="" alt=""  style="width:120px; border:1px solid #CCC; margin-top:-2px;"  onclick="ds_sh(this);"/>
       <span class="id_text1">Dispatch Date</span>       </td>
     
     <td width="53%"  align="left" valign="top" class="id_text"><span class="id_text1">
       <input type="text" name="dispatchDate" id="dispatchDate" value="" alt=""  style="width:120px; border:1px solid #CCC; margin-top:-2px;"  onclick="ds_sh(this);"/>
       </span></td>
</tr>
</table>
  </td>
</tr>
</table>

     </td>
  </tr>
</table>

</form>
<!--end of search table-->

</td>
</tr>

<tr>
   <td>
      <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" style="background:#000000; margin-top:5px;">

   <tr>
    <td width="104" class="nav" align="center">Order ID</td>
    <td width="172" class="nav" align="center">Customer Name </td>
    <td width="201" class="nav" align="center">Payment Method </td>
    <td width="127" class="nav" align="center">Amount</td>
    <td width="121" class="nav" align="center">O.Date</td>
    <td width="126" class="nav" align="center">Order Status</td>
    <td width="131" class="nav" align="center">Shipping Status </td>
    <td width="173" class="nav" align="center">Stitching Status </td>
    <td width="96" class="nav" align="center">Allocation Status</td>
    </tr>
</table>
   </td>
</tr>

 <!-- FOR ROW WISE DISPLAY-->
 <?php 
		  $i = 1;
		  $i=$i+$start;
		  $k=1;
	 while($resultCatalog = mysql_fetch_array($result))
		{
			//For Allocation Status
			$alocation_count=mysql_query("SELECT SUM(ims_oa.required_qty) as req_qty, SUM(ims_oa.allocated_qty) as aloc_qty FROM ims_orders_allocation ims_oa  WHERE ims_oa.orders_id='".$resultCatalog['orders_id']."' GROUP BY ims_oa.orders_id");
			$alocation_count_num=mysql_num_rows($alocation_count);
			$alocation_count_fetch=mysql_fetch_assoc($alocation_count);
			
			if($alocation_count_num>0)
			{
				if($alocation_count_fetch['req_qty']==$alocation_count_fetch['aloc_qty'])
				{
					$color='green';
				}else{
					$color='orange';
				}
				
			}else{
			
				$color='red';
			}
			//For Allocation Status
			
			
			//Stitching Status
			$sqlTotalOrder=mysql_fetch_array(mysql_query("SELECT count(ims_stitching_master.orders_id) as totalorderqty FROM ims_stitching_master where ims_stitching_master.orders_id='".$resultCatalog['orders_id']."' GROUP BY ims_stitching_master.orders_id"));
		$totalOrderQty=$sqlTotalOrder['totalorderqty'];
		
		$sqlTotalSending=mysql_fetch_array(mysql_query("SELECT
		count(ims_stitching_master.sending_date) as totalSending
		FROM
		ims_stitching_master
		where 
		ims_stitching_master.sending_date !=0 and ims_stitching_master.orders_id='".$resultCatalog['orders_id']."'
		GROUP BY ims_stitching_master.orders_id"));
		$totalSendingQty=$sqlTotalSending['totalSending'];
		if(isset($totalSendingQty))
		{
		$totalSendingQty=$totalSendingQty;
		}else{
		$totalSendingQty=0;
		}
		
		
		$sqlTotalReceive=mysql_fetch_array(mysql_query("SELECT
		count(ims_stitching_master.receiving_date) as totalReceive
		FROM
		ims_stitching_master
		where 
		ims_stitching_master.receiving_date !=0 and ims_stitching_master.orders_id='".$resultCatalog['orders_id']."'
		GROUP BY ims_stitching_master.orders_id"));
		$totalReceivingQty=$sqlTotalReceive['totalReceive'];
		if(isset($totalReceivingQty))
		{
		$totalReceivingQty=$totalReceivingQty;
		}else{
		$totalReceivingQty=0;
		}			
			//Stitching Status			
			
			
		// shipping status //
		
		$sqlReadyToShipped=mysql_fetch_array(mysql_query("SELECT
		count(ims_orders_shipping.dod) as ReadyToShip
		FROM
		ims_orders_shipping
		where 
		ims_orders_shipping.dod !=0 and 
		ims_orders_shipping.orders_id='".$resultCatalog['orders_id']."'
		GROUP BY ims_orders_shipping.orders_id"));
		$totalReadyToShipped=$sqlReadyToShipped['ReadyToShip'];
		if(isset($totalReadyToShipped))
		{
		$totalReadyToShipped=$totalReadyToShipped;
		}else{
		$totalReadyToShipped=0;
		}	
		
		
			
		// end shipping status//	
			
		  ?>
		  
<tr>
   <td align="center" valign="top">
   <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
   <tr>
      <td align="left" valign="top">
	<div id="wrapper">
		<div class="accordionButton">

		
         <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
            <tr onClick="Showtable(<?php echo $resultCatalog['orders_id'];?>,'<?php echo $_REQUEST['selShippingStatus']?>');showCat(<?php echo $resultCatalog['orders_id'];?>)" bgcolor="#<?php if($resultCatalog['orders_status']=='5'){echo "FF0000";}else { echo "FFFFFF";}?>">
			
                <td width="104" class="nav_text" align="center"><?php echo $resultCatalog['orders_id'];?></td>
                <td width="171" class="nav_text" align="center"><?php echo $resultCatalog['customers_name'];?></td>
                <td width="201" class="nav_text" align="center"><?php echo substr($resultCatalog['payment_method'],0,25);?></td>
                <td width="128" class="nav_text" align="center"><b>
				<?php
				echo strip_tags($orders['order_total']);
				$sqlAmount="SELECT
				orders_total.`text`
				FROM
				orders_total
				WHERE
				orders_total.orders_id =  '".$resultCatalog['orders_id']."' AND
				orders_total.title =  'Total:'
				";
				$ex=mysql_query($sqlAmount);
				$rs=mysql_fetch_array($ex);
				echo $rs[0];
				?>
				</b></td>
                <td width="121" class="nav_text" align="center"><?php echo date('d-m-Y',strtotime($resultCatalog['date_purchased']));?></td>
                <td width="127" class="nav_text" align="center"><?php echo GetField(orders_status,orders_status_id,orders_status_name,$resultCatalog['orders_status']);?></td>
                <td width="130" class="nav_text" align="center"><!--for shipping status-->
		<?php
		//echo "SELECT `orders_id`, sum(`products_quantity`) as totalQty FROM `orders_products` where orders_id='".$resultCatalog['orders_id']."' group by orders_id";
		$sqlOrdreQty=mysql_fetch_array(mysql_query("SELECT `orders_id`, sum(`products_quantity`) as totalQty FROM `orders_products` where orders_id='".$resultCatalog['orders_id']."' group by orders_id"));
		$totalQty=$sqlOrdreQty['totalQty'];
		
		$sqlShippedQty=mysql_fetch_array(mysql_query("SELECT count(orders_id) as shippedQty FROM `ims_orders_shipping` where shipping_status='2' and orders_id='".$resultCatalog['orders_id']."' group by orders_id"));
		$totalShippedQty=$sqlShippedQty['shippedQty'];
		if(isset($totalShippedQty))
		{
			$totalShippedQty=$totalShippedQty;
		}else{
			$totalShippedQty=0;
		}
		
		
		if(isset($totalReadyToShipped) or $totalReadyToShipped >0){ 
			echo $totalReadyToShipped." / ".$totalQty."&nbsp;&nbsp; <font color=\"#009900\">[".$totalShippedQty."]</font>";
		}else{
			echo "0"." / ".$totalQty."&nbsp;&nbsp; <font color=\"#009900\">[".$totalShippedQty."]</font>";
		}		
		?>
		<!--end -->	</td>
                <td width="175" class="nav_text" align="center"><strong><?php echo $totalSendingQty." / ".$totalOrderQty."&nbsp;&nbsp; <font color=\"#009900\">[".$totalReceivingQty."]</font>";?></strong></td>	 
                <td width="94" class="nav_text" bgcolor="<?php echo $color; ?>"><strong><?php if($alocation_count_num>0){echo $alocation_count_fetch['aloc_qty'].' / '.$alocation_count_fetch['req_qty'] ; }else{echo 'Not Allocated';}?></strong></td>
          </tr>
		</table>
        </div>
		<div>
        
		<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
		<tr>
           <td colspan="9">
		   

<div align="center" id="loader<?php echo $resultCatalog['orders_id'];?>" style="display:none"><img src="../images/ajax-loader.gif"></div>	   	
<div id="showP<?php echo $resultCatalog['orders_id'];?>"></div></td>
     
		 
  
<input type="hidden" name="cat_text" id="cat_text"/>  
	
	

</tr>    
		
		</table>


        </div>
	</div>
      </td>
   </tr>
   </table>
   </td>
</tr>

<?php    
 $i++;
 $count++;
 $k++;
}
?> 
 <?php if($count== 0 || $count=="")  {?>
<tr>
<td colspan="9" align="center" class="search_text">Records Not Found !! </td>
</tr>
<?php }?>
<tr>
<td colspan="9" class="blackFont">
<link rel="stylesheet" type="text/css" href="includes/functions/paginate.css">
<?php //echo $count;?>
<?=$pagination?></td>
</tr>

 <!-- END FOR ROW WISE DISPLAY-->
</table>
<?php 
if($_REQUEST['mode']=='open' && $_REQUEST['orderId']!='')
{
echo "<script>Showtable(".$_REQUEST['orderId'].");showCat(".$_REQUEST['orderId'].");</script>";	
}
?>
</body>
</html>
