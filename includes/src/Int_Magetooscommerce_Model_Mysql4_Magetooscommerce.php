<?php

class Int_Magetooscommerce_Model_Mysql4_Magetooscommerce extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the magetooscommerce_id refers to the key field in your database table.
        $this->_init('magetooscommerce/magetooscommerce', 'magetooscommerce_id');
    }
}