<?php
require_once 'app/Mage.php';
Mage::app();
echo "chinmay dutta";
$conn = mysql_connect("localhost","root","rootwdp") or die("ERROR::Not connected to SERVER"); 
$db = mysql_select_db("sareees_db",$conn) or die("ERROR::Not connected to DATABASE");
//758395
for($i=756036; $i<=758395; $i++){
	echo $i;
	$sql1=mysql_query("SELECT * FROM custom_options_option_view_mode");
		while ($row = mysql_fetch_array($sql1) ) {
			if($row['option_id']!=$i){			
			echo "chinmay";
			echo $row['option_id'];
	$catalog_mode="INSERT INTO `custom_options_option_view_mode` (`view_mode_id`, `option_id`, `store_id`, `view_mode`) VALUES ('', '".$i."', '0', '1')";
		mysql_query($catalog_mode);
			}else{
				
				echo "test";
			}
		
		}
}


?>