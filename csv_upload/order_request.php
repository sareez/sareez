<?php require_once('../app/Mage.php');

function isBackendUserLoggedIn() {
    if (!array_key_exists('adminhtml', $_COOKIE)) return false;

    if(!session_id()) session_start();
    $oldSession = $_SESSION;

    Mage::app();

    $sessionFilePath = Mage::getBaseDir('session') . DS . 'sess_' . $_COOKIE['adminhtml'];
    $sessionContent  = file_get_contents($sessionFilePath);

    session_decode($sessionContent);

    /** @var Mage_Admin_Model_Session $session */
    $session  = Mage::getSingleton('admin/session');
    $loggedIn = $session->isLoggedIn();

    //set old session back to current session
    $_SESSION = $oldSession;

    return $loggedIn;
}
?>
<?php date_default_timezone_set("Asia/Kolkata"); ?>
<?php
include '../db/connection.php';
/*. "ordercsv_id,"*/
 $select = "select "
        
        ."unique_stitching_id,"
        . "order_id,"
        . "sku,"
        . "manufacturer_design,"
        . "manufacturers_id,"
        . "catalogmaster_id,"
		. "qty,"
        . "order_date,"
		. "allocated_by,"
        . "product_stitching_type,"
		. "option_value,"
		. "order_status,"
		. "payment_method"
        . " from sales_flat_order_item_stitching where order_status IN ('inprogress','fraud','processing','inprocess') and download_status_process = 'N' and allocationstatus_id = '1' and allocation_date <= '".$_REQUEST['date_pick']."'"; 

$export = mysql_query ( $select ) or die ( "Sql error : " . mysql_error( ) );

$fields = mysql_num_fields ( $export );

/*for ( $i = 0; $i < $fields; $i++ )
{
    $header .= mysql_field_name( $export , $i ) . "\t";
	
}*/

//echo $header."KKK"; die;
$header ="unique_stitching_id \t Order_id \t sku \t Manufacturer Design No. \t Manufacturer Name \t Catalog Name \t Qty \t Order Date \t Allocated By \t Product Option Type \t Option Value \t Order Status \t Payment Method". "\t";
while( $row = mysql_fetch_row( $export ) )
{
    


    
    $line = '';
	
	//echo "<pre>"; print_r($row); die;
    //foreach( $row as $value )
    for($x=0; $x<count($row); $x++)
    {     
		
		if($x==4){
			$s="SELECT `manufacturers_name` FROM `manufacturers` WHERE `manufacturers_id`=".$row[4];
			$q=mysql_query($s) or die("HHHH".mysql_error());
			$r = mysql_fetch_array($q);
			$value = $r['manufacturers_name'];
		} else if($x==5){
			$s1="SELECT `catalog_name` FROM `int_catalogmaster` WHERE `catalog_id`=".$row[5];
			$q1=mysql_query($s1) or die("HHHH1".mysql_error());
			$r1 = mysql_fetch_array($q1);
			$value = $r1['catalog_name'];
		}
		else if($x==1){
			$s2="SELECT `increment_id` FROM `sales_flat_order_grid` WHERE `entity_id`=".$row[1];
			$q2=mysql_query($s2) or die("HHHH1".mysql_error());
			$r2 = mysql_fetch_array($q2);
			$value = $r2['increment_id'];
		}
		 else {
			$value = $row[$x];
		}
	//echo "<pre>"; print_r($value); die;                                       
        if ( ( !isset( $value ) ) || ( $value == "" ) )
        {
            $value = "\t";
            
            
         // echo "aaaaaaaa".$row[0]."zzzz";
    // echo "update ordercsv set download_status = 'N' where ordercsv_id = '".$row[0]."'";          
    // echo "update ordercsv set download_status = 'Y' where ordercsv_id = '".printf("%s ",$row[0])."'"; // exit;
   // echo "<br />";
//mysql_query("update ordercsv set download_status = 'N' where ordercsv_id = '".printf("%s ",$row[0])."'");
mysql_query("update sales_flat_order_item_stitching set download_status_process = 'Y', download_date ='".date('Y-m-d')."' where unique_stitching_id = '".$row[0]."'"); 


        }
        else
        {
            
			
			$value = str_replace( '"' , '""' , $value );
            $value = '"' . $value . '"' . "\t";
            
            
            
        // echo "aaaaaaaa".$row[0]."zzzz";
   // echo "update ordercsv set download_status = 'N' where ordercsv_id = '".$row[0]."'";          
    // echo "update ordercsv set download_status = 'Y' where ordercsv_id = '".printf("%s ",$row[0])."'"; // exit;
    //echo "<br />";
// mysql_query("update ordercsv set download_status = 'N' where ordercsv_id = '".printf("%s ",$row[0])."'");
 mysql_query("update sales_flat_order_item_stitching set download_status_process = 'Y', download_date ='".date('Y-m-d')."' where unique_stitching_id = '".$row[0]."'"); 
            
            
        }
        $line .= $value;
    }
    $data .= trim( $line ) . "\n";
    
    // echo "update ordercsv set download_status = 'N' where ordercsv_id = '".$row[0]."'";
    // mysql_query("update ordercsv set download_status = 'N' where ordercsv_id = '".$row[0]."'"); 
    
}
$data = str_replace( "\r" , "" , $data );

if ( $data == "" )
{
    $data = "\n(0) Records Found!\n";                        
}

$filename = 'order_request_'.date('Y-m-d').'_'.date('H:i:s').'.xls';


 header("Content-type: application/octet-stream");
 header("Content-Disposition: attachment; filename=".$filename);
 header("Pragma: no-cache");
 header("Expires: 0");
 print "$header\n$data";



?>

