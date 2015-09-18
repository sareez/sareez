<?php

class Emjainteractive_Advancedoptions_Model_Checkout_Cart_Observer
{

    /**
     * @throws Exception
     * @param Varien_Event_Observer
     * @return Emjainteractive_Advancedoptions_Model_Chekckout_Cart_Observer
     */
    public function updateCartOptions($observer)
    {
        $cart = $observer->getEvent()->getCart();
        $info = $observer->getEvent()->getInfo();

        if ($cart && $info) {
            foreach ($info as $itemId => $itemInfo) {
                $quoteItem = $cart->getQuote()->getItemById($itemId);
                if (!$quoteItem) {
                    continue;
                }

                if (isset($itemInfo['options']) && is_array($itemInfo['options'])) {
                    $options = $itemInfo['options'];
                    foreach ($options as $id => $value) {
                        $optionCode = 'option_' . $id;
                        $quoteItemOption = $quoteItem->getOptionByCode($optionCode);

                        if ($quoteItemOption && isset($options['removed']) && $options['removed']) {
                            $productOption = $quoteItem->getProduct()->getOptionById($id);
                            if (!$productOption->getIsRequire()) {
                                $this->_removeQuoteItemOption($quoteItem, $optionCode, $id);
                            }
                            continue;
                        }

                        $productOption = $quoteItem->getProduct()->getOptionById($id);
                        if ($productOption) {
                            if ($quoteItemOption && !$value) {
                                $this->_removeQuoteItemOption($quoteItem, $optionCode, $id);
                                continue;
                            }

                            $productOption->setProduct($quoteItem->getProduct());
                            $productOption->setRequest($options);
                            $value = $this->_prepareValue($value, $productOption);


                            if($quoteItemOption) {
                                $quoteItemOption->setValue($value);
                                continue;
                            }

                            if ($value) {
                                $this->_addQuoteItemOption($quoteItem, $optionCode, $id, $value);
                                continue;
                            }
                        }
                    }
                }
            }
        }
        return $this;
    }

    /**
     * Enter description here ...
     * @param unknown_type $quoteItem
     * @param unknown_type $optionCode
     * @param unknown_type $id
     */
    protected function _removeQuoteItemOption($quoteItem, $optionCode, $id)
    {
        $quoteItem->removeOption($optionCode);
        $optionIdsItem = $quoteItem->getOptionByCode('option_ids');
        $optionIds = $optionIdsItem->getValue();
        $optionIds = explode(',', $optionIds);
        $optionId = array_search($id, $optionIds);
        if (!is_array($optionId ) && isset($optionId )) {
            unset($optionIds[$optionId]);
            $optionIds = implode(',', $optionIds);
            $optionIdsItem->setValue($optionIds);
        }
        return $this;
    }

    /**
     * Enter description here ...
     * @param unknown_type $quoteItem
     * @param unknown_type $optionCode
     * @param unknown_type $id
     * @return Emjainteractive_Advancedoptions_Model_Checkout_Cart_Observer
     */
    protected function _addQuoteItemOption($quoteItem, $optionCode, $id, $value) {
        $product = $quoteItem->getProduct();
        $productOption = $product->getOptionById($id);
        if ($productOption) {
            $quoteItemOption = Mage::getModel('sales/quote_item_option')
                ->setItemId($quoteItem->getId())
                ->setItem($quoteItem)
                ->setProductId($product->getId())
                ->setProduct($product)
                ->setCode($optionCode)
                ->setValue($value)
                ->save();
            $quoteItem->addOption($quoteItemOption);

            $optionIdsItem = $quoteItem->getOptionByCode('option_ids');
            if (!$optionIdsItem) {
                $optionIdsItem = $this->_createQuoteOptionIdsItem($quoteItem);
            }
            $optionIds = $optionIdsItem->getValue();
            $optionIds = explode(',', $optionIds);
            $optionId = array_search($id, $optionIds);
            if(!$optionId) {
                $optionIds[] = $id;
                $optionIds = implode(',', $optionIds);
                $optionIdsItem->setValue($optionIds);
            }
        }
        return $this;
    }

    /**
     * @param Mage_Sales_Model_Quote_Item $quoteItem
     * @return Mage_Sales_Model_Quote_Item
     */
    protected function _createQuoteOptionIdsItem(Mage_Sales_Model_Quote_Item $quoteItem)
    {
        $product = $quoteItem->getProduct();
        $quoteItemOption = Mage::getModel('sales/quote_item_option')
            ->setItemId($quoteItem->getId())
            ->setItem($quoteItem)
            ->setProductId($product->getId())
            ->setProduct($product)
            ->setCode('option_ids')
            ->setValue('')
            ->save();
        $quoteItem->addOption($quoteItemOption);
        return $quoteItemOption;
    }

    /**
     * @param array
     * @return string
     */
    protected function _prepareValue($value, $productOption)
    {
        $group = $productOption->groupFactory($productOption->getType())
            ->setOption($productOption)
            ->setProduct($productOption->getProduct())
            ->setRequest(new Varien_Object($productOption->getRequest()));

        if ($group) {
            $value = $group
                ->validateUserValue(array($productOption->getId() => $value))
                ->prepareForCart();
        } else if (is_array($value)) {
            $value = implode(',', $value);
        }
        return $value;
    }

    /**
     * @return Ambigous <Mage_Core_Controller_Request_Http, Zend_Controller_Request_Http>
     */
    protected function _getRequest()
    {
        return Mage::app()->getRequest();
    }

}
