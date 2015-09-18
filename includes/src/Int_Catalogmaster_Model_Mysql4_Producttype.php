<?php

class Int_Catalogmaster_Model_Mysql4_Producttype extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the catalogmaster_id refers to the key field in your database table.
        $this->_init('catalogmaster/producttype', 'p_type_id');
    }
}