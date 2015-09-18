<?php

class Senorita_Tailormaster_Model_Mysql4_Tailormaster_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('tailormaster/tailormaster');
    }
}