<?php

class Sn_Outorder_Model_Outorder extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('outorder/outorder');
    }
}