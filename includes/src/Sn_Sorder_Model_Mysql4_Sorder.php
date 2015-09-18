<?php

class Sn_Sorder_Model_Mysql4_Sorder extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the id refers to the key field in your database table.
        $this->_init('sorder/sorder', 'id');
    }
}