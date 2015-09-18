<?php

//// database variables
//$hostname = "localhost";
//$user = "root";
//$password = "";
//$database = "csv";
//
//// Database connecten voor alle services
//mysql_connect($hostname, $user, $password)
//or die('Could not connect: ' . mysql_error());
//					
//mysql_select_db($database)
//or die ('Could not select database ' . mysql_error());

$conn = mysql_connect("localhost","root","rootwdp") or die("ERROR::Not connected to SERVER"); 
$db = mysql_select_db("sareees_db",$conn) or die("ERROR::Not connected to DATABASE");
 
function convert_to_csv($input_array, $output_file_name, $delimiter)
{
    /** open raw memory as file, no need for temp files */
    $temp_memory = fopen('php://memory', 'w');
    /** loop through array  */
    foreach ($input_array as $line) {
        /** default php csv handler **/
        fputcsv($temp_memory, $line, $delimiter);
    }
    /** rewrind the "file" with the csv lines **/
    fseek($temp_memory, 0);
    /** modify header to be downloadable csv file **/
    header('Content-Type: application/csv');
    header('Content-Disposition: attachement; filename="' . $output_file_name . '";');
    /** Send file to browser for download */
    fpassthru($temp_memory);
}
 
/** Array to convert to csv */


$query = mysql_query("select * from ordercsv");


//$name = "Name";
//$roll = "Roll";
//$class = "Class";
while($result = mysql_fetch_assoc($query))
{
    
    $order_id[] = $result['order_id'];
    $product_name[] = $result['product_name'];
//    $sku[] = $result['sku'];
//    $design_no[] = $result['design_no'];
//    $manufacturer[] = $result['manufacturer'];
//    $catalog_name[] = $result['catalog_name'];
//    $stock_available[] = $result['stock_available'];
//    $option_name[] = $result['option_name'];
   
    
}
 
$array_to_csv = Array(

    $order_id,
    $product_name
//    $sku,
//    $design_no,
//    $manufacturer,
//    $catalog_name,
//    $stock_available,
//    $option_name

//    Array(12566,
//        'Enmanuel',
//        'Corvo'
//    ),
//    
//    Array(56544,
//        'John',
//        'Doe'
//    ),
//    
//    Array(78550,
//        'Mark',
//        'Smith'
//    )
    
);
 
convert_to_csv($array_to_csv, 'report.csv', ',');
?>