<?php

class Last_Viewed_Model_Mysql4_Viewed_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('viewed/viewed');
    }
}