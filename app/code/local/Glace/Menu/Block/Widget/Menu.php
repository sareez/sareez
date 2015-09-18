<?php
/*
 * Developer: Rene Voorberg
 * Team site: http://cmsideas.net/
 * Support: http://support.cmsideas.net/
 * 
 *
*/


class Glace_Menu_Block_Widget_Menu extends Glace_Menu_Block_Menu implements Mage_Widget_Block_Interface
{
    public function _prepareLayout()
    {
        $this->setMenuCode($this->getData('menu_code'));

        return parent::_prepareLayout();
    }
}