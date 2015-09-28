
<?php 
error_reporting(1);
set_time_limit (0);
//require('includes/application_top.php');
require_once('app/Mage.php');
umask(0);
Mage::app();//->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

define('SEO_ENABLED','true');    //Change to 'false' to disable if Ultimate SEO URLs is not installed
//define('FEEDNAME', 'tecidoztest29.xml');       //from your googlebase account
define('FEEDNAME', 'fb-sherwani-feed.xml');       //from your googlebase account
//define('DOMAIN_NAME', 'www.tecidoz.com'); //your correct domain name (don't include www unless it is used)
define('DOMAIN_NAME', 'www.sareez.com'); //your correct domain name (don't include www unless it is used)
define('FTP_USERNAME', 'sareez'); //from your googlebase account
define('FTP_PASSWORD', 'ankitjain321'); //from your googlebase account

define('FTP_ENABLED', '1');      //set to 0 to disable
define('CONVERT_CURRENCY', '0'); //set to 0 to disable - only needed if a feed in a difference currecny is required
define('CURRENCY_TYPE', 'USD');  //(eg. USD, EUR, GBP)
define('DEFAULT_LANGUAGE', 1);   //Change this to the id of your language.  BY default 1 is english

define('OPTIONS_ENABLED', 1);
define('OPTIONS_ENABLED_AGE_RANGE', 0);
define('OPTIONS_ENABLED_BRAND', 1);//bodhi
define('OPTIONS_ENABLED_CONDITION', 1);
define('OPTIONS_ENABLED_CURRENCY', 0);
define('OPTIONS_ENABLED_FEED_LANGUAGE', 0);
define('OPTIONS_ENABLED_FEED_MANUFACTURE_ID', 0);
define('OPTIONS_ENABLED_FEED_QUANTITY', 0);
define('OPTIONS_ENABLED_MADE_IN', 0);
define('OPTIONS_ENABLED_MANUFACTURER', 1);//bodhi
define('OPTIONS_ENABLED_PAYMENT_ACCEPTED', 0);
define('OPTIONS_ENABLED_PRODUCT_TYPE', 0);
define('OPTIONS_ENABLED_SHIPPING', 0);
define('OPTIONS_ENABLED_UPC', 0);
define('OPTIONS_ENABLED_WEIGHT', 0);

//the following only matter if the matching option is enabled above. 
define('OPTIONS_AGE_RANGE', '0-9');
define('OPTIONS_BRAND', 'Sareez');//bodhi
define('OPTIONS_CONDITION', 'New');  //possible entries are New, Refurbished, Used
define('OPTIONS_DEFAULT_CURRENCY', 'USD');
define('OPTIONS_DEFAULT_FEED_LANGUAGE', 'en');
define('OPTIONS_LOWEST_SHIPPING', ''); //this is not binary.  Custom Code is required to provide the shipping cost per product.  ###needs to be an array for per product.
define('OPTIONS_MADE_IN', 'USA');
define('OPTIONS_PAYMENT_ACCEPTED_METHODS', ''); //Acceptable values: cash, check, GoogleCheckout, Visa, MasterCard, AmericanExpress, Discover, wiretransfer
define('OPTIONS_WEIGHT_ACCEPTED_METHODS', 'lb'); //Valid units include lb, pound, oz, ounce, g, gram, kg, kilogram.


$OutFile = "feeds/" . FEEDNAME; 
//$OutFile = FEEDNAME; 
$destination_file = FEEDNAME;   
$source_file = $OutFile;

if ( file_exists( $OutFile ) )
unlink( $OutFile );

$taxRate = 0; //default = 0 (e.g. for 17.5% tax use "$taxRate = 17.5;")
$taxCalc = ($taxRate/100) + 1;  //Do not edit
$imageURL = 'http://' . DOMAIN_NAME . '/images/';
$already_sent = array();

/*********************************************/

$storeId    = 1;
$product    = Mage::getModel('catalog/product');
$products   = $product->getCollection()->addStoreFilter($storeId)->getData(); 
$i = 1;
foreach($products as $chinmay){
	
$product_id = $chinmay['entity_id'];
$obj = Mage::getModel('catalog/product');
$_product = $obj->load($chinmay['entity_id']);

$output = '';
$output .= '<?xml version="1.0"?>';

$output .='<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">
	    <channel>
		<title>Buy Sareez Online</title>
		<link>http://www.sareez.com</link>
		<description>Buy Sareez Online</description>';
 
if($_product->getStatus()!="Disabled"){


$name = $_product->getName();;




$output .='
  <item>			
			<title><![CDATA['$name']]></title>
					
			'
$output .='</item>';



 if ($i >= 3) { break ; }
}
	
	$i++;
}
$output .='</channel>
               </rss>';
			   
//echo 	$output;		
$fp = fopen( $OutFile , "w" );
$fout = fwrite( $fp , $output );
fclose( $fp );
echo "File completed";
chmod($OutFile, 0777);

?>
