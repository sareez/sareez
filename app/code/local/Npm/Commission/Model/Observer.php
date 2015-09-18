<?php
class Npm_Commission_Model_Observer extends Varien_Event_Observer
{
    public function calculate_commission($observer)
    {
        $order = $observer->getEvent()->getOrder();

        if (!$order) {
            return $this;
        }
        
       // $conn = mysql_connect("localhost","root","rootwdp") or die("ERROR::Not connected to SERVER"); 
//$db = mysql_select_db("sareees_db",$conn) or die("ERROR::Not connected to DATABASE");
        
////////////////////////////////////////
      //  mysql_query("insert into designs set title = 'asd'");
///////////////////////////////////////        
        
        //die('sales_order_place_after');
         Mage::log('sales_order_place_after');
        //$params = $observer->getEvent()->getOrder;
         Mage::log(print_r($order->getData('increament_id'),true));
        //echo "<pre>";print_r($params);die();
    }
}