<?php
/*
 * Developer: Rene Voorberg
 * Team site: http://cmsideas.net/
 * Support: http://support.cmsideas.net/
 * 
 *
*/


class Glace_Menu_Model_Menu extends Mage_Core_Model_Abstract
{
    const ENTITY    = 'MENU';
    const CACHE_TAG = 'MENU';

    protected $_cacheTag =  self::CACHE_TAG;

    protected function _construct()
    {
        $this->_init('menu/menu');
    }

    public function getChildren($store = null)
    {
        $collection = Mage::getModel('menu/item')->getCollection()
            ->addFieldToFilter('menu_id', $this->getId())
            ->addFieldToFilter('parent_id', array('null' => 1))
            ->addFieldToFilter('level', 1)
            ->setOrder('position', 'asc');

        if ($store) {
            $collection->addStoreFilter($store);
        }

        return $collection;
    }

    public function getChildrenCount()
    {
        return $this->getChildren()->count();
    }

    public function hasChildren()
    {
        return $this->getChildrenCount() > 0 ? 1 : 0;
    }

    public function getTemplatePath()
    {
        if (!$this->getTemplate()) {
            $this->setTemplate('default');
        }

        if ($this->getTemplate()) {
            return 'glace/menu/'.$this->getTemplate().'/menu.phtml';
        }
    }
}