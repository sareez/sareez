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



class Intellimage_CurrencyCheckout_Helper_Data extends Mage_Core_Helper_Abstract
{
    const CONFIG_PATH_CURRENCY_CHECKOUT_ACTIVE = 'checkout/image_currency_checkout/active';
    const CONFIG_PATH_CURRENCY_CHECKOUT_USE_FIXED_CURRENCY = 'checkout/image_currency_checkout/use_fixed_currency';
    const CONFIG_PATH_CURRENCY_CHECKOUT_FIXED_CURRENCY = 'checkout/image_currency_checkout/fixed_currency';
    const CONFIG_PATH_CURRENCY_CHECKOUT_DEBUG = 'checkout/image_currency_checkout/debug';

    /**
     * determines if the order is paid with a paypal method
     * @param $order Mage_Sales_Model_Order
     * @return boolean
     */
    public function isPaypalOrder($order)
    {
        $payment = $order->getPayment();
        if ($payment) {
            $payment_method_code = $payment->getMethodInstance() && $payment->getMethodInstance()->getCode() ? $payment->getMethodInstance()->getCode() : null;

            if (isset($payment_method_code)) {
                $return = strpos($payment_method_code, 'paypal') !== false;
                $this->log('checking method ' . $payment_method_code . ' ' . ($return ? 'true' : 'false'));
                return $return;
            }
        }
    }

    /**
     * Checks if the extension is active
     * @return boolean
     */
    public function isActive()
    {
        return Mage::getStoreConfig(self::CONFIG_PATH_CURRENCY_CHECKOUT_ACTIVE);
    }

    /**
     * Determines if it's debug mode
     * @return boolean
     */
    public function isDebug()
    {
        return Mage::getStoreConfig(self::CONFIG_PATH_CURRENCY_CHECKOUT_DEBUG);
    }

    /**
     * Logs information 
     */
    public function log($message, $type = null, $debug = true)
    {
        if (!isset($type)) {
            $type = Zend_Log::INFO;
        }
        
        if ($this->isDebug() || !$debug) {
            Mage::log($message, $type, 'store-currency.log');
        }
    }

    /**
     * Reverse preserver currency order data
     */
    public function reversePreservedOrderData($order)
    {
        $imagecc_preserved_information = $order->getData('imagecc_preserved_information');
        if ($imagecc_preserved_information) {
            $imagecc_preserved_information = json_decode($imagecc_preserved_information);
            // header('content-type:text/plain');
            // var_dump($imagecc_preserved_information);
            // die();
            if ($imagecc_preserved_information) {
                
                $whitelisted = array('admin/sales_order:view');
                $adminFrontName = (string) Mage::getConfig()->getNode('admin/routers/adminhtml/args/frontName');
                $whitelisted[] = $adminFrontName . '/sales_order:view';

                $request = Mage::app()->getRequest();
                $request_signature = $request->getModuleName() . '/' . $request->getControllerName() . ':' . $request->getActionName();

                if (in_array($request_signature, $whitelisted)) {
                    foreach ($imagecc_preserved_information->order_fields as $field => $data) {
                        //var_dump(array($data->field, $data->original_value));
                        $order->setData($data->field, $data->original_value);
                    }
                    
                    foreach ($order->getAllItems() as $item) {
                        $quoteItemId = $item->getData('quote_item_id');

                        foreach ($imagecc_preserved_information->item_fields->{$quoteItemId} as $data) {
                            $item->setData($data->field, $data->original_value);
                        }
                    }
                }

                $order->setData('currency_code', $order->getData('order_currency_code'));
            }
        }
    }

    /**
     * Calculates an amount in a fixed currency
     */
    public function calculateFixedCurrencyAmount($amount, $format = true, $includeContainer = true)
    {
        $fixedCurrencyCode = Mage::getStoreConfig(self::CONFIG_PATH_CURRENCY_CHECKOUT_FIXED_CURRENCY);
        $baseCurrencyCode = Mage::app()->getStore()->getBaseCurrencyCode();

        if ($baseCurrencyCode == $fixedCurrencyCode) {
            return false;
        }

        $baseCurrency = Mage::getModel('directory/currency')->load($baseCurrencyCode);
        $fixedCurrency = Mage::getModel('directory/currency')->load($fixedCurrencyCode);

        $currency = $baseCurrency;

        if (Mage::getStoreConfig(self::CONFIG_PATH_CURRENCY_CHECKOUT_USE_FIXED_CURRENCY)) {
            $amount = $baseCurrency->convert($amount, $fixedCurrency);
            $currency = $fixedCurrency;
        }

        return $currency->format($amount, array(), $includeContainer);
    }
}