<?php

class Sn_Outorder_Model_Mysql4_Outorder_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('outorder/outorder');
    }
}