<?php
include '../db/connection.php';
/*. "ordercsv_id,"*/
 $select = "select "
        
        
        . "order_id,"
        . "product_name,"
        . "sku,"
        . "design_no,"
        . "manufacturer,"
        . "catalog_name,"
		. "quantity,"
        . "stock_available,"
        . "order_date,"
        . "option_name"
        . " from ordercsv where download_status_process = 'N'"; // exit;   and order_date <= '".$_REQUEST['date_pick']."' 

$export = mysql_query ( $select ) or die ( "Sql error : " . mysql_error( ) );

$fields = mysql_num_fields ( $export );

for ( $i = 0; $i < $fields; $i++ )
{
    $header .= mysql_field_name( $export , $i ) . "\t";
}

while( $row = mysql_fetch_row( $export ) )
{
    


    
    $line = '';
    foreach( $row as $value )
    {                                            
        if ( ( !isset( $value ) ) || ( $value == "" ) )
        {
            $value = "\t";
            
            
         // echo "aaaaaaaa".$row[0]."zzzz";
    // echo "update ordercsv set download_status = 'N' where ordercsv_id = '".$row[0]."'";          
    // echo "update ordercsv set download_status = 'Y' where ordercsv_id = '".printf("%s ",$row[0])."'"; // exit;
   // echo "<br />";
//mysql_query("update ordercsv set download_status = 'N' where ordercsv_id = '".printf("%s ",$row[0])."'");
mysql_query("update ordercsv set download_status_process = 'Y' where ordercsv_id = '".$row[0]."'"); 


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
 mysql_query("update ordercsv set download_status_process = 'Y' where ordercsv_id = '".$row[0]."'"); 
            
            
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

$filename = 'order_'.date('Y-m-d').'_'.date('H:i:s').'.xls';


 header("Content-type: application/octet-stream");
 header("Content-Disposition: attachment; filename=".$filename);
 header("Pragma: no-cache");
 header("Expires: 0");
 print "$header\n$data";



?>

