<?php
require_once 'Mage/Checkout/controllers/CartController.php';
class MyExtensions_Checkout_CartController extends Mage_Checkout_CartController
{
     /**
     * Add product to shopping cart action
     * Overides the addAction() function from Mage_Checkout_CartController.
     */
    public function addAction()
    {
        $cart   = $this->_getCart();
        $params = $this->getRequest()->getParams();
        try {
            if (isset($params['qty'])) {
                $filter = new Zend_Filter_LocalizedToNormalized(
                    array('locale' => Mage::app()->getLocale()->getLocaleCode())
                );
                $params['qty'] = $filter->filter($params['qty']);
            }
 
            $product = $this->_initProduct();
            $related = $this->getRequest()->getParam('related_product');
 
            /**
             * Check product availability
             */
            if (!$product) {
                $this->_goBack();
                return;
            }
 
            $cart->addProduct($product, $params);
            if (!empty($related)) {
                $cart->addProductsByIds(explode(',', $related));
            }
 
            $cart->save();
 
            $this->_getSession()->setCartWasUpdated(true);
 
            /**
             * @todo remove wishlist observer processAddToCart
             */
            Mage::dispatchEvent('checkout_cart_add_product_complete',
                array('product' => $product, 'request' => $this->getRequest(), 'response' => $this->getResponse())
            );
 
            if (!$this->_getSession()->getNoCartRedirect(true)) {
            //Remove the added to cart message by calling the isDisplayMsg() function with && logic operator
                if (!$cart->getQuote()->getHasError() && $this->isDisplayMsg()){
                    $message = $this->__('%s was added to your shopping cart.', Mage::helper('core')->escapeHtml($product->getName()));
                    $this->_getSession()->addSuccess($message);
                }
                 
                $this->_goBack();
            }
        } catch (Mage_Core_Exception $e) {
            if ($this->_getSession()->getUseNotice(true)) {
                $this->_getSession()->addNotice(Mage::helper('core')->escapeHtml($e->getMessage()));
            } else {
                $messages = array_unique(explode("\n", $e->getMessage()));
                foreach ($messages as $message) {
                    $this->_getSession()->addError(Mage::helper('core')->escapeHtml($message));
                }
            }
 
            $url = $this->_getSession()->getRedirectUrl(true);
            if ($url) {
                $this->getResponse()->setRedirect($url);
            } else {
                $this->_redirectReferer(Mage::helper('checkout/cart')->getCartUrl());
            }
        } catch (Exception $e) {
            $this->_getSession()->addException($e, $this->__('Cannot add the item to shopping cart.'));
            Mage::logException($e);
            $this->_goBack();
        }
    }
     
    /*This function is just to show that besides we can overriding the exiting functions, but we can also add new functions.
    **In this case, we use this function to determine if we want to show the added to cart message.
    **true, display
    **false, don't display
    **/
    public function isDisplayMsg()
    {
        return false;
    }
}