<?php

class Sareez_Mostviewed_Model_Mysql4_Mostviewed extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the mostviewed_id refers to the key field in your database table.
        $this->_init('mostviewed/mostviewed', 'mostviewed_id');
    }
}