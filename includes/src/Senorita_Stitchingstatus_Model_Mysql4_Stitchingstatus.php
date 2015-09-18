<?php

class Senorita_Stitchingstatus_Model_Mysql4_Stitchingstatus extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the stitchingstatus_id refers to the key field in your database table.
        $this->_init('stitchingstatus/stitchingstatus', 'stitchingstatus_id');
    }
}