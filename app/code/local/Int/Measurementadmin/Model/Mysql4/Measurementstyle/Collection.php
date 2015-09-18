<?php

class Int_Measurementadmin_Model_Mysql4_Measurementstyle_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('measurementadmin/measurementstyle');
    }
}