<?php
require_once('app/Mage.php');
umask(0);
Mage::app();
$storeId    = 1;
//$product    = Mage::getModel('catalog/product');
//$products   = $product->getCollection()->addStoreFilter($storeId)->getData(); 

$ProArray = array('41LL6027','94-1032LL215573','65-1130LL408349','148-1351LL484956','148-1351LL534176','148-1351LL754406','148-1351LL559063','148-1351LL580191','148-1351LL201501','148-1351LL763988','148-1351LL85103','148-1351LL938078','148-1351LL850045','148-1351LL181060');

$test = "<?xml version=".'"'."1.0".'"'."?>
	<rss xmlns:g=".'"'."http://base.google.com/ns/1.0".'"'." version=".'"'."2.0".'"'.">
	   <channel>
		<title>Buy Sareez Online</title>
		<link>http://www.sareez.com</link>
		<description>Buy Sareez Online</description>";


 //$test ='';
$i = 0;
//foreach($products as $chinmay){
for ($a = 0; $a < count($ProArray); $a++) {
		
//$product    = Mage::getModel('catalog/product');
$chinmay = Mage::getModel('catalog/product')->loadByAttribute('sku',$ProArray[$a]);	
//echo "<pre>"; print_r($chinmay); die;
	
$product_id = $chinmay['entity_id'];
$obj = Mage::getModel('catalog/product');
$_product = $obj->load($chinmay['entity_id']); 

if($_product->getStatus() == "1") {
if($_product->getVisibility() == "4"){
$pos = strpos($_product->getSku(), 'LL');

if($pos==true){

$img=Mage::getModel('catalog/product_media_config')
        ->getMediaUrl( $_product->getImage() );
		//echo "111";
//echo $text =$_product->getData('color_old'); ;exit;


$test .= "\n"."<item>	
			<g:id>".$_product->getSku()."</g:id>		
			<title><![CDATA[".$_product->getName()."]]></title>
			<link><![CDATA[".$_product->getProductUrl()."]]></link>
			<g:price>".$_product->getPrice()." USD</g:price>
			<description><![CDATA[".$_product->getDescription()."]]></description>
			<g:product_type><![CDATA[Lehenga Choli]]></g:product_type>
			<g:google_product_category><![CDATA[Clothing & Accessories > Clothing]]></g:google_product_category>
			<g:image_link><![CDATA[".$img."]]></g:image_link>	
			<g:condition>new</g:condition>
			<g:availability>in stock</g:availability>
			<g:gender>Female</g:gender>
			<g:age_group>Adult</g:age_group>
			<g:color>".$_product->getData('color_old')."</g:color>
			<g:size><![CDATA[XL]]></g:size>
			<g:brand><![CDATA[Sareez]]></g:brand>		
			<g:mpn><![CDATA[SA155889]]></g:mpn>			
</item>"."\n";

 //if ($i >= 2000) { break ; }
 
 //echo $i.'--';
	//echo $_product->getId()."<br>";
$i++;
echo $i."<br>";
//echo $_product->getStatus();
//echo $_product->getVisibility();
}

}
}


//$i++;
}

$test .="</channel>
</rss>";


//$myfile = fopen("feeds/SW.xml", "w") or die("Unable to open file!");
$myfile = fopen("feeds/naba_lehenga-choli_test.xls", "w") or die("Unable to open file!");
$txt = $test."\n";
fwrite($myfile, $txt);
//$txt = $test."\n";
////fwrite($myfile, $txt);
fclose($myfile);
?>