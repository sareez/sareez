<?php
/*
 * Developer: Rene Voorberg
 * Team site: http://cmsideas.net/
 * Support: http://support.cmsideas.net/
 * 
 *
*/




class Glace_Menu_Model_Resource_Menu extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('menu/menu', 'menu_id');
    }

    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        if ($object->isObjectNew() && !$object->hasCreatedAt()) {
            $object->setCreatedAt(Mage::getSingleton('core/date')->gmtDate());
        }
        $object->setUpdatedAt(Mage::getSingleton('core/date')->gmtDate());

        return parent::_beforeSave($object);
    }

    protected function _afterSave(Mage_Core_Model_Abstract $object)
    {
        if (!$object->getIsMassStatus()) {
            $this->_saveStore($object);
        }

        if ($object->getSyncStore()) {
            $this->_syncStore($object);
        }

        return parent::_afterSave($object);
    }

    protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
        if (!$object->getIsMassDelete()) {
            $this->_loadStore($object);
        }

        return parent::_afterLoad($object);
    }

    protected function _loadStore(Mage_Core_Model_Abstract $object)
    {
        $select = $this->_getReadAdapter()->select()
            ->from($this->getTable('menu/menu_store'))
            ->where('menu_id = ?', $object->getId());

        if ($data = $this->_getReadAdapter()->fetchAll($select)) {
            $array = array();
            foreach ($data as $row) {
                $array[] = $row['store_id'];
            }
            $object->setData('store_ids', $array);
        }
        return $object;
    }

    protected function _saveStore(Mage_Core_Model_Abstract $object)
    {
        $adapter = $this->_getWriteAdapter();

        $condition = $adapter->quoteInto('menu_id = ?', $object->getId());
        $adapter->delete($this->getTable('menu/menu_store'), $condition);

        foreach ((array)$object->getData('store_ids') as $store) {
            $insert = array(
                'menu_id'  => $object->getId(),
                'store_id' => $store
            );
            $adapter->insert($this->getTable('menu/menu_store'), $insert);
        }
    }

    protected function _syncStore(Mage_Core_Model_Abstract $object)
    {
        $collection = Mage::getModel('menu/item')->getCollection()
            ->addFieldToFilter('menu_id', $object->getId());

        foreach ($collection as $item) {
            $item->setStoreIds($object->getStoreIds())
                ->save();
        }
    }
}