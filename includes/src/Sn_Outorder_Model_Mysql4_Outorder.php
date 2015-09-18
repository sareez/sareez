<?php

class Sn_Outorder_Model_Mysql4_Outorder extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the outorder_id refers to the key field in your database table.
        $this->_init('outorder/outorder', 'outorder_id');
    }
}