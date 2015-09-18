<?php
/**
 * Intellimage
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to mauricioprado00@gmail.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade your
 * Intellimage extension to newer versions in the future. 
 * If you wish to customize your Intellimage extension to your
 * needs please refer to mauricioprado00@gmail.com for more information.
 *
 * @package     Intellimage_CurrencyCheckout
 * @author      Hugo Mauricio Prado Macat
 * @copyright   2013
 * @email       mauricioprado00@gmail.com
 * @license     http://www.opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */



class Intellimage_CurrencyCheckout_Model_Observer
{
    const CONFIG_PATH_CURRENCY_CHECKOUT_PRESERVE_ORDER_CURRENCY = 'checkout/image_currency_checkout/preserve_currency';
    const CONFIG_PATH_CURRENCY_CHECKOUT_USE_FIXED_CURRENCY = 'checkout/image_currency_checkout/use_fixed_currency';
    const CONFIG_PATH_CURRENCY_CHECKOUT_FIXED_CURRENCY = 'checkout/image_currency_checkout/fixed_currency';
    const CONFIG_PATH_CURRENCY_CHECKOUT_DISPLAY_ORIGINAL_CURRENCY_ON_BACKEND = 'checkout/image_currency_checkout/display_original_currency_backend';

    private $_orderIdToRevert = null;
    
    private $_itemFields = array(
        'base_original_price', 
//      'original_price', 
//      'price', 
        'base_price', 
//      'tax_amount', 
//      'tax_before_discount', 
        'base_tax_before_discount', 
//      'row_total', 
        'base_tax_amount', 
        'base_row_total', 
        'base_cost', 
//      'hidden_tax_amount', 
        'base_hidden_tax_amount', 
//      'price_incl_tax', 
        'base_price_incl_tax', 
//      'row_total_incl_tax', 
        'base_row_total_incl_tax', 
//      'weee_tax_applied_amount', 
//      'weee_tax_applied_row_amount', 
        'base_weee_tax_applied_amount', 
        'base_weee_tax_applied_row_amount', 
        'base_weee_tax_applied_row_amnt', 
//      'discount_amount', 
        'base_discount_amount',
        'base_fooman_surcharge_amount',
        'base_fooman_surcharge_tax_amount',
        
    );
    
    private $_orderFields = array(
        'base_grand_total',
        'base_subtotal',
        'base_tax_amount',
        'base_shipping_amount',
    );
    
