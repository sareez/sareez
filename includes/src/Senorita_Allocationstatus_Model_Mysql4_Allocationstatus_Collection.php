<?php

class Senorita_Allocationstatus_Model_Mysql4_Allocationstatus_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('allocationstatus/allocationstatus');
    }
}