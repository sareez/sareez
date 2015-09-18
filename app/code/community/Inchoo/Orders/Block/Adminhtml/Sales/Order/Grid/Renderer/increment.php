<?php
class Inchoo_Orders_Block_Adminhtml_Sales_Order_Grid_Renderer_Increment extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
 
 


public function render(Varien_Object $row)
{
	$test=$this->getColumn()->getIndex();
	echo 'ddd'.$value = $row->getData($test);
	return $value;

}

/*
public function render(Varien_Object $row)
{
echo 'ddd'.$value =  $row->getData($this->getColumn()->getIndex()); 


return '<span style="color:red;">'.$value.'</span>';
 
}*/
 
}
?>