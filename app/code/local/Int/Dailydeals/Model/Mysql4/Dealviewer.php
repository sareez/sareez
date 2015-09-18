<?php

class Int_Dailydeals_Model_Mysql4_Dealviewer extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the dailydeals_id refers to the key field in your database table.
        $this->_init('dailydeals/dealviewer', 'id');
    }
}