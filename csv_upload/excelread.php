<?php 
require_once '../app/Mage.php';
Mage::app();

$conn = mysql_connect("localhost","hbanfvqkdv","tXySfqDmQ3") or die("ERROR::Not connected to SERVER"); 
$db = mysql_select_db("hbanfvqkdv",$conn) or die("ERROR::Not connected to DATABASE");




$local_conn = mysql_connect("www.babulall.com","anik","pass") or die("ERROR::Not connected to SERVER"); 
$db = mysql_select_db("anik",$local_conn) or die("ERROR::Not connected to DATABASE");

 ?>

<!--<form name="upload_form" method="POST" ation="http://sareees.com/csv_upload/excelread.php" enctype="multipart/form-data">
	<input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Excel" name="submit">
</form>-->
<form name="upload_form" method="POST" ation="http://www.sareees.com/csv_upload/excelread.php" enctype="multipart/form-data">
	<input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Excel" name="submit">
</form>


<?php
if($_REQUEST['submit'])
{

	$postValues = $_POST;
	$target_dir = "customer_excel/";
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




//$conn = mysql_connect("localhost","root","rootwdp") or die("ERROR::Not connected to SERVER"); 
//$db = mysql_select_db("sareees_db",$conn) or die("ERROR::Not connected to DATABASE");



require_once('excel_reader/excel_reader.php');
$excel = new PhpExcelReader;
$excel->read('customer_excel/'.$newfilename);
$excel_data = $excel->sheets;
echo "<pre>";
print_r($excel_data);
echo "</pre>";

$count = $excel_data[0]['numRows'];

$customer_data = array(
						2 =>'email',
						6 =>'firstname',
						7 =>'lastname',
						8 =>'passwordhash',
					);
					
$billing_address = array(
							9 => "billing_firstname",
							11 => "billing_lastname",
							13 => "billing_street_full",
							27 => "billing_company",
							25 => "billing_postcode",
							22 => "billing_city",
							23 => "billing_region",
							24 => "billing_country"
						);
						
$shipping_address = array(
							30 => "shipping_firstname",
							32 => "shipping_lastname",
							34 => "shipping_street_full",
							48 => "shipping_company",
							46 => "shipping_postcode",
							43 => "shipping_city",
							44 => "shipping_region",
							45 => "shipping_country"
						);
$j = 0;
for($i=2; $i<=$count;$i++)
{
	foreach($customer_data as $key=>$value)
	{
		if($excel_data[0]['cells'][$i][$key] !== '' || array_key_exists($key, $excel_data[0]['cells'][$i]))
		{
			$datas[$j][$value] = $excel_data[0]['cells'][$i][$key];
		}
	}
	
	$query2 = "SELECT entity_id,created_at, updated_at from hbanfvqkdv.customer_entity where email ='".$excel_data[0]['cells'][$i][2]."'";
	$results2 = mysql_fetch_assoc(mysql_query($query2,$conn));
	$datas[$j]['created_at'] = $results2['created_at'];
	$datas[$j]['updated_at'] = $results2['updated_at'];
	$datas[$j]['customer_id'] = $results2['entity_id'];
	
	
	$subscriber = Mage::getModel('newsletter/subscriber')->loadByEmail($excel_data[0]['cells'][$i][2]);
	if($subscriber->getId())
    {
		$datas[$j]['is_subscribed'] = 1;
	}
	else
	{
		$datas[$j]['is_subscribed'] = 0;
	}
	
 foreach($datas as $data)
{
	echo $sql = "SELECT * from customers WHERE customers_email_address = '".$data['email']."'";
	$record_exists = mysql_fetch_assoc(mysql_query($sql,$conn));
	if(empty($record_exists)){
				echo $sql = "INSERT into anik.customers (customers_id, customers_firstname, customers_lastname, customers_email_address, customers_telephone, customers_password, 
				customers_newsletter) VALUES ('".$data['customer_id']."','".$data['firstname']."', '".$data['lastname']."' , '".$data['email']."', '".$data['billing_telephone']."', '".$data['passwordhash']."',
				'".$data['is_subscribed']."')";
				
				
				$sqlCust = mysql_query($sql,$local_conn);
				
				
				echo $customers_info = mysql_query("INSERT into anik.customers_info(customers_info_id, customers_info_date_account_created, customers_info_date_account_last_modified) VALUES ('".$data['customer_id']."','".$data['created_at']."', '".$data['updated_at']."')",$local_conn);
								
							
	
							
			}
		} 
	}
	
	
}
?>