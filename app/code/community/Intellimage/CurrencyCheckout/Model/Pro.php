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


class Intellimage_CurrencyCheckout_Model_Pro  extends Mage_Paypal_Model_Pro{

 	public function capture(Varien_Object $payment, $amount)
    {
		if(!Mage::helper('imagecc')->isActive()){
			return parent::capture($payment, $amount);
		}
	
        $authTransactionId = $this->_getParentTransactionId($payment);
        if (!$authTransactionId) {
            return false;
        }
        $api = $this->getApi()
            ->setAuthorizationId($authTransactionId)
            ->setIsCaptureComplete($payment->getShouldCloseParentTransaction())
            ->setAmount($amount)
            ->setCurrencyCode($payment->getOrder()->getOrderCurrencyCode())
            ->setInvNum($payment->getOrder()->getIncrementId())
            // TODO: pass 'NOTE' to API
        ;

        $api->callDoCapture();
        $this->_importCaptureResultToPayment($api, $payment);
    }

    /**
     * Refund a capture transaction
     *
     * @param Varien_Object $payment
     * @param float $amount
     */
    public function refund(Varien_Object $payment, $amount)
    {
		if(!Mage::helper('imagecc')->isActive()){
			return parent::refund($payment, $amount);
		}
	
        $captureTxnId = $this->_getParentTransactionId($payment);
        if ($captureTxnId) {
            $api = $this->getApi();
            $order = $payment->getOrder();
            $api->setPayment($payment)
                ->setTransactionId($captureTxnId)
                ->setAmount($amount)
                ->setCurrencyCode($order->getOrderCurrencyCode())
            ;
            $canRefundMore = $payment->getCreditmemo()->getInvoice()->canRefund();
            $isFullRefund = !$canRefundMore
                && (0 == ((float)$order->getBaseTotalOnlineRefunded() + (float)$order->getBaseTotalOfflineRefunded()));
            $api->setRefundType($isFullRefund ? Mage_Paypal_Model_Config::REFUND_TYPE_FULL
                : Mage_Paypal_Model_Config::REFUND_TYPE_PARTIAL
            );
            $api->callRefundTransaction();
            $this->_importRefundResultToPayment($api, $payment, $canRefundMore);
        } else {
            Mage::throwException(Mage::helper('paypal')->__('Impossible to issue a refund transaction because the capture transaction does not exist.'));
        }
    }

}