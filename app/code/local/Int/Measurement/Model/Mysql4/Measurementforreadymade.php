<?php

class Int_Measurement_Model_Mysql4_Measurementforreadymade extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the measurement_id refers to the key field in your database table.
        $this->_init('measurement/measurementforreadymade', 'readymade_id');
    }
}