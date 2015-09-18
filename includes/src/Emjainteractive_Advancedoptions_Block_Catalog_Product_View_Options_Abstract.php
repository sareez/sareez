<?php

abstract class Emjainteractive_Advancedoptions_Block_Catalog_Product_View_Options_Abstract extends Mage_Core_Block_Template
{
    /**
     * Product object
     *
     * @var Mage_Catalog_Model_Product
     */
    protected $_product;

    /**
     * Product option object
     *
     * @var Mage_Catalog_Model_Product_Option
     */
    protected $_option;

    /**
     * Set Product object
     *
     * @param Mage_Catalog_Model_Product $product
     * @return Mage_Catalog_Block_Product_View_Options_Abstract
     */
    public function setProduct(Mage_Catalog_Model_Product $product = null)
    {
        $this->_product = $product;
        return $this;
    }

    /**
     * Retrieve Product object
     *
     * @return Mage_Catalog_Model_Product
     */
    public function getProduct()
    {
        return $this->_product;
    }

    /**
     * Set option
     *
     * @param Mage_Catalog_Model_Product_Option $option
     * @return Mage_Catalog_Block_Product_View_Options_Abstract
     */
    public function setOption(Mage_Catalog_Model_Product_Option $option)
    {
        $this->_option = $option;
        return $this;
    }

    /**
     * Get option
     *
     * @return Mage_Catalog_Model_Product_Option
     */
    public function getOption()
    {
        return $this->_option;
    }

    public function getFormatedPrice()
    {
        if ($option = $this->getOption()) {
            return $this->_formatPrice(array(
                'is_percent' => ($option->getPriceType() == 'percent') ? true : false,
                'pricing_value' => $option->getPrice(true)
            ));
        }
        return '';
    }

    /**
     * Return formated price
     *
     * @param array $value
     * @return string
     */
    protected function _formatPrice($value, $flag=true)
    {
        if ($value['pricing_value'] == 0) {
            return '';
        }
        $sign = '+';
        if ($value['pricing_value'] < 0) {
            $sign = '-';
            $value['pricing_value'] = 0 - $value['pricing_value'];
        }
        $priceStr = $sign;
        $_priceInclTax = $this->getPrice($value['pricing_value'], true);
        $_priceExclTax = $this->getPrice($value['pricing_value']);
        if (Mage::helper('tax')->displayPriceIncludingTax()) {
            $priceStr .= $this->helper('core')->currency($_priceInclTax, true, $flag);
        } elseif (Mage::helper('tax')->displayPriceExcludingTax()) {
            $priceStr .= $this->helper('core')->currency($_priceExclTax, true, $flag);
        } elseif (Mage::helper('tax')->displayBothPrices()) {
            $priceStr .= $this->helper('core')->currency($_priceExclTax, true, $flag);
            if ($_priceInclTax != $_priceExclTax) {
                $priceStr .= ' ('.$sign.$this->helper('core')
                    ->currency($_priceInclTax, true, $flag).' '.$this->__('Incl. Tax').')';
            }
        }

        if ($flag) {
            $priceStr = '<span class="price-notice">'.$priceStr.'</span>';
        }

        return $priceStr;
    }

    /**
     * Get price with including/excluding tax
     *
     * @param decimal $price
     * @param bool $includingTax
     * @return decimal
     */
    public function getPrice($price, $includingTax = null)
    {
        if (!is_null($includingTax)) {
            $price = Mage::helper('tax')->getPrice($this->getProduct(), $price, true);
        } else {
            $price = Mage::helper('tax')->getPrice($this->getProduct(), $price);
        }
        return $price;
    }
}
