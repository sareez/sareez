<?php

class Int_Measurementadmin_Model_Mysql4_Measurementstyle extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the measurement_id refers to the key field in your database table.
        $this->_init('measurementadmin/measurementstyle', 'style_id');
    }
}