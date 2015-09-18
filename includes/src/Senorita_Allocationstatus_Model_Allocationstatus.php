<?php

class Senorita_Allocationstatus_Model_Allocationstatus extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('allocationstatus/allocationstatus');
    }
}