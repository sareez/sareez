<?php

class LatestTrendingDesigns_LatestTrendingDesigns_Model_Mysql4_LatestTrendingDesigns extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the latesttrendingdesigns_id refers to the key field in your database table.
        $this->_init('latesttrendingdesigns/latesttrendingdesigns', 'latesttrendingdesigns_id');
    }
}