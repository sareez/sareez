<?php

class Int_Measurement_Model_Mysql4_Measurementforreadymade_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('measurement/measurementforreadymade');
    }
}