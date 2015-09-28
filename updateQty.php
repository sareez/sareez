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

	
} else {
	
	header('Location:http://www.sareees.com/admin');
   // echo 'Go away!';
}	
?>