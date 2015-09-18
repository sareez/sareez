<?php
class Sn_Sorder_Block_Adminhtml_Sorder_Grid_Renderer_Catalogmaster extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
 
 



 public function render(Varien_Object $row)
    {  
	
		echo $value = $row->getData('product_id');  
		$modelqq = Mage::getModel('catalog/product');
		$_product = $modelqq->load($value); 
		$catmcId = $_product->getCatalogmasterId();
		//print_r('chinmay'.$_product);exit;
		return $catmcId;
    }


/*
public function render(Varien_Object $row)
{
echo 'ddd'.$value =  $row->getData($this->getColumn()->getIndex()); 


return '<span style="color:red;">'.$value.'</span>';
 
}*/
 
}
?>