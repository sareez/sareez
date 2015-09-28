<?php

/*FOR DOING CONNECTION WITH REMOTE SERVER DATABASE WE NEED TO CREATE A USER AT REMOTE AND GIVE FULL PERMISSION TO NEW USER.
CREATE THE NEW USER IN MYSQL

syntax :
mysql>GRANT ALL ON *.* to asgar@'192.1687.1.44' IDENTIFIED BY 'pass';
mysql>FLUSH PRIVILEGES;


CREATE USER 'magento'@'104.130.194.77' IDENTIFIED BY 'magento_pass';
GRANT ALL PRIVILEGES ON * . * TO 'magento'@'104.130.194.77';
FLUSH PRIVILEGES;


*/



//$conn=mysql_connect('184.106.45.117:3306','sareez_local','My_L0cpa$')or die(mysql_error());

/*mysql_select_db('sareez_db',$conn) or die (mysql_error(mysql_error));*/

$conn=mysql_connect('184.106.45.117:3306','magento2','magento_pass')or die(mysql_error());
//$conn=mysql_connect('14.96.83.227:3306','asgar','asgar123')or die(mysql_error());


///mysql_select_db('sareez_db',$conn) or die (mysql_error(mysql_error));
mysql_select_db('sareez_db',$conn);
if(isset($conn))
	echo "done";
else
	echo "not done";

?>

