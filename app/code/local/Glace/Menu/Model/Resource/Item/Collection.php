<?php
/*
 * Developer: Rene Voorberg
 * Team site: http://cmsideas.net/
 * Support: http://support.cmsideas.net/
 * 
 *
*/




class Glace_Menu_Model_Resource_Item_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('menu/item');
    }

    public function addStoreFilter($store)
    {
        if (!Mage::app()->isSingleStoreMode()) {
            if ($store instanceof Mage_Core_Model_Store) {
                $store = array($store->getId());
            }

            $this->getSelect()
                ->joinLeft(array('store_table' => $this->getTable('menu/item_store')),
                        'main_table.item_id = store_table.item_id', array())
                ->where('store_table.store_id in (?)', array(0, $store));
            return $this;
        }
        return $this;
    }

    protected function _afterLoad()
    {
        parent::_afterLoad();

        foreach ($this->_items as $item) {
            $item->getResource()->_afterLoad($item);
        }

        return $this;
    }
}