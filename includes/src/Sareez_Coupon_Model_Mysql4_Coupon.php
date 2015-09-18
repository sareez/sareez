<?php

class Sareez_Coupon_Model_Mysql4_Coupon extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the coupon_id refers to the key field in your database table.
        $this->_init('coupon/coupon', 'coupon_id');
    }
}