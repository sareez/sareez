<?php
/*
 * Developer: Rene Voorberg
 * Team site: http://cmsideas.net/
 * Support: http://support.cmsideas.net/
 * 
 *
*/


class Glace_Menu_Block_Adminhtml_Menu_Switcher extends Mage_Adminhtml_Block_Template
{
    protected $_menuVarName = 'menu_id';

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('glace/menu/switcher.phtml');
        $this->setUseConfirm(true);
        $this->setUseAjax(true);
    }

    public function getMenuCollection()
    {
       return Mage::getModel('menu/menu')->getCollection();
    }

    public function getMenuId()
    {
        return $this->getRequest()->getParam($this->_menuVarName);
    }

    public function getSwitchUrl()
    {
        return $this->getUrl('*/*/*', array('_current' => false, $this->_menuVarName => null));
    }

    protected function _toHtml()
    {
        return parent::_toHtml();
    }
}
