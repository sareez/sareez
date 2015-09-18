<?php
class Sn_Sorder_Block_Adminhtml_Sorder_Grid_Renderer_Manufacturers extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
 
 


 public function render(Varien_Object $row)
    {  
	
		echo $value = $row->getData('stitchingstatus_id');  
	$stitchingstatus = Mage::getModel('stitchingstatus/stitchingstatus')
      ->getCollection()
      ->addAttributeToSelect('*');
	  print_r('chinmay'.$stitchingstatus->getData());exit;
	  
	  
		return $stitchingstatus;
    }

 
}
?>