<?php

class Sareez_Mostviewed_Model_Mostviewed extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('mostviewed/mostviewed');
    }
}