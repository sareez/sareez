<?php

class Sn_Deallocation_Model_Deallocation extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('deallocation/deallocation');
    }
}