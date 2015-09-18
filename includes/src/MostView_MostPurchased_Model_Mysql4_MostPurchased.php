<?php

class MostView_MostPurchased_Model_Mysql4_MostPurchased extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the mostpurchased_id refers to the key field in your database table.
        $this->_init('mostpurchased/mostpurchased', 'mostpurchased_id');
    }
}