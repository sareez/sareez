<?php
require_once 'app/Mage.php';
Mage::app();
// Added OsCommerce Order ID into Magento Order Table
//ALTER TABLE `sales_flat_order_grid` ADD `osc_order_id` INT(15) NOT NULL AFTER `increment_id`;

/*$host = "localhost";
$user = "root";
$pwd = "rootwdp";
$dbname = "sareez_db_bk";

$conn = mysql_connect("$host","$user","$pwd") or die("ERROR::Not connected to SERVER");	
$db = mysql_select_db("$dbname",$conn) or die("ERROR::Not connected to DATABASE");*/


for($i=1; $i<=2; $i++){

//$product = Mage::getModel('catalog/product')->loadByAttribute('product_id', $i);
$product = Mage::getModel('catalog/product')->load($i);
$categoryIds = $product->getCategoryIds();
//echo '<pre>'; print_r($categoryIds); die;

// For Fabric Attribute only

// Sareez Start========================

if(in_array('122',$categoryIds)){
        $product->setFabric('44');
		$product->save();	
}

if(in_array('121',$categoryIds)){
        $product->setFabric('50');
		$product->save();	
}

if(in_array('123',$categoryIds)){
        $product->setFabric('37');
		$product->save();	
}

if(in_array('124',$categoryIds)){
        $product->setFabric('61');
		$product->save();	
}

if(in_array('125',$categoryIds)){
        $product->setFabric('42');
		$product->save();	
}

if(in_array('126',$categoryIds)){
        $product->setFabric('67');
		$product->save();	
}

if(in_array('127',$categoryIds)){
        $product->setFabric('51');
		$product->save();	
}

if(in_array('128',$categoryIds)){
        $product->setFabric('63');
		$product->save();	
}

if(in_array('129',$categoryIds)){
        $product->setFabric('69');
		$product->save();	
}

if(in_array('130',$categoryIds)){
        $product->setFabric('47');
		$product->save();	
}

if(in_array('131',$categoryIds)){
        $product->setFabric('53');
		$product->save();	
}

if(in_array('132',$categoryIds)){
        $product->setFabric('56');
		$product->save();	
}

if(in_array('133',$categoryIds)){
        $product->setFabric('38');
		$product->save();	
}

if(in_array('134',$categoryIds)){
        $product->setFabric('57');
		$product->save();	
}

if(in_array('135',$categoryIds)){
        $product->setFabric('70');
		$product->save();	
}

if(in_array('136',$categoryIds)){
        $product->setFabric('59');
		$product->save();	
}

if(in_array('137',$categoryIds)){
        $product->setFabric('48');
		$product->save();	
}

if(in_array('138',$categoryIds)){
        $product->setFabric('68');
		$product->save();	
}

if(in_array('139',$categoryIds)){
        $product->setFabric('65');
		$product->save();	
}

if(in_array('140',$categoryIds)){
        $product->setFabric('64');
		$product->save();	
}

// Sareez End========================

// Salowar Start=====================

if(in_array('58',$categoryIds)){
        $product->setFabric('52');
		$product->save();	
}

if(in_array('59',$categoryIds)){
        $product->setFabric('46');
		$product->save();	
}

if(in_array('60',$categoryIds)){
        $product->setFabric('54');
		$product->save();	
}

if(in_array('61',$categoryIds)){
        $product->setFabric('43');
		$product->save();	
}

if(in_array('62',$categoryIds)){
        $product->setFabric('66');
		$product->save();	
}

if(in_array('63',$categoryIds)){
        $product->setFabric('41');
		$product->save();	
}

if(in_array('64',$categoryIds)){
        $product->setFabric('36');
		$product->save();	
}

if(in_array('65',$categoryIds)){
        $product->setFabric('55');
		$product->save();	
}

if(in_array('66',$categoryIds)){
        $product->setFabric('60');
		$product->save();	
}

if(in_array('67',$categoryIds)){
        $product->setFabric('57');
		$product->save();	
}

if(in_array('68',$categoryIds)){
        $product->setFabric('39');
		$product->save();	
}

if(in_array('69',$categoryIds)){
        $product->setFabric('70');
		$product->save();	
}

if(in_array('70',$categoryIds)){
        $product->setFabric('40');
		$product->save();	
}

if(in_array('71',$categoryIds)){
        $product->setFabric('69');
		$product->save();	
}

if(in_array('72',$categoryIds)){
        $product->setFabric('65');
		$product->save();	
}

if(in_array('73',$categoryIds)){
        $product->setFabric('45');
		$product->save();	
}

if(in_array('74',$categoryIds)){
        $product->setFabric('49');
		$product->save();	
}

if(in_array('75',$categoryIds)){
        $product->setFabric('58');
		$product->save();	
}

if(in_array('76',$categoryIds)){ 
        $product->setFabric('62');
		$product->save();	
}

// End Salowar=========================

//  Start Legengas

if(in_array('5',$categoryIds)){ 
        $product->setFabric('165');
		$product->save();	
}

if(in_array('5',$categoryIds)){ 
        $product->setFabric('165');
		$product->save();	
}

if(in_array('6',$categoryIds)){ 
        $product->setFabric('164');
		$product->save();	
}

if(in_array('7',$categoryIds)){ 
        $product->setFabric('163');
		$product->save();	
}

if(in_array('8',$categoryIds)){ 
        $product->setFabric('162');
		$product->save();	
}

if(in_array('9',$categoryIds)){ 
        $product->setFabric('177');
		$product->save();	
}

if(in_array('10',$categoryIds)){ 
        $product->setFabric('161');
		$product->save();	
}

if(in_array('11',$categoryIds)){ 
        $product->setFabric('57');
		$product->save();	
}

if(in_array('12',$categoryIds)){ 
        $product->setFabric('176');
		$product->save();	
}

// End Lahenga

//=======Start Sareez Occation===========================

if(in_array('142',$categoryIds)){ 
        $product->setByOccasion('13');
		$product->save();	
}

if(in_array('143',$categoryIds)){ 
        $product->setByOccasion('9');
		$product->save();	
}

if(in_array('144',$categoryIds)){ 
        $product->setByOccasion('15');
		$product->save();	
}

if(in_array('145',$categoryIds)){ 
        $product->setByOccasion('17');
		$product->save();	
}

if(in_array('146',$categoryIds)){ 
        $product->setByOccasion('11');
		$product->save();	
}

//=======End Sareez Occation===========================

//=======Start Lahenga Occation===========================

if(in_array('14',$categoryIds)){ 
        $product->setByOccasion('175');
		$product->save();	
}

if(in_array('15',$categoryIds)){ 
        $product->setByOccasion('174');
		$product->save();	
}

if(in_array('16',$categoryIds)){ 
        $product->setByOccasion('173');
		$product->save();	
}

if(in_array('17',$categoryIds)){ 
        $product->setByOccasion('172');
		$product->save();	
}
//=======End Lahenga Occation===========================

//=======Start Salowar Occation===========================

if(in_array('78',$categoryIds)){ 
        $product->setByOccasion('14');
		$product->save();	
}

if(in_array('79',$categoryIds)){ 
        $product->setByOccasion('16');
		$product->save();	
}

if(in_array('80',$categoryIds)){ 
        $product->setByOccasion('10');
		$product->save();	
}

if(in_array('81',$categoryIds)){ 
        $product->setByOccasion('12');
		$product->save();	
}

//=======End Salowar Occation===========================
//=======Start Serwani Occation===========================

if(in_array('162',$categoryIds)){ 
        $product->setByOccasion('171');
		$product->save();	
}

if(in_array('163',$categoryIds)){ 
        $product->setByOccasion('170');
		$product->save();	
}

if(in_array('164',$categoryIds)){ 
        $product->setByOccasion('169');
		$product->save();	
}

//=======End Serwani Occation===========================

//=======Start Jewellary Occation===========================

if(in_array('181',$categoryIds)){ 
        $product->setByOccasion('168');
		$product->save();	
}

if(in_array('182',$categoryIds)){ 
        $product->setByOccasion('167');
		$product->save();	
}

if(in_array('183',$categoryIds)){ 
        $product->setByOccasion('166');
		$product->save();	
}

//=======End Jewellary Occation===========================



//=======Start Sarees By Work===========================
if(in_array('148',$categoryIds)){ 
        $product->setByType('18');
		$product->save();	
}

if(in_array('149',$categoryIds)){ 
        $product->setByType('25');
		$product->save();	
}

if(in_array('150',$categoryIds)){ 
        $product->setByType('20');
		$product->save();	
}

if(in_array('151',$categoryIds)){ 
        $product->setByType('22');
		$product->save();	
}

if(in_array('152',$categoryIds)){ 
        $product->setByType('29');
		$product->save();	
}

if(in_array('153',$categoryIds)){ 
        $product->setByType('26');
		$product->save();	
}

//=======End Sarees By Work===========================

//=======Start Salwar  By Work===========================
if(in_array('83',$categoryIds)){ 
        $product->setByType('24');
		$product->save();	
}

if(in_array('84',$categoryIds)){ 
        $product->setByType('31');
		$product->save();	
}

if(in_array('85',$categoryIds)){ 
        $product->setByType('21');
		$product->save();	
}

if(in_array('86',$categoryIds)){ 
        $product->setByType('28');
		$product->save();	
}

//=======End Salwar  By Work===========================

//=======Start Serwani  By Work===========================
if(in_array('159',$categoryIds)){ 
        $product->setByType('27');
		$product->save();	
}

if(in_array('160',$categoryIds)){ 
        $product->setByType('19');
		$product->save();	
}

if(in_array('217',$categoryIds)){ 
        $product->setByType('23');
		$product->save();	
}

if(in_array('218',$categoryIds)){ 
        $product->setByType('30');
		$product->save();	
}

//=======End Serwani  By Work===========================

//=======Start jewellery type===========================
if(in_array('190',$categoryIds)){  // Necklace Sets
        $product->setByType('202');
		$product->save();	
}

if(in_array('191',$categoryIds)){  //Bangles & Bracelets
        $product->setByType('205');
		$product->save();	
}

if(in_array('192',$categoryIds)){  //Earrings 
        $product->setByType('204');
		$product->save();	
}

if(in_array('193',$categoryIds)){  // Rings 
        $product->setByType('203');
		$product->save();	
}

//=======End jewellery type===========================
}

?>