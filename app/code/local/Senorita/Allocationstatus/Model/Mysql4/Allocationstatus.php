<?php

class Senorita_Allocationstatus_Model_Mysql4_Allocationstatus extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the allocationstatus_id refers to the key field in your database table.
        $this->_init('allocationstatus/allocationstatus', 'allocationstatus_id');
    }
}