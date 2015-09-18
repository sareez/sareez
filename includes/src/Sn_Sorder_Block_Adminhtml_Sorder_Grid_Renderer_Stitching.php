<?php
class Sn_Sorder_Block_Adminhtml_Sorder_Grid_Renderer_Stitching extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
 
 


public function render(Varien_Object $row)
{
	 $value = $row->getData('id');
	
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