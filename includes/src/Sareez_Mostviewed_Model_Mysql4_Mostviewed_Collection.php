<?php

class Sareez_Mostviewed_Model_Mysql4_Mostviewed_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('mostviewed/mostviewed');
    }
}