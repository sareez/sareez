<?php
class Sn_Sorder_Block_Adminhtml_Sorder_Grid_Renderer_Shippingmethod extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
 
 


 public function render(Varien_Object $row)
    {  
	 $today = date("Y-m-d 23:59:59");
$value = $row->getData('increment_order_id');
$shipping_method = $row->getData('shipping_method');


if($shipping_method=='flatrate_flatrate'){
	$shipping_method = '<div style="color:#000;font-weight:bold;background:#FF00FF;border-radius:8px;padding:3px;">Separate Shipping</div>';
}


return '<div '.$color.'>'.$shipping_method.'</div> ';
 }

 
}
?>