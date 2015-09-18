<?php

class Sn_Sorder_Model_Sorder extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('sorder/sorder');
    }
}