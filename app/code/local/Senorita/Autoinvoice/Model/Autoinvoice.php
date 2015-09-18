<?php

class Senorita_Autoinvoice_Model_Autoinvoice extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('autoinvoice/autoinvoice');
    }
}