    /**
     * @param Mage_Sales_Model_Order $order
     * @return boolean
     */
    public function _useFixedCurrency($order)
    {
        try {
            $useFixedCurrency = Mage::getStoreConfig(self::CONFIG_PATH_CURRENCY_CHECKOUT_USE_FIXED_CURRENCY);
            if (!$useFixedCurrency) {
                return false;
            }

            $fixedCurrencyCode = Mage::getStoreConfig(self::CONFIG_PATH_CURRENCY_CHECKOUT_FIXED_CURRENCY);
            $baseCurrencyCode = Mage::app()->getStore()->getBaseCurrencyCode();

            $baseCurrency = Mage::getModel('directory/currency')->load($baseCurrencyCode);
            $fixedCurrency = Mage::getModel('directory/currency')->load($fixedCurrencyCode);

            $imagecc_preserved_information = array(
                'order_fields' => array(),
                'item_fields' => array(),
            );
            $_coreHelper = Mage::helper('core');

            Mage::helper('imagecc')->log("Using fixed currency " . $order->getIncrementId());
            
            foreach ($this->_orderFields as $field) {
                $field2 = preg_replace('(^base_)', '', $field);
                $new_v = $order->getData($field);
                $new_v = $baseCurrency->convert($new_v, $fixedCurrency);
                $new_v2 = $new_v;

                /**
                 * preserve information before change it
                 */
                if ($field != $field2) {
                    $imagecc_preserved_information['order_fields'][] = array(
                        'field' => $field,
                        'original_value' => $order->getData($field),
                        'new_value' => $new_v,
                    );
                    $imagecc_preserved_information['order_fields'][] = array(
                        'field' => $field2,
                        'original_value' => $order->getData($field2),
                        'new_value' => $new_v2,
                    );
                }

                $order->setData($field, $new_v);
                $order->setData($field2, $new_v2);
                Mage::helper('imagecc')->log("$field2 $field $new_v");
            }
            
            foreach ($order->getAllItems() as $item) {
                $arr = $this->_itemFields;

                $quoteItemId = $item->getData('quote_item_id');
                $imagecc_preserved_information['item_fields'][$quoteItemId] = array();
                
                foreach ($arr as $k) {
                    //$v = $item->getData($k);
                    //$new_v = $_coreHelper->currency($v, false, false);
                    $field2 = preg_replace('(^base_)', '', $k);
                    $new_v = $item->getData($k);
                    $new_v = $baseCurrency->convert($new_v, $fixedCurrency);
                    $new_v2 = $item->getData($field2);
                    $new_v2 = $new_v;

                    /**
                     * preserve information before change it
                     */
                    if ($k != $field2) {
                        $imagecc_preserved_information['item_fields'][$quoteItemId][] = array(
                            'field' => $k,
                            'original_value' => $item->getData($k),
                            'new_value' => $new_v,
                        );
                        $imagecc_preserved_information['item_fields'][$quoteItemId][] = array(
                            'field' => $field2,
                            'original_value' => $item->getData($field2),
                            'new_value' => $new_v2,
                        );
                    }
                    $item->setData($k, $new_v);
                    $item->setData($field2, $new_v2);
                    Mage::helper('imagecc')->log("$field2 $k $new_v");
                }
                //$item->save();
            }

            $store_currency = $fixedCurrencyCode;

            /**
             * preserve information before change it
             */
            
            $imagecc_preserved_information['order_fields']['order_currency_code'] = array(
                'original_value' => $order->getData('order_currency_code'),
                'field' => 'order_currency_code',
                'new_value' => $store_currency,
            );

            $imagecc_preserved_information['order_fields']['global_currency_code'] = array(
                'original_value' => $order->getData('global_currency_code'),
                'field' => 'global_currency_code',
                'new_value' => $store_currency,
            );

            $imagecc_preserved_information['order_fields']['base_currency_code'] = array(
                'original_value' => $order->getData('base_currency_code'),
                'field' => 'base_currency_code',
                'new_value' => $store_currency,
            );

            $imagecc_preserved_information['order_fields']['store_currency_code'] = array(
                'original_value' => $order->getData('store_currency_code'),
                'field' => 'store_currency_code',
                'new_value' => $store_currency,
            );

            $order
                ->setData('order_currency_code', $store_currency)
                ->setData('global_currency_code', $store_currency)
                ->setData('base_currency_code', $store_currency)
                ->setData('store_currency_code', $store_currency)
                ->setData('imagecc_preserved_information', json_encode($imagecc_preserved_information));

            return true;

        } catch(Exception $e) {
            Mage::helper('imagecc')->log("error during fixed currency " . $e->getMessage());
        }

        return false;
    }
    
    /**
     * handles the event checkout_type_onepage_save_order to set the currency of the order
     * @param Varien_Event $event
     */
    public function setOrderCurrency($event)
    {
        if (Mage::helper('imagecc')->isActive()) {
            $order = $event->getOrder();
            
            if ($order && !Mage::helper('imagecc')->isPaypalOrder($order)) {

                if ($this->_useFixedCurrency($order)) {
                    return;
                }

                Mage::helper('imagecc')->log("Using display currency " . $order->getIncrementId());

                $imagecc_preserved_information = array(
                    'order_fields' => array(),
                    'item_fields' => array(),
                );
                $_coreHelper = Mage::helper('core');
                
                foreach ($this->_orderFields as $field) {
                    $field2 = preg_replace('(^base_)', '', $field);
                    $new_v = $order->getData($field2);
                    //$v = $order->getData($field);
                    //$new_v = $_coreHelper->currency($v, false, false);

                    /**
                     * preserve information before change it
                     */
                    if ($field !== $field2) {
                        $imagecc_preserved_information['order_fields'][] = array(
                            'field' => $field,
                            'original_value' => $order->getData($field),
                            'new_value' => $new_v,
                        );
                    }

                    $order->setData($field, $new_v);
                    Mage::helper('imagecc')->log("$field2 $field $new_v");
                }
                
                foreach ($order->getAllItems() as $item) {
                    $arr = $this->_itemFields;

                    $quoteItemId = $item->getData('quote_item_id');
                    $imagecc_preserved_information['item_fields'][$quoteItemId] = array();
                    
                    foreach ($arr as $k) {
                        //$v = $item->getData($k);
                        //$new_v = $_coreHelper->currency($v, false, false);
                        $field2 = preg_replace('(^base_)', '', $k);
                        $new_v = $item->getData($field2);

                        /**
                         * preserve information before change it
                         */
                        if ($k !== $field2) {
                            $imagecc_preserved_information['item_fields'][$quoteItemId][] = array(
                                'field' => $k,
                                'original_value' => $item->getData($k),
                                'new_value' => $new_v,
                            );
                        }
                        $item->setData($k, $new_v);
                        Mage::helper('imagecc')->log("$field2 $k $new_v");
                    }
                    //$item->save();
                }

                $store_currency = $order->getData('order_currency_code');

                /**
                 * preserve information before change it
                 */
                $imagecc_preserved_information['order_fields']['global_currency_code'] = array(
                    'original_value' => $order->getData('global_currency_code'),
                    'field' => 'global_currency_code',
                    'new_value' => '',
                );

                $imagecc_preserved_information['order_fields']['base_currency_code'] = array(
                    'original_value' => $order->getData('base_currency_code'),
                    'field' => 'base_currency_code',
                    'new_value' => '',
                );

                $imagecc_preserved_information['order_fields']['store_currency_code'] = array(
                    'original_value' => $order->getData('store_currency_code'),
                    'field' => 'store_currency_code',
                    'new_value' => '',
                );

                $order->setData('global_currency_code', $store_currency)
                    ->setData('base_currency_code', $store_currency)
                    ->setData('store_currency_code', $store_currency)
                    ->setData('imagecc_preserved_information', json_encode($imagecc_preserved_information));
            }
        }
    }

