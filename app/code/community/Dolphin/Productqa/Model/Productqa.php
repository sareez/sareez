<?php

class Dolphin_Productqa_Model_Productqa extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('productqa/productqa');
    }
}