<?php

class Int_Catalogmaster_Model_Mysql4_Catalogmaster_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('catalogmaster/catalogmaster');
    }
}