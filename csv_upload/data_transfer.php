<?php
include '../db/connection.php';


$query = "select * from ordercsv_backup";

$query1 = mysql_query($query);

while($query2 = mysql_fetch_assoc($query1)){
    
   echo $insertQuery = "insert into ordercsv set
       
title = '".$query2['title']."',
filename = '".$query2['filename']."',
content = '".$query2['content']."',
order_id = '".$query2['order_id']."',
categories_id = '".$query2['categories_id']."',
productid = '".$query2['productid']."',
product_name = '".$query2['product_name']."',
sku = '".$query2['sku']."',
design_no = '".$query2['design_no']."',
manufacturer = '".$query2['manufacturer']."',
catalog_name = '".$query2['catalog_name']."',
 quantity = '".$query2['quantity']."',
r_quantity = '".$query2['r_quantity']."',
a_quantity = '".$query2['a_quantity']."',
stock_available = '".$query2['stock_available']."',
option_name = '".$query2['option_name']."',
download_status = '".$query2['download_status']."',
download_status_process = '".$query2['download_status_process']."',
status = '".$query2['status']."',
order_date = '".$query2['order_date']."',
allocationstatus_id = '".$query2['allocationstatus_id']."',
allocation_date = '".$query2['allocation_date']."',
created_time = '".$query2['created_time']."',
update_time = '".$query2['update_time']."' 
 
     
     ";
                              
   mysql_query($insertQuery);
}