<?php

class MostView_MostPurchased_Model_MostPurchased extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('mostpurchased/mostpurchased');
    }
}