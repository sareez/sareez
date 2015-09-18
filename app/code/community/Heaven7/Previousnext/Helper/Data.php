<?php
class Heaven7_Previousnext_Helper_Data extends Mage_Core_Helper_Abstract
{
	/**
	 * @return Mage_Catalog_Model_Product or FALSE
	 */
	public function getPreviousProduct()
	{
		$product_id = Mage::registry('current_product')->getId();
		if (method_exists(Mage::registry('current_category'), 'getId')
                && method_exists(Mage::getResourceModel('catalog/category'), 'getProductsPosition')) {
            $category = new Varien_Object(array('id'=>Mage::registry('current_category')->getId()));
			$positions = array_reverse(array_keys(Mage::getResourceModel('catalog/category')->getProductsPosition($category)));
		} else{
			return false;
		}
		$cpk = @array_search($product_id, $positions);
		$slice = array_reverse(array_slice($positions, 0, $cpk));
		foreach ($slice as $productId) {
			$product = Mage::getModel('catalog/product')
				->load($productId);
			if ($product && $product->getId() && $product->isVisibleInCatalog() && $product->isVisibleInSiteVisibility()) {
				return $product;
			}
		}
		return false;
	}
	/**
	 * @return Mage_Catalog_Model_Product or FALSE
	 */
	public function getNextProduct()
	{
		$product_id = Mage::registry('current_product')->getId();
        if (method_exists(Mage::registry('current_category'), 'getId')
                && method_exists(Mage::getResourceModel('catalog/category'), 'getProductsPosition')) {
            $category = new Varien_Object(array('id'=>Mage::registry('current_category')->getId()));
            $positions = array_reverse(array_keys(Mage::getResourceModel('catalog/category')->getProductsPosition($category)));
        } else{
            return false;
        }
		$cpk = @array_search($product_id, $positions);
		$slice = array_slice($positions, $cpk + 1, count($positions));
		foreach ($slice as $productId) {
			$product = Mage::getModel('catalog/product')
				->load($productId);
			if ($product && $product->getId() && $product->isVisibleInCatalog() && $product->isVisibleInSiteVisibility()) {
				return $product;
			}
		}
		return false;
	}
}
	 