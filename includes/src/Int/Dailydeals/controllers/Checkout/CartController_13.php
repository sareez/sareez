<?php
require_once 'Mage/Checkout/controllers/CartController.php';
class Int_Dailydeals_Checkout_CartController extends Mage_Checkout_CartController
{
  

    public function addAction()
    {
    		
    	
    	
    	if(!Mage::getStoreConfigFlag('dailydeals/dailydeals_settings/enabled'))
    	{
    		return parent::addAction();
    	}
    	
        $cart   = $this->_getCart();
        $params = $this->getRequest()->getParams();
        
        
       $quote = Mage::getSingleton('checkout/session')->getQuote();

		$cartItems = $quote->getAllVisibleItems();
        
        
		foreach ($cartItems as $item) {
			$cartarr[$item->getProductId()] = $item->getQty();
		}
		
		  
        $id= $params['product'];
        $model=Mage::getModel('dailydeals/dailydeals');
        $collectiondeal=Mage::getModel('dailydeals/dailydeals')->getCollection()->addFieldToFilter('related_product',$id)->getData();
        
        $datestart = $collectiondeal[0]['date_start'];
        $dateend = $collectiondeal[0]['date_end'];
        
        $date_start=date('Y-m-d H:i:s' ,strtotime($datestart));
        $date_end=date('Y-m-d H:i:s' ,strtotime($dateend));
        
        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        $query=$read->fetchAll("SELECT TIMEDIFF( NOW() , '".$date_start."') AS diff");
        $query1=$read->fetchAll("SELECT TIMEDIFF('".$date_end."', NOW( )) AS diffend");
        $diff=$query[0]['diff'];
        $diffend=$query1[0]['diffend'];
        
        
        if(!empty($collectiondeal) && $diff > 0 && $diffend >= 0){
        $deal_qty=$collectiondeal[0]['deal_qty']; 
        $proqty = $params['qty'] + $cartarr[$id]; 
        if ($deal_qty < $proqty) {
        	 
        	$this->_getSession()->addError('Deal Quantity is not available');
        	Mage::app()->getResponse()->setRedirect($_SERVER ['HTTP_REFERER']);
        	return;
        }
        
       
        
        }
        
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
                if (!$cart->getQuote()->getHasError()){
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
    
    
    
    /**
    * Update customer's shopping cart
    */
    protected function _updateShoppingCart()
    {
    	
    	$quote = Mage::getSingleton('checkout/session')->getQuote();
    	
    	$cartItems = $quote->getAllVisibleItems();
    	
    	
    	foreach ($cartItems as $item) {
    		$cartarr[$item->getId()] = $item->getProductId();
    	}
    	
    	
    	
    	
    	
    	
    	try {
    		$cartData = $this->getRequest()->getParam('cart');
    		
    		if (is_array($cartData)) {
    			$filter = new Zend_Filter_LocalizedToNormalized(
    			array('locale' => Mage::app()->getLocale()->getLocaleCode())
    			);
    			foreach ($cartData as $index => $data) {
    				if (isset($data['qty'])) {
    					
    					$productid = $cartarr[$index];
    					
    					$pro = Mage::getModel('catalog/product')->load($productid);
    					
    					$collectiondeal=Mage::getModel('dailydeals/dailydeals')->getCollection()->addFieldToFilter('related_product',$productid)->getData();
    					
    					$datestart = $collectiondeal[0]['date_start'];
    					$dateend = $collectiondeal[0]['date_end'];
    					
    					$date_start=date('Y-m-d H:i:s' ,strtotime($datestart));
    					$date_end=date('Y-m-d H:i:s' ,strtotime($dateend));
    					
    					$read = Mage::getSingleton('core/resource')->getConnection('core_read');
    					$query=$read->fetchAll("SELECT TIMEDIFF( NOW() , '".$date_start."') AS diff");
    					$query1=$read->fetchAll("SELECT TIMEDIFF('".$date_end."', NOW( )) AS diffend");
    					$diff=$query[0]['diff'];
    					$diffend=$query1[0]['diffend'];
    					
    					
    					if(!empty($collectiondeal) && $diff > 0 && $diffend >= 0){
    						$deal_qty=$collectiondeal[0]['deal_qty'];
    						$proqty = $data['qty'];
    						if ($deal_qty < $proqty) {
    						$this->_getSession()->addError('Deal Quantity is not available for product '.$pro->getName());
        					Mage::app()->getResponse()->setRedirect($_SERVER ['HTTP_REFERER']);
        					return;
    						}
    					}		
    					
    					
    					$cartData[$index]['qty'] = $filter->filter(trim($data['qty']));
    				}
    			}
    			
    			
    			
    			$cart = $this->_getCart();
    			if (! $cart->getCustomerSession()->getCustomer()->getId() && $cart->getQuote()->getCustomerId()) {
    				$cart->getQuote()->setCustomerId(null);
    			}
    
    			$cartData = $cart->suggestItemsQty($cartData);
    			$cart->updateItems($cartData)
    			->save();
    		}
    		$this->_getSession()->setCartWasUpdated(true);
    	} catch (Mage_Core_Exception $e) {
    		$this->_getSession()->addError(Mage::helper('core')->escapeHtml($e->getMessage()));
    	} catch (Exception $e) {
    		$this->_getSession()->addException($e, $this->__('Cannot update shopping cart.'));
    		Mage::logException($e);
    	}
    }
    

   
}
