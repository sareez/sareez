<?php

class Most_ViewPurchased_Model_Mysql4_ViewPurchased extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the viewpurchased_id refers to the key field in your database table.
        $this->_init('viewpurchased/viewpurchased', 'viewpurchased_id');
    }
}