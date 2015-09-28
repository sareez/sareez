<?php
require_once 'app/Mage.php';
Mage::app();
$to = 250;

 $_productCollection = Mage::getModel('catalog/product')->getCollection();
    $_productCollection->addAttributeToSelect('*')
                        ->addFieldToFilter('visibility', array(
                                    Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH
                                   // Mage_Catalog_Model_Product_Visibility::VISIBILITY_IN_CATALOG
                            )) //showing just products visible in catalog or both search and catalog
						->addFieldToFilter('exprees_shipping_available', array('eq' => '33'))
						->joinField('qty',
									 'cataloginventory/stock_item',
									 'qty',
									 'product_id=entity_id',
									 '{{table}}.stock_id=1',
									 'left')
						 ->addAttributeToFilter('qty', array("lt" => 1))
						 ->addAttributeToFilter('status',array('eq' => Mage_Catalog_Model_Product_Status::STATUS_ENABLED));
?>
<table border="1"> 
<?php 
foreach($_productCollection as $_product) {
	?>
   <tr>
   <td>
	<?php echo $sku = $_product->getSku(); ?>
    </td> 
    <td>
	<?php echo $exprees_shipping_available = $_product->getAttributeText('exprees_shipping_available'); ?>
    </td>
    <td>
    <?php echo $qtyp = $_product->getQty(); ?>
    </td>
  </tr>
  <?php
}
?>
<tr><td>Total Products : </td><td colspan="2"><?php echo count($_productCollection); ?> </td></tr>
</table>