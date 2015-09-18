<?php

class Int_Dailydeals_Model_Dealviewer extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('dailydeals/dealviewer');
    }
}