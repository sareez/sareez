<?php

class Senorita_Tailormaster_Model_Mysql4_Tailormaster extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the tailormaster_id refers to the key field in your database table.
        $this->_init('tailormaster/tailormaster', 'tailormaster_id');
    }
}