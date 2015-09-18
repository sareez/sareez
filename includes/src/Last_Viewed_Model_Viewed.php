<?php

class Last_Viewed_Model_Viewed extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('viewed/viewed');
    }
}