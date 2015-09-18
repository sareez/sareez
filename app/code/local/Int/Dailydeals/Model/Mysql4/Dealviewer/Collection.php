<?php

class Int_Dailydeals_Model_Mysql4_Dealviewer_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('dailydeals/dealviewer');
    }
}