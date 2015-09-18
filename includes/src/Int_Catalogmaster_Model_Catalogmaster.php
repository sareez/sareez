<?php

class Int_Catalogmaster_Model_Catalogmaster extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('catalogmaster/catalogmaster');
    }
}