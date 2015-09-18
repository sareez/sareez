<?php
class Sn_Sorder_Block_Adminhtml_Sorder_Grid_Renderer_Tailormaster extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
 
 


public function render(Varien_Object $row)
{
	 $value = $row->getData('tailormaster_id');
	$tailormaster = Mage::getModel('tailormaster/tailormaster');
		$tailormaster11 = $tailormaster->load($value); 
		
		
		
	
	return $tailormaster11['tailorname'];

}

/*
public function render(Varien_Object $row)
{
echo 'ddd'.$value =  $row->getData($this->getColumn()->getIndex()); 


return '<span style="color:red;">'.$value.'</span>';
 
}*/
 
}
?>