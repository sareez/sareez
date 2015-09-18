<?php

class Emjainteractive_Advancedoptions_Block_Catalog_Product_View_Options extends Mage_Catalog_Block_Product_View_Options
{
    protected $_options = null;



    public function getOptionHtml(Mage_Catalog_Model_Product_Option $option)
    {
        $renderer = $this->getOptionRender(
            $this->getGroupOfOption($option->getType())
        );
        if (is_null($renderer['renderer'])) {
            $renderer['renderer'] = $this->getLayout()->createBlock($renderer['block'])
                ->setTemplate($renderer['template']);
        }
        return $renderer['renderer']
            ->setProduct($this->getProduct())
            ->setQuoteItem($this->getQuoteItem())
            ->setOption($option)
            ->toHtml();
    }

    protected function _getValuePrice($value, $flag)
    {
        if ($flag && $value->getPriceType() == 'percent') {
            $basePrice = $value->getOption()->getProduct()->getFinalPrice($this->getQuoteItem()->getQty());
            $price = $basePrice*($value->_getData('price')/100);
            return $price;
        }
        return $value->_getData('price');
    }

    protected function _getOptionPrice($option, $flag)
    {
        if ($flag && $option->getPriceType() == 'percent') {
            $basePrice = $option->getProduct()->getFinalPrice();
            $price = $basePrice*($option->_getData('price')/100);
            return $price;
        }
        return $option->_getData('price');
    }

    public function getJsonConfig()
    {
        $config = array();

        foreach ($this->getOptions() as $option) {
            /* @var $option Mage_Catalog_Model_Product_Option */
            $priceValue = 0;
            if ($option->getGroupByType() == Mage_Catalog_Model_Product_Option::OPTION_GROUP_SELECT) {
                $_tmpPriceValues = array();
                foreach ($option->getValues() as $value) {
                    /* @var $value Mage_Catalog_Model_Product_Option_Value */
                   $_tmpPriceValues[$value->getId()] = Mage::helper('core')->currency($this->_getValuePrice($value,true), false, false);
                }
                $priceValue = $_tmpPriceValues;
            } else {
                $priceValue = Mage::helper('core')->currency($this->_getOptionPrice($option, true), false, false);
            }
            $config[$option->getId()] = $priceValue;
        }

        return Mage::helper('core')->jsonEncode($config);
    }


    public function getOptions()
    {
        if (is_null($this->_options)) {
            $this->_options = array();
            foreach ($this->getProduct()->getOptions() as $_option) {
                $_option->setProduct($this->getProduct());
                $this->_options[$_option->getSortOrder()] = $_option;
            }
            ksort($this->_options);
        }
        return $this->_options;
    }
    
}