    /**
     * Allows backend users to see the base and display currency prices
     */
    public function reversePreservedData($event)
    {
        $order = $event->getOrder();
        if ($order && Mage::getStoreConfig(self::CONFIG_PATH_CURRENCY_CHECKOUT_DISPLAY_ORIGINAL_CURRENCY_ON_BACKEND)) {
            Mage::helper('imagecc')->reversePreservedOrderData($order);
        }
    }

    public function revertBlockView($event)
    {
        $block = $event->getBlock();
        try {
            if ($block->getLayout()->getUpdate()->getHandles() == 'adminhtml_sales_order_view' && $block->getOrder()) {
                $order = $block->getOrder();
                Mage::helper('imagecc')->reversePreservedOrderData($order);
            }
        } catch (Exception $e) {
            
        }
    }

    public function revertOrderView($event)
    {
        $block = $event->getBlock();
        if ($block instanceof Mage_Adminhtml_Block_Sales_Order_View || $block instanceof Mage_Adminhtml_Block_Sales_Order_Totals) {
            $order = $block->getOrder();
            Mage::helper('imagecc')->reversePreservedOrderData($order);
        }
        //var_dump(get_class($block));
    }
    
    // /**
    //  * Reverses the currency translation
    //  * @param Varien_Event $event
    //  */
    // public function revertOrderCurrency($event)
    // {
    //     $order = $event->getOrder();
    //     if (!Mage::helper('imagecc')->isPaypalOrder($order)) {
    //         if (Mage::getStoreConfig(self::CONFIG_PATH_CURRENCY_CHECKOUT_PRESERVE_ORDER_CURRENCY)) {
    //             $this->_orderIdToRevert = $order->getId();
    //         }
    //     }
    // }
    
    // public function processRevertOrderCurrency($event)
    // {
    //     if ($this->_orderIdToRevert) {
    //         $order = Mage::getModel('sales/order');
    //         $order->load($this->_orderIdToRevert);
    //         if (!Mage::helper('imagecc')->isPaypalOrder($order)) {
    //             $quote = Mage::getModel('sales/quote');
    //             $quote->load($order->getQuoteId());
                
    //             if ($order->getGlobalCurrencyCode() !== $quote->getGlobalCurrencyCode()) {
                    
    //                 $currfields = array(
    //                     'global_currency_code',
    //                     'base_currency_code',
    //                     'store_currency_code'
    //                 );
                    
    //                 foreach (array_merge($this->_orderFields, $currfields) as $field) {
    //                     $v = $quote->getData($field);
    //                     $order->setData($field, $v);
    //                 }
                    
    //                 foreach ($order->getAllItems() as $item) {
    //                     $arr = $this->_itemFields;
    //                     $quoteItem = Mage::getModel('sales/quote_item');
    //                     $quoteItem->load($item->getQuoteItemId());
    //                     foreach ($arr as $k) {
    //                         $v = $quoteItem->getData($k);
    //                         $item->setData($k, $v);
    //                     }
    //                     $item->save();
    //                 }

    //                 $order->save();
    //             }
    //         }
    //     }
    // }
}