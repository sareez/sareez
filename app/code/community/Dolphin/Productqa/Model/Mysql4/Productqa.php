<?php

class Dolphin_Productqa_Model_Mysql4_Productqa extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the productqa_id refers to the key field in your database table.
        $this->_init('productqa/productqa', 'productqa_id');
    }
}