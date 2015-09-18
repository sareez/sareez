<?php
class Sn_Sorder_Block_Adminhtml_Sorder_Grid_Renderer_Orderid extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
 


 public function render(Varien_Object $row)
    {  
	 $today = date("Y-m-d 23:59:59");
$value = $row->getData('increment_order_id');
$shipping_method = $row->getData('shipping_method');

$connection = Mage::getSingleton('core/resource')->getConnection('core_read');

//$sql = "SELECT `order_id` FROM  `sales_flat_order_item_stitching` WHERE `increment_order_id`='".$value."'";
$sql = "SELECT SUM(  `qty` ) as qtyo FROM  `sales_flat_order_item_stitching` WHERE  `increment_order_id` ='".$value."'";

//echo $sql."==KK";
$rows = $connection->fetchAll($sql);
//$tot_order_qty_stitching = count($rows);
$tot_order_qty_stitching = $rows[0]['qtyo'];

//$order_id = $rows[0]['order_id'];
$order_id = $row->getData('order_id');

$sql1 = "SELECT SUM(  `qty_ordered` ) as qty FROM  `sales_flat_order_item` WHERE  `order_id` ='".$order_id."'";
//echo $sql1."==KK";
$rows1 = $connection->fetchAll($sql1);
$tot_order_qty = $rows1[0]['qty'];

$color = '';
if($tot_order_qty_stitching <> $tot_order_qty){
	$color1 = 'style="color:red;text-decoration:blink;font-weight:bold;text-decoration:blink;"';
	return $value.'<p '.$color1.'> Qty Diff. </p> ';

}
else {
return $value ;	
	}
 }

 
}
?>