<?php

class Sareez_Ordercsv_Model_Mysql4_Ordercsv_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('ordercsv/ordercsv');
    }
}