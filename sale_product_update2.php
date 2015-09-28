<?php
// Added OsCommerce Order ID into Magento Order Table
//ALTER TABLE `sales_flat_order_grid` ADD `osc_order_id` INT(15) NOT NULL AFTER `increment_id`;
require_once 'app/Mage.php';
Mage::app();

//  COPY Products From => To
//  5 => 10
//$from = 5;
$to = 250;

 $_productCollection = Mage::getModel('catalog/product')->getCollection();
    $_productCollection->addAttributeToSelect(array(
                                   
                                   'name'
                                   
                                              ))
                        //->addFieldToFilter('visibility', array(
                                    //Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH,
                                    //Mage_Catalog_Model_Product_Visibility::VISIBILITY_IN_CATALOG
                           //)) //showing just products visible in catalog or both search and catalog
                        ->addFinalPrice()
//                        ->addAttributeToSort('price', 'asc') //in case we would like to sort products by price
                        ->getSelect()
                        ->where('price_index.final_price < price_index.price')
//                        ->limit(30) //we specify how many products we want to show on this page
//                        ->order(new Zend_Db_Expr('RAND()')) //in case we would like to sort products randomly
                        ;
 
 
 
 
//$category = Mage::getModel('catalog/category')->load($from);
 
//$productCollection = $category->setStoreId(1)->getProductCollection();
echo count($_productCollection);

echo 'Completed Execution!!!';
?>