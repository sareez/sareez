<?php
/*
 * Developer: Rene Voorberg
 * Team site: http://cmsideas.net/
 * Support: http://support.cmsideas.net/
 * 
 *
*/


class Glace_Menu_Block_Adminhtml_Menu_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId    = 'entity_id';
        $this->_blockGroup  = 'menu';
        $this->_controller  = 'adminhtml_menu';
        $this->_mode        = 'edit';

        parent::__construct();
        $this->setTemplate('glace/menu/edit.phtml');
    }
}
