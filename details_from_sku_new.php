<?php
require_once 'app/Mage.php';
Mage::app();

$host = "localhost";
$user = "hbanfvqkdv";
$pwd = "tXySfqDmQ3";
$dbname = "hbanfvqkdv";

/*$product = Mage::getModel('catalog/product')->loadByAttribute('sku','316-3718SL918621');
echo $product->getManufacturersId().'<br>'; 
echo $product->getCatalogmasterId().'<br>';
echo $product->getManufacturerDesign(); die;*/

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>::Get Details from SKU::</title>
</head>

<body>
<form name="see_catalog" method="post" action="" enctype="multipart/form-data">
<table width="500" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><strong>Enter Sku</strong></td>
    <td><strong>:</strong></td>
    <td><input type="text" name="sku" id="sku" /></td>
  </tr>
  <tr><td colspan="3" height="5"></td></tr>
  <tr>
    <td colspan="3"><input type="submit" name="submit" id="submit" value="Submit" /></td>
  </tr>  
</table>
</form>

<?php

if(isset($_REQUEST['submit']))
{
	$prod_sku=$_REQUEST['sku'];
	//$product = Mage::getModel('catalog/product')->loadByAttribute('sku','316-3718SL918621');
	$product = Mage::getModel('catalog/product')->loadByAttribute('sku',$prod_sku);
	//echo count($product); die;
	//echo "<pre>"; print_r($product); die;
	
	$ManufacturersId = $product->getManufacturersId(); 
	$CatalogmasterId = $product->getCatalogmasterId();
	$ManufacturerDesign = $product->getManufacturerDesign(); 
	$imageName = $product->getImage(); 
	$base_url=Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
	
	$conn = mysql_connect("$host","$user","$pwd") or die("ERROR::Not connected to SERVER");	
	$db = mysql_select_db("$dbname",$conn) or die("ERROR::Not connected to DATABASE");
		
	$qry="SELECT `catalog_name` FROM `int_catalogmaster` WHERE `catalog_id`='".$CatalogmasterId."'";
	$res=mysql_query($qry) or die("ERROR1".mysql_error());
	$fetch=mysql_fetch_array($res);
	$CatalogName = $fetch['catalog_name'];
	
	$qry1="SELECT `manufacturers_name` FROM `manufacturers` WHERE `manufacturers_id`='".$ManufacturersId."'";
	$res1=mysql_query($qry1) or die("ERROR11".mysql_error());
	$fetch1=mysql_fetch_array($res1);
	$ManufacturersName = $fetch1['manufacturers_name'];
?>
<br /><br />
<table width="40%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="40%">Product Sku</td>
    <td width="60%"><?php echo $prod_sku; ?></td>
  </tr>
  
  <tr>
    <td width="40%">Manufacturer Name</td>
    <td width="60%"><?php  echo $ManufacturersName; ?> [<?php  echo $ManufacturersId; ?>]</td>
  </tr>
  
  <tr>
    <td width="40%">Catalog Name</td>
    <td width="60%"><?php echo $CatalogName; ?> [<?php  echo $CatalogmasterId; ?>]</td>
  </tr>
  
  <tr>
    <td width="40%">Manufacturer Model</td>
    <td width="60%"><?php echo $ManufacturerDesign; ?></td>
  </tr>      
</table>
<br />
<?php if($imageName<>''){?>
<img src="<?php echo $base_url; ?>media/catalog/product<?php echo $imageName; ?>" border="0" />
<?php } else { echo "No Image Available!!";?>
<?php } ?>
<?php } ?>

</body>
</html>
