<?php
/**
* @copyright Amasty.
*/ 
class Amasty_Shopby_Helper_Image extends Mage_Catalog_Helper_Image
{
    protected $requestConfigurableMap;

    public function setProduct($product)
    {
        if (!isset($this->requestConfigurableMap)) {
            $this->computeRequestConfigurableMap();
        }

        if ($this->requestConfigurableMap && $product->isConfigurable() && $product->isSaleable()) {
            $children = $this->getPossibleSimpleProducts($product);
            foreach ($children as $childProduct) {
                if ($this->matchProduct($childProduct)) {
                    $product = $childProduct;
                    $product->load($product->getId());
                    break;
                }
            }
        }
        parent::setProduct($product);
    }

    /**
     * @param Mage_Catalog_Model_Product $product
     * @return Mage_Catalog_Model_Product[]
     */
    protected function getPossibleSimpleProducts($product)
    {
        /** @var Mage_Catalog_Model_Product_Type_Configurable $productTypeIns */
        $productTypeIns = $product->getTypeInstance(true);
        $children = $productTypeIns->getUsedProductCollection($product);
        $children->addAttributeToSelect('thumbnail');
        foreach (array_keys($this->requestConfigurableMap) as $code) {
            $children->addAttributeToSelect($code);
        }
        return $children;
    }

    /**
     * @param Mage_Catalog_Model_Product $product
     * @return bool
     */
    protected function matchProduct($product)
    {
        foreach ($this->requestConfigurableMap as $code => $values) {
            if (!in_array($product->getData($code), $values)) {
                return false;
            }
        }
        return true;
    }

    protected function computeRequestConfigurableMap()
    {
        $this->requestConfigurableMap = array();
        $configurableCodes = explode(",", trim(Mage::getStoreConfig('amshopby/general/configurable_images')));
        $requestParams = Mage::app()->getRequest()->getQuery();
        $inRequestConfigurableCodes = array_intersect($configurableCodes, array_keys($requestParams));

        foreach ($inRequestConfigurableCodes as $code) {
            $value = $requestParams[$code];
            if (strpos($value, ",") !== false) {
                $values = explode(",", $value);
            } else {
                $values = array($value);
            }

            $this->requestConfigurableMap[$code] = $values;
        }
    }
}
