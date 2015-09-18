<?php
class Sareez_Order_Model_Newordertotalobserver
{
	 public function saveDiscountTotal(Varien_Event_Observer $observer)
    {
         $order = $observer -> getEvent() -> getOrder();
         $quote = $observer -> getEvent() -> getQuote();
         $shippingAddress = $quote -> getShippingAddress();
         if($shippingAddress && $shippingAddress -> getData('discount_total')){
             $order -> setData('discount_total', $shippingAddress -> getData('discount_total'));
             }
        else{
             $billingAddress = $quote -> getBillingAddress();
             $order -> setData('discount_total', $billingAddress -> getData('discount_total'));
             }
         $order -> save();
     }
    
     public function saveDiscountTotalForMultishipping(Varien_Event_Observer $observer)
    {
         $order = $observer -> getEvent() -> getOrder();
         $address = $observer -> getEvent() -> getAddress();
         $order -> setData('discount_total', $shippingAddress -> getData('discount_total'));
		 $order -> save();
     }
}