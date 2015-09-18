<?php

class Sareez_Ordercsv_Model_Mysql4_Ordercsv extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the ordercsv_id refers to the key field in your database table.
        $this->_init('ordercsv/ordercsv', 'ordercsv_id');
    }
}