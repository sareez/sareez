<?php

class Most_ViewPurchased_Model_ViewPurchased extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('viewpurchased/viewpurchased');
    }
}