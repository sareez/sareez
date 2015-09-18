<?php
class Sareez_Order_Model_Quote_Address_Total_Discount 
extends Mage_Sales_Model_Quote_Address_Total_Abstract
{
     public function __construct()
    {
         $this -> setCode('discount_total');
         }
    /**
     * Collect totals information about discount
     * 
     * @param Mage_Sales_Model_Quote_Address $address 
     * @return Mage_Sales_Model_Quote_Address_Total_Shipping 
     */
     public function collect(Mage_Sales_Model_Quote_Address $address)
    {
		
         parent :: collect($address);
         $items = $this->_getAddressItems($address);
         if (!count($items)) {
            return $this;
         }
         $quote= $address->getQuote();
		 
//////////////////////////////////////////////////////////////////////////////////////////////////////////
    session_start();
    //$discountCoupon = $_SESSION['discountCoupon'];
   // Mage::helper('core')->currency($_SESSION['discountCoupon'],false,false);
    //$discountAmount = $quote -> getStore() -> roundPrice($_SESSION['discountCoupon']);
               $discountAmount = $quote -> getStore() -> roundPrice(Mage::getSingleton('core/session')->getDiscountMessage());
    
         
		//$discountAmount = $quote -> getStore() -> roundPrice(Mage::getSingleton('core/session')->getDiscountMessage());
                //$this -> _setAmount($discountAmount) -> _setBaseAmount($_SESSION['baseDiscountCoupon']);
               
               $this -> _setAmount($discountAmount) -> _setBaseAmount(Mage::getSingleton('core/session')->getBasediscountcouponMessage());
               
                $address->setData('code_total',$discountAmount);
//$this -> _setAmount(Mage::getSingleton('core/session')->getDiscountMessage()) -> _setBaseAmount(Mage::getSingleton('core/session')->getDiscountMessage());
		
               // $address->setData('discount_total', Mage::getSingleton('core/session')->getDiscountMessage());
		return $this;
     }
    
    /**
     * Add discount totals information to address object
     * 
     * @param Mage_Sales_Model_Quote_Address $address 
     * @return Mage_Sales_Model_Quote_Address_Total_Shipping 
     */
     public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
         parent :: fetch($address);
         $amount = $address -> getTotalAmount($this -> getCode());
         if ($amount != 0){
             $address -> addTotal(array(
                     'code' => $this -> getCode(),
                     'title' => $this -> getLabel(),
                     'value' => $amount
                    ));
         }
        
         return $this;
     }
    
    /**
     * Get label
     * 
     * @return string 
     */
     public function getLabel()
    {
        // return Mage :: helper('order') -> __('Discount ('.$_REQUEST['coupon'].')');
         return Mage :: helper('order') -> __('Discount ');
    }
}