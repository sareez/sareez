<?php

class Int_Measurement_Model_Measurement extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('measurement/measurement');
    }
}