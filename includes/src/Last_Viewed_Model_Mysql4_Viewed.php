<?php

class Last_Viewed_Model_Mysql4_Viewed extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the viewed_id refers to the key field in your database table.
        $this->_init('viewed/viewed', 'viewed_id');
    }
}