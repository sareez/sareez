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
            $i=1;
            foreach ($info as $itemId => $itemInfo) {
                
                /*if($i==1)
                {
                    $i++;
                    continue;
                }*/
                
                $quoteItem = $cart->getQuote()->getItemById($itemId);
                if (!$quoteItem) {
                    continue;
                }
                
                
                
                //$cartOptions = $quoteItem->getProduct()->getOptions();
                //print_r($cartOptions);
                //exit;
                //$quoteItem->getProduct()->setOptions($cartOptions)->save();
                //Mage::getModel('checkout/cart')->save();
                
                //print_r($cart);
                
                //echo $quoteItem->getProductId();
                //echo $product->getId();
                //exit;
                
                
                
                //$options = $itemInfo['options'];
                //print_r($options);
                //exit;
                $count = 0;
                if (isset($itemInfo['options']) && is_array($itemInfo['options'])) {
                    $options = $itemInfo['options'];
                    
                    //$customOptions = $quoteItem->getOptions();
                    //$quoteItem->setOptions($customOptions)->save(); 
                    //Mage::getSingleton('checkout/cart')->save();
                    
                    foreach ($options as $id => $value) {
                        $optionCode = 'option_' . $id;
                        
                        $quoteItemOption = $quoteItem->getOptionByCode($optionCode);
                        
                        $product = $quoteItem->getProduct();
                        $write = Mage::getSingleton('core/resource')->getConnection('core_write');
                        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
                        $tableName = Mage::getSingleton('core/resource')->getTableName('cart_customoption_update_status');
                        
                        $sessionId = Mage::getModel("core/session")->getEncryptedSessionId();
                        $itemId = $quoteItem->getId();
                        $optionId = $id;
                        
                        $query = "SELECT id FROM " . $tableName . " WHERE session_id = '". $sessionId . "' AND item_id = '".$itemId."' AND option_id = '".$optionId."'";
                        $itemIdExist = $read->fetchOne($query);
                        if($itemIdExist != ""){
                            foreach ($product->getOptions() as $o){
                                $productOptionId = $o->getId();
                                $totalOptionPrice = 0;
                                if($productOptionId == $id){                                    
                                    $values = $o->getValues();
                                    foreach ($values as $k => $v){
                                        if(in_array($v['option_type_id'], $value)){
                                            $totalOptionPrice += $v['price'];
                                        }
                                    }
                                }
                            }
                            
                            $store = $product->getStore();
                            $productItemPrice = $quoteItem->getProduct()->getPrice();
                            $new_price = $productItemPrice + $totalOptionPrice;
                            $productItemNewPrice = $store->convertPrice($new_price, false, false);
                            $quoteItem->setOriginalCustomPrice($productItemNewPrice);
                            $quoteItem->save();
                        }
                        
                        

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
                                $count++;
                                $this->_removeQuoteItemOption($quoteItem, $optionCode, $id);
                                continue;
                            }

                            $productOption->setProduct($quoteItem->getProduct());
                            $productOption->setRequest($options);
                            $value = $this->_prepareValue($value, $productOption);

                            //print_r($quoteItemOption->getValue());
                            //exit;
                            
                            if($quoteItemOption) {
                                $count++;                                
                                $quoteItemOption->setValue($value);
                                continue;
                            }

                            if ($value) {
                                $count++;
                                $this->_addQuoteItemOption($quoteItem, $optionCode, $id, $value);
                                continue;
                            }
                        }
                    }
                    if($count == 0)
                    {
                        $product = $quoteItem->getProduct(); 
                        
                        $value = 0;
                        foreach ($product->getOptions() as $o) {
                            $productOptionId = $o->getId();
                            
                            //print_r($value);
                            //exit;
                        
                            $id = $productOptionId;
                            $optionCode = 'option_' . $id;
                            $quoteItemOption = $quoteItem->getOptionByCode($optionCode);
                            
                            
                            $write = Mage::getSingleton('core/resource')->getConnection('core_write');
                            $read = Mage::getSingleton('core/resource')->getConnection('core_read');
                            $tableName = Mage::getSingleton('core/resource')->getTableName('cart_customoption_update_status');
                            
                            $sessionId = Mage::getModel("core/session")->getEncryptedSessionId();
                            $itemId = $quoteItem->getId();
                            $optionId = $id;
                            
                            $query = "SELECT id FROM " . $tableName . " WHERE session_id = '". $sessionId . "' AND item_id = '".$itemId."' AND option_id = '".$optionId."'";
                            $itemIdExist = $read->fetchOne($query);
                            if($itemIdExist != ""){
                                
                                $store = $product->getStore();
                                $productItemPrice = $quoteItem->getProduct()->getPrice();
                                $new_price = $productItemPrice;
                                $productItemNewPrice = $store->convertPrice($new_price, false, false);
                                $quoteItem->setOriginalCustomPrice($productItemNewPrice);
                                $quoteItem->save();
                            }
    
                            $productOption = $quoteItem->getProduct()->getOptionById($id);
                            if ($productOption) {
                                
                                if ($quoteItemOption && !$value) {
                                    $this->_removeQuoteItemOption($quoteItem, $optionCode, $id);
                                    continue;
                                }
    
                                $productOption->setProduct($quoteItem->getProduct());
                                $productOption->setRequest($options);
                                //$value = $this->_prepareValue($value, $productOption);
    
    
                                if($quoteItemOption) {
                                    $quoteItemOption->setValue($value);
                                    continue;
                                }
                            }
                            //echo "Test";
                            //exit;                        
                            //$quoteItemOption->setValue(0);
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
                
                //$a = $quoteItem->getOption();
                //print_r($value);
                //exit;
                $write = Mage::getSingleton('core/resource')->getConnection('core_write');
                $read = Mage::getSingleton('core/resource')->getConnection('core_read');
                $tableName = Mage::getSingleton('core/resource')->getTableName('cart_customoption_update_status');
                
                $sessionId = Mage::getModel("core/session")->getEncryptedSessionId();
                $itemId = $quoteItem->getId();
                $optionId = $id;
                
                $query = "SELECT id FROM " . $tableName . " WHERE session_id = '". $sessionId . "' AND item_id = '".$itemId."' AND option_id = '".$optionId."'";
                $itemIdExist = $read->fetchOne($query);
                if($itemIdExist == ""){
                    $write->query("INSERT INTO " . $tableName . "  SET session_id='".$sessionId."',item_id='".$itemId."',option_id='".$optionId."'");
                }
                
                foreach ($product->getOptions() as $o){
                    $productOptionId = $o->getId();
                    if($productOptionId == $id){
                        $totalOptionPrice = 0;
                        $values = $o->getValues();
                        foreach ($values as $k => $v){
                            if($v['option_type_id'] == $value){
                                $totalOptionPrice += $v['price'];
                            }
                        }
                    }
                }
                
                $store = $product->getStore();
                $productItemPrice = $quoteItem->getProduct()->getPrice();
                $new_price = $productItemPrice + $totalOptionPrice;
                $productItemNewPrice = $store->convertPrice($new_price, false, false);
                $quoteItem->setOriginalCustomPrice($productItemNewPrice);
                $quoteItem->save();
                
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
        //$quoteItem->save();
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

