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



class Intellimage_CurrencyCheckout_Model_Hostedpro_Request extends Mage_Paypal_Model_Hostedpro_Request
{
 
 	protected function _getOrderData(Mage_Sales_Model_Order $order)
    {
		if(!Mage::helper('imagecc')->isActive()){
			return parent::_getOrderData($order);
		}
	
		
		  $request = array(
            'subtotal'      => $this->_formatPrice(
                $this->_formatPrice($order->getPayment()->getAmountAuthorized()) -
                $this->_formatPrice($order->getTaxAmount()) -
                $this->_formatPrice($order->getShippingAmount())
            ),
            'tax'           => $this->_formatPrice($order->getTaxAmount()),
            'shipping'      => $this->_formatPrice($order->getShippingAmount()),
            'invoice'       => $order->getIncrementId(),
            'address_override' => 'false',
            'currency_code'    => $order->getOrderCurrencyCode(),
            'buyer_email'      => $order->getCustomerEmail()
        );
		
		

        // append to request billing address data
        if ($billingAddress = $order->getBillingAddress()) {
            $request = array_merge($request, $this->_getBillingAddress($billingAddress));
        }

        // append to request shipping address data
        if ($shippingAddress = $order->getShippingAddress()) {
            $request = array_merge($request, $this->_getShippingAddress($shippingAddress));
        }
		

        return $request;
    }
}
