<?php
/*
 * Developer: Rene Voorberg
 * Team site: http://cmsideas.net/
 * Support: http://support.cmsideas.net/
 * 
 *
*/


class Glace_Menu_Block_Adminhtml_Menu_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Initialize Tabs
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('category_info_tabs');
        $this->setDestElementId('category_tab_content');
        $this->setTitle(Mage::helper('catalog')->__('Category Data'));
        $this->setTemplate('widget/tabshoriz.phtml');
    }

    protected function _prepareLayout()
    {

        $this->addTab('general', array(
            'label'   => Mage::helper('menu')->__('General'),
            'content' => $this->getLayout()->createBlock(
                'menu/adminhtml_menu_tab_general',
                'menu.edit.general'
            )->toHtml(),
        ));

        return parent::_prepareLayout();
    }
}
