<?php

class Senorita_Tailormaster_Model_Tailormaster extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('tailormaster/tailormaster');
    }
}