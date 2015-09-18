<?php

class Sareez_Ordercsv_Model_Ordercsv extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('ordercsv/ordercsv');
    }
}