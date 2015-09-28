<?php
require_once 'app/Mage.php';
Mage::app();
// Added OsCommerce Order ID into Magento Order Table
//ALTER TABLE `sales_flat_order_grid` ADD `osc_order_id` INT(15) NOT NULL AFTER `increment_id`; 

$x=0;
//for($i=64642; $i<=64765; $i++){
for($i=64943; $i<=65000; $i++){

$product = Mage::getModel('catalog/product')->load($i);
$categoryIds = $product->getCategoryIds();

// For Fabric Attribute only

// Sareez Start========================

$Fabric='';
if(in_array('122',$categoryIds)){
		$Fabric = $Fabric.",44";
}

if(in_array('121',$categoryIds)){
		$Fabric = $Fabric.",50";
}

if(in_array('123',$categoryIds)){
		$Fabric = $Fabric.",37";
}

if(in_array('124',$categoryIds)){
		$Fabric = $Fabric.",61";
}

if(in_array('125',$categoryIds)){
		$Fabric = $Fabric.",42";
}

if(in_array('126',$categoryIds)){
		$Fabric = $Fabric.",67";
}

if(in_array('127',$categoryIds)){
		$Fabric = $Fabric.",51";
}

if(in_array('128',$categoryIds)){
		$Fabric = $Fabric.",63";
}

if(in_array('129',$categoryIds)){
		$Fabric = $Fabric.",69";
}

if(in_array('130',$categoryIds)){
		$Fabric = $Fabric.",47";
}

if(in_array('131',$categoryIds)){
		$Fabric = $Fabric.",53";
}

if(in_array('132',$categoryIds)){
		$Fabric = $Fabric.",56";
}

if(in_array('133',$categoryIds)){
		$Fabric = $Fabric.",38";
}

if(in_array('134',$categoryIds)){
		$Fabric = $Fabric.",57";
}

if(in_array('135',$categoryIds)){
		$Fabric = $Fabric.",70";
}

if(in_array('136',$categoryIds)){
		$Fabric = $Fabric.",59";
}

if(in_array('137',$categoryIds)){
		$Fabric = $Fabric.",48";
}

if(in_array('138',$categoryIds)){
		$Fabric = $Fabric.",68";
}

if(in_array('139',$categoryIds)){
		$Fabric = $Fabric.",65";
}

if(in_array('140',$categoryIds)){
		$Fabric = $Fabric.",64";
}

// Sareez End========================

// Salowar Start=====================

if(in_array('58',$categoryIds)){
		$Fabric = $Fabric.",52";
}

if(in_array('59',$categoryIds)){
		$Fabric = $Fabric.",46";
}

if(in_array('60',$categoryIds)){
		$Fabric = $Fabric.",54";	
}

if(in_array('61',$categoryIds)){
		$Fabric = $Fabric.",43";	
}

if(in_array('62',$categoryIds)){
		$Fabric = $Fabric.",66";	
}

if(in_array('63',$categoryIds)){
		$Fabric = $Fabric.",41";	
}

if(in_array('64',$categoryIds)){
		$Fabric = $Fabric.",36";	
}

if(in_array('65',$categoryIds)){
		$Fabric = $Fabric.",55";	
}

if(in_array('66',$categoryIds)){
		$Fabric = $Fabric.",60";	
}

if(in_array('67',$categoryIds)){
		$Fabric = $Fabric.",57";	
}

if(in_array('68',$categoryIds)){
		$Fabric = $Fabric.",39";	
}

if(in_array('69',$categoryIds)){
		$Fabric = $Fabric.",70";	
}

if(in_array('70',$categoryIds)){
		$Fabric = $Fabric.",40";	
}

if(in_array('71',$categoryIds)){
		$Fabric = $Fabric.",69";	
}

if(in_array('72',$categoryIds)){
		$Fabric = $Fabric.",65";	
}

if(in_array('73',$categoryIds)){
		$Fabric = $Fabric.",45";	
}

if(in_array('74',$categoryIds)){
		$Fabric = $Fabric.",49";	
}

if(in_array('75',$categoryIds)){
		$Fabric = $Fabric.",58";	
}

if(in_array('76',$categoryIds)){ 
		$Fabric = $Fabric.",62";	
}

// End Salowar=========================

//  Start Legengas

if(in_array('5',$categoryIds)){ 
		$Fabric = $Fabric.",165";	
}

if(in_array('6',$categoryIds)){ 
		$Fabric = $Fabric.",164";	
}

if(in_array('7',$categoryIds)){ 
		$Fabric = $Fabric.",163";	
}

if(in_array('8',$categoryIds)){ 
		$Fabric = $Fabric.",162";	
}

if(in_array('9',$categoryIds)){ 
		$Fabric = $Fabric.",177";	
}

if(in_array('10',$categoryIds)){ 
		$Fabric = $Fabric.",161";	
}

if(in_array('11',$categoryIds)){ 
		$Fabric = $Fabric.",57";	
}

if(in_array('12',$categoryIds)){ 
		$Fabric = $Fabric.",176";	
}

// End Lahenga

$Fabric = ltrim($Fabric,',');
//$allIds = "'".$Fabric."'"; 
//echo $allIds; //die;

$product->setFabric($Fabric);
//$product->save();




//=======Start Sareez Occation===========================
$Occasion='';
if(in_array('142',$categoryIds)){ 
		$Occasion = $Occasion.",13";	
}

if(in_array('143',$categoryIds)){ 
		$Occasion = $Occasion.",9";
}

if(in_array('144',$categoryIds)){ 
		$Occasion = $Occasion.",15";	
}

if(in_array('145',$categoryIds)){ 
		$Occasion = $Occasion.",17";	
}

if(in_array('146',$categoryIds)){ 
		$Occasion = $Occasion.",11";	
}

//=======End Sareez Occation===========================

//=======Start Lahenga Occation===========================

if(in_array('14',$categoryIds)){ 
		$Occasion = $Occasion.",175";	
}

if(in_array('15',$categoryIds)){ 
		$Occasion = $Occasion.",174";	
}

if(in_array('16',$categoryIds)){ 
		$Occasion = $Occasion.",173";	
}

if(in_array('17',$categoryIds)){ 
		$Occasion = $Occasion.",172";	
}
//=======End Lahenga Occation===========================

//=======Start Salowar Occation===========================

if(in_array('78',$categoryIds)){ 
		$Occasion = $Occasion.",14";	
}

if(in_array('79',$categoryIds)){ 
		$Occasion = $Occasion.",16";	
}

if(in_array('80',$categoryIds)){ 
		$Occasion = $Occasion.",10";	
}

if(in_array('81',$categoryIds)){ 
		$Occasion = $Occasion.",12";	
}

//=======End Salowar Occation===========================
//=======Start Serwani Occation===========================

if(in_array('162',$categoryIds)){ 
		$Occasion = $Occasion.",171";	
}

if(in_array('163',$categoryIds)){ 
		$Occasion = $Occasion.",170";	
}

if(in_array('164',$categoryIds)){ 
		$Occasion = $Occasion.",169";	
}

//=======End Serwani Occation===========================

//=======Start Jewellary Occation===========================

if(in_array('181',$categoryIds)){ 
		$Occasion = $Occasion.",168";	
}

if(in_array('182',$categoryIds)){ 
		$Occasion = $Occasion.",167";	
}

if(in_array('183',$categoryIds)){ 
		$Occasion = $Occasion.",166";	
}

//=======End Jewellary Occation===========================

$Occasion = ltrim($Occasion,',');

$product->setByOccasion($Occasion);
//$product->save();




//=======Start Sarees By Work===========================
$ByType='';
if(in_array('148',$categoryIds)){ 
		$ByType = $ByType.",18";
}

if(in_array('149',$categoryIds)){ 
		$ByType = $ByType.",25";	
}

if(in_array('150',$categoryIds)){ 
		$ByType = $ByType.",20";	
}

if(in_array('151',$categoryIds)){ 
		$ByType = $ByType.",22";	
}

if(in_array('152',$categoryIds)){ 
		$ByType = $ByType.",29";	
}

if(in_array('153',$categoryIds)){ 
		$ByType = $ByType.",26";	
}

//=======End Sarees By Work===========================

//=======Start Salwar  By Work===========================
if(in_array('83',$categoryIds)){ 
		$ByType = $ByType.",24";	
}

if(in_array('84',$categoryIds)){ 
		$ByType = $ByType.",31";	
}

if(in_array('85',$categoryIds)){ 
		$ByType = $ByType.",21";	
}

if(in_array('86',$categoryIds)){ 
		$ByType = $ByType.",28";	
}

//=======End Salwar  By Work===========================

//=======Start Serwani  By Work===========================
if(in_array('159',$categoryIds)){ 
		$ByType = $ByType.",27";	
}

if(in_array('160',$categoryIds)){ 
		$ByType = $ByType.",19";	
}

if(in_array('217',$categoryIds)){ 
		$ByType = $ByType.",23";	
}

if(in_array('218',$categoryIds)){ 
		$ByType = $ByType.",30";	
}


//=======End Serwani  By Work===========================
$ByType = ltrim($ByType,',');

$product->setByType($ByType);



//=======Start jewellery type===========================
$JewelleryType='';
if(in_array('190',$categoryIds)){  // Necklace Sets
		$JewelleryType = $JewelleryType.",202";	
}

if(in_array('191',$categoryIds)){  //Bangles & Bracelets
		$JewelleryType = $JewelleryType.",205";	
}

if(in_array('192',$categoryIds)){  //Earrings 
		$JewelleryType = $JewelleryType.",204";	
}

if(in_array('193',$categoryIds)){  // Rings 
		$JewelleryType = $JewelleryType.",203";	
}

//=======End jewellery type===========================
$JewelleryType = ltrim($JewelleryType,',');
$product->setJewelleryType($JewelleryType);


//=======Start Sareez Color===========================
$Color='';
if(in_array('98',$categoryIds)){  
		$Color = $Color.",97";	
}

if(in_array('99',$categoryIds)){  
		$Color = $Color.",112";	
}

if(in_array('100',$categoryIds)){  
		$Color = $Color.",124";	
}

if(in_array('101',$categoryIds)){  
		$Color = $Color.",118";	
}

if(in_array('102',$categoryIds)){  
		$Color = $Color.",88";	
}

if(in_array('103',$categoryIds)){  
		$Color = $Color.",32542";	
}

if(in_array('104',$categoryIds)){  
		$Color = $Color.",86";	
}

if(in_array('105',$categoryIds)){  
		$Color = $Color.",85";	
}

if(in_array('106',$categoryIds)){  
		$Color = $Color.",96";	
}

if(in_array('107',$categoryIds)){  
		$Color = $Color.",32527";	
}

if(in_array('108',$categoryIds)){  
		$Color = $Color.",82";	
}

if(in_array('109',$categoryIds)){  
		$Color = $Color.",91";	
}

if(in_array('110',$categoryIds)){  
		$Color = $Color.",89";	
}

if(in_array('111',$categoryIds)){  
		$Color = $Color.",136";	
}

if(in_array('112',$categoryIds)){  
		$Color = $Color.",101";	
}

if(in_array('113',$categoryIds)){  
		$Color = $Color.",93";	
}

if(in_array('114',$categoryIds)){  
		$Color = $Color.",117";	
}

if(in_array('115',$categoryIds)){  
		$Color = $Color.",119";	
}

if(in_array('116',$categoryIds)){  
		$Color = $Color.",92";	
}

if(in_array('117',$categoryIds)){  
		$Color = $Color.",115";	
}

if(in_array('118',$categoryIds)){  
		$Color = $Color.",95";	
}

if(in_array('119',$categoryIds)){  
		$Color = $Color.",81";	
}

//=======End Sareez Color ===========================


//=======Start Salowar Color===========================
if(in_array('35',$categoryIds)){  
		$Color = $Color.",88";	
}

if(in_array('36',$categoryIds)){  
		$Color = $Color.",118";	
}

if(in_array('37',$categoryIds)){  
		$Color = $Color.",98";	
}

if(in_array('38',$categoryIds)){  
		$Color = $Color.",97";	
}

if(in_array('39',$categoryIds)){  
		$Color = $Color.",32542";	
}

if(in_array('40',$categoryIds)){  
		$Color = $Color.",86";	
}

if(in_array('41',$categoryIds)){  
		$Color = $Color.",85";	
}

if(in_array('42',$categoryIds)){  
		$Color = $Color.",96";	
}

if(in_array('43',$categoryIds)){  
		$Color = $Color.",32527";	
}

if(in_array('44',$categoryIds)){  
		$Color = $Color.",82";	
}

if(in_array('45',$categoryIds)){  
		$Color = $Color.",91";	
}

if(in_array('46',$categoryIds)){  
		$Color = $Color.",89";	
}

if(in_array('47',$categoryIds)){  
		$Color = $Color.",136";	
}

if(in_array('48',$categoryIds)){  
		$Color = $Color.",101";	
}

if(in_array('49',$categoryIds)){  
		$Color = $Color.",93";	
}

if(in_array('50',$categoryIds)){  
		$Color = $Color.",117";	
}

if(in_array('51',$categoryIds)){  
		$Color = $Color.",119";	
}

if(in_array('52',$categoryIds)){  
		$Color = $Color.",92";	
}

if(in_array('53',$categoryIds)){  
		$Color = $Color.",115";	
}

if(in_array('54',$categoryIds)){  
		$Color = $Color.",95";	
}

if(in_array('55',$categoryIds)){  
		$Color = $Color.",81";	
}

if(in_array('56',$categoryIds)){  
		$Color = $Color.",112";	
}

//=======End Salowar Color ===========================

$Color = ltrim($Color,',');
$product->setColor($Color);
$product->save();

$x++;

}

echo $x.":: Rows Updated.";
?>