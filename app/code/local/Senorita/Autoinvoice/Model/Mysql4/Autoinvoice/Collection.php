<?php

class Senorita_Autoinvoice_Model_Mysql4_Autoinvoice_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('autoinvoice/autoinvoice');
    }
}