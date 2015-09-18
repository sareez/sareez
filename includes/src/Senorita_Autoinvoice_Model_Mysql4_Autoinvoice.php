<?php

class Senorita_Autoinvoice_Model_Mysql4_Autoinvoice extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the autoinvoice_id refers to the key field in your database table.
        $this->_init('autoinvoice/autoinvoice', 'autoinvoice_id');
    }
}