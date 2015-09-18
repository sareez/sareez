<?php

class Sn_Deallocation_Model_Mysql4_Deallocation extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the deallocation_id refers to the key field in your database table.
        $this->_init('deallocation/deallocation', 'deallocation_id');
    }
}