<?php
class Inchoo_Orders_Block_Adminhtml_Sales_Order_Grid_Renderer_Sku extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
 
 



public function render(Varien_Object $row)
{
	 $collection = Mage::getResourceModel('sales/order_collection')
	 ->addExpressionFieldToSelect(
                'products',
                '(SELECT GROUP_CONCAT(\' \', x.sku)
                    FROM sales_flat_order_item x
                    WHERE {{entity_id}} = x.order_id
                        AND x.product_type != \'configurable\')',
                array('entity_id' => 'main_table.entity_id')
            );
		$sku=$collection->getData();
		print_r($sku[1]['products']);exit();
	return $collection;

}

/*
public function render(Varien_Object $row)
{
echo 'ddd'.$value =  $row->getData($this->getColumn()->getIndex()); 


return '<span style="color:red;">'.$value.'</span>';
 
}*/
 
}
?>