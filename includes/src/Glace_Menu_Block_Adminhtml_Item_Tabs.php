<?php
/*
 * Developer: Rene Voorberg
 * Team site: http://cmsideas.net/
 * Support: http://support.cmsideas.net/
 * 
 *
*/


class Glace_Menu_Block_Adminhtml_Item_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Initialize Tabs
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('item_info_tabs');
        $this->setDestElementId('item_tab_content');
        $this->setTitle(Mage::helper('menu')->__('Item Data'));
        $this->setTemplate('widget/tabshoriz.phtml');
    }

    protected function _prepareLayout()
    {
        $this->addTab('general', array(
            'label'   => Mage::helper('menu')->__('General'),
            'content' => $this->getLayout()->createBlock(
                'menu/adminhtml_item_tab_general',
                'item.edit.general'
            )->toHtml(),
        ));

        return parent::_prepareLayout();
    }
}
