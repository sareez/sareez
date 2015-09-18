<?php

class Int_Manufacturers_Model_Mysql4_Manufacturers extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the manufacturers_id refers to the key field in your database table.
        $this->_init('manufacturers/manufacturers', 'manufacturers_id');
    }
}