<?php

class Int_Manufacturers_Model_Manufacturers extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('manufacturers/manufacturers');
    }
}