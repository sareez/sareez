<?php

class Int_Magetooscommerce_Model_Magetooscommerce extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('magetooscommerce/magetooscommerce');
    }
}