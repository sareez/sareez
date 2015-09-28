<?php require_once('app/Mage.php');

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

if(isBackendUserLoggedIn()) {
    //echo 'Welcome!';


$conn = mysql_connect("localhost","root","rootwdp") or die("ERROR::Not connected to SERVER"); 
$db = mysql_select_db("sareees_db",$conn) or die("ERROR::Not connected to DATABASE");

	if(isset($_REQUEST['flag']) && $_REQUEST['flag']==2)
	{
		//echo $_REQUEST['product_id']."KKK".$_REQUEST['item_id']; die;
		//echo "<pre>"; print_r($_REQUEST); die;
		//echo $_POST["stitchingstatus_id"];
		//echo $_POST["telormaster_id"]."</br>";
		//echo count($_REQUEST['telormaster_id'][1]); die;

$unique_stitching_id_like = $_REQUEST['unique_stitching_id']."-";		
$ss="SELECT * FROM `sales_flat_order_item_stitching` WHERE `unique_stitching_id` LIKE '$unique_stitching_id_like%' AND `item_id`='".$_REQUEST['item_id']."' AND `product_id`='".$_REQUEST['product_id']."' AND `order_id`='".$_REQUEST['order_id']."'";
$qq = mysql_query($ss) or die("ERROR11::".mysql_error());

if(mysql_num_rows($qq)>0){
	/*$del_q = "DELETE FROM `sales_flat_order_item_stitching` WHERE `unique_stitching_id` LIKE '$unique_stitching_id_like%' AND `item_id`='".$_REQUEST['item_id']."' AND `product_id`='".$_REQUEST['product_id']."' AND `order_id`='".$_REQUEST['order_id']."'";
	$q = mysql_query($del_q) or die("ERROR12::".mysql_error());*/
	
		for($i=0; $i<count($_REQUEST['telormaster_id']); $i++)
		{
			if($_REQUEST['stitchingstatus_id'][$i] <> '0' || $_REQUEST['telormaster_id'][$i] <> '0' || $_REQUEST['comment'][$i] <> ''){
			//if(isset($_REQUEST['telormaster_id'][$i]) && $_REQUEST['telormaster_id'][$i] <> ''){
			$unique_stitching_id = 	$_REQUEST['unique_stitching_id']."-".$i; 
		$sql="UPDATE `sales_flat_order_item_stitching` SET `stitchingstatus_id`='".$_REQUEST['stitchingstatus_id'][$i]."',`product_stitching_type`='".$_REQUEST['product_stitching_type']."',`tailormaster_id`='".$_REQUEST['telormaster_id'][$i]."',`comment`='".$_REQUEST['comment'][$i]."',`qty`='".$_REQUEST['telormaster_qty'][$i]."',`item_id`='".$_REQUEST['item_id']."',`product_id`='".$_REQUEST['product_id']."',`sku`='".$_REQUEST['sku']."',`order_id`='".$_REQUEST['order_id']."',`sending_date`='".$_REQUEST['sending_date'][$i]."',`reciving_date`='".$_REQUEST['reciving_date'][$i]."' WHERE `unique_stitching_id`='".$unique_stitching_id."'";
			mysql_query($sql) or die("ERROR3::".mysql_error());
			
			$sqlcmnt="INSERT INTO `sales_flat_order_item_stitching_history` SET `stitchingstatus_id`='".$_REQUEST['stitchingstatus_id'][$i]."',`tailormaster_id`='".$_REQUEST['telormaster_id'][$i]."',`comment`='".$_REQUEST['comment'][$i]."',`qty`='".$_REQUEST['telormaster_qty'][$i]."',`item_id`='".$_REQUEST['item_id']."',`product_id`='".$_REQUEST['product_id']."',`sku`='".$_REQUEST['sku']."',`order_id`='".$_REQUEST['order_id']."',`sending_date`='".$_REQUEST['sending_date'][$i]."',`reciving_date`='".$_REQUEST['reciving_date'][$i]."',`unique_stitching_id`='".$unique_stitching_id."',`comment_date`='".date("Y-m-d H:i:s")."'";
			//echo $sqlcmnt; die;
			mysql_query($sqlcmnt) or die("ERROR41::".mysql_error());
			
			//}
			}
		}
} else {
		for($i=0; $i<count($_REQUEST['telormaster_id']); $i++)
		{
			if($_REQUEST['stitchingstatus_id'][$i] <> '0' || $_REQUEST['telormaster_id'][$i] <> '0' || $_REQUEST['comment'][$i] <> ''){
			//if(isset($_REQUEST['telormaster_id'][$i]) && $_REQUEST['telormaster_id'][$i] <> ''){
			$unique_stitching_id = 	$_REQUEST['unique_stitching_id']."-".$i;
		$sql="INSERT INTO `sales_flat_order_item_stitching` SET `product_stitching_type`='".$_REQUEST['product_stitching_type']."',`stitchingstatus_id`='".$_REQUEST['stitchingstatus_id'][$i]."',`tailormaster_id`='".$_REQUEST['telormaster_id'][$i]."',`comment`='".$_REQUEST['comment'][$i]."',`qty`='".$_REQUEST['telormaster_qty'][$i]."',`item_id`='".$_REQUEST['item_id']."',`product_id`='".$_REQUEST['product_id']."',`sku`='".$_REQUEST['sku']."',`order_id`='".$_REQUEST['order_id']."',`sending_date`='".$_REQUEST['sending_date'][$i]."',`reciving_date`='".$_REQUEST['reciving_date'][$i]."',`unique_stitching_id`='".$unique_stitching_id."'";
			mysql_query($sql) or die("ERROR4::".mysql_error());
			
		$sqlcmnt="INSERT INTO `sales_flat_order_item_stitching_history` SET `stitchingstatus_id`='".$_REQUEST['stitchingstatus_id'][$i]."',`tailormaster_id`='".$_REQUEST['telormaster_id'][$i]."',`comment`='".$_REQUEST['comment'][$i]."',`qty`='".$_REQUEST['telormaster_qty'][$i]."',`item_id`='".$_REQUEST['item_id']."',`product_id`='".$_REQUEST['product_id']."',`sku`='".$_REQUEST['sku']."',`order_id`='".$_REQUEST['order_id']."',`sending_date`='".$_REQUEST['sending_date'][$i]."',`reciving_date`='".$_REQUEST['reciving_date'][$i]."',`unique_stitching_id`='".$unique_stitching_id."' ,`comment_date`='".date("Y-m-d H:i:s")."'";
			mysql_query($sqlcmnt) or die("ERROR41::".mysql_error());
			
			//}
			}
		}
}
		
		header('Location:'.$_SERVER['HTTP_REFERER']);
	}
	
	
	
	
	
} else {
	
	header('Location:http://www.sareees.com/admin');
   // echo 'Go away!';
}	
?>