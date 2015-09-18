<?php
require_once 'Mage/Checkout/controllers/OnepageController.php';
class Int_Dailydeals_Checkout_OnepageController extends Mage_Checkout_OnepageController
{


  public function successAction()
    {
        $session = $this->getOnepage()->getCheckout();
        if (!$session->getLastSuccessQuoteId()) {
            $this->_redirect('checkout/cart');
            return;
        }

        $lastQuoteId = $session->getLastQuoteId();
        $lastOrderId = $session->getLastOrderId();
        $lastRecurringProfiles = $session->getLastRecurringProfileIds();
        if (!$lastQuoteId || (!$lastOrderId && empty($lastRecurringProfiles))) {
            $this->_redirect('checkout/cart');
            return;
        }
		
		$order = Mage::getModel('sales/order')->load($lastOrderId);
		if($order->getShippingMethod() == 'flatrate4_flatrate4')
		{
			$order->setState('quote', true)->save();
		}
		
        //$session->clear();
        $this->loadLayout();
        $this->_initLayoutMessages('checkout/session');
        Mage::dispatchEvent('checkout_onepage_controller_success_action', array('order_ids' => array($lastOrderId)));
        $this->renderLayout();
    }

    	
	 public function saveOrderAction()
    {
        if ($this->_expireAjax()) {
            return;
        }

        $result = array();
        try {
            if ($requiredAgreements = Mage::helper('checkout')->getRequiredAgreementIds()) {
                $postedAgreements = array_keys($this->getRequest()->getPost('agreement', array()));
                if ($diff = array_diff($requiredAgreements, $postedAgreements)) {
                    $result['success'] = false;
                    $result['error'] = true;
                    $result['error_messages'] = $this->__('Please agree to all the terms and conditions before placing the order.');
                    $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
                    return;
                }
            }
            if ($data = $this->getRequest()->getPost('payment', false)) {
                $this->getOnepage()->getQuote()->getPayment()->importData($data);
            }
            $this->getOnepage()->saveOrder();

          $redirectUrl = $this->getOnepage()->getCheckout()->getRedirectUrl();
            $result['success'] = true;
            $result['error']   = false;
        } catch (Mage_Payment_Model_Info_Exception $e) {
            $message = $e->getMessage();
            if( !empty($message) ) {
                $result['error_messages'] = $message;
            }
            $result['goto_section'] = 'payment';
            $result['update_section'] = array(
                'name' => 'payment-method',
                'html' => $this->_getPaymentMethodsHtml()
            );
        } catch (Mage_Core_Exception $e) {
            Mage::logException($e);
            Mage::helper('checkout')->sendPaymentFailedEmail($this->getOnepage()->getQuote(), $e->getMessage());
            $result['success'] = false;
            $result['error'] = true;
            $result['error_messages'] = $e->getMessage();

            if ($gotoSection = $this->getOnepage()->getCheckout()->getGotoSection()) {
                $result['goto_section'] = $gotoSection;
                $this->getOnepage()->getCheckout()->setGotoSection(null);
            }

            if ($updateSection = $this->getOnepage()->getCheckout()->getUpdateSection()) {
                if (isset($this->_sectionUpdateFunctions[$updateSection])) {
                    $updateSectionFunction = $this->_sectionUpdateFunctions[$updateSection];
                    $result['update_section'] = array(
                        'name' => $updateSection,
                        'html' => $this->$updateSectionFunction()
                    );
                }
                $this->getOnepage()->getCheckout()->setUpdateSection(null);
            }
        } catch (Exception $e) {
            Mage::logException($e);
            Mage::helper('checkout')->sendPaymentFailedEmail($this->getOnepage()->getQuote(), $e->getMessage());
            $result['success']  = false;
            $result['error']    = true;
            $result['error_messages'] = $this->__('There was an error processing your order. Please contact us or try again later.');
        }
        $this->getOnepage()->getQuote()->save();
		
			$session = $this->getOnepage()->getCheckout();

			$lastOrderId = $session->getLastOrderId(); 	
			$order = Mage::getModel('sales/order')->load($lastOrderId);

			$items = $order->getAllItems();
			foreach ($items as $itemId)
			{
				$id=$itemId->getProductId();
				$qty=$itemId->getQtyToInvoice();
				
				$dealmodel=Mage::getModel('dailydeals/dailydeals');
				$dealcollection=$dealmodel->getCollection()->addFieldToFilter('related_product',$id)->addFieldToFilter('deal_status','Running')->getData();
				
				if(!empty($dealcollection)){
			
					$deal_qty=$dealcollection[0]['deal_qty'];
					$deal_id=$dealcollection[0]['dailydeals_id'];
					//$deal_id=$dealcollection[0]['dailydeals_id'];
					$qty_sold=$dealcollection[0]['qty_sold'];
					$status=$dealcollection[0]['status'];
					if($status==1){
				$remaining_qty=$deal_qty - $qty;
			
				$qtydeal['qty_sold']=$qty_sold+$qty;
				$qtydeal['deal_qty']=$remaining_qty;
				
					$dealmodel->setData($qtydeal)->setId($deal_id);
					$dealmodel->save();
					}
					
				}
				
			}
			
		
        /**
         * when there is redirect to third party, we don't want to save order yet.
         * we will save the order in return action.
         */
		
        if (isset($redirectUrl)) {
            $result['redirect'] = $redirectUrl;
        }

        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
		
    }

   
}
?>