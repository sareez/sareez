<?php
/*
 * Developer: Rene Voorberg
 * Team site: http://cmsideas.net/
 * Support: http://support.cmsideas.net/
 * 
 *
*/


class Glace_Menu_Block_Adminhtml_Item_Tabs_Row extends Glace_Menu_Block_Adminhtml_Item_Tabs
{
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        if (Mage::helper('menu')->isTabAllowed(Glace_Menu_Model_Item_Type::TYPE_ROW)) {
            $this->addTab('design', array(
                'label'   => Mage::helper('menu')->__('Custom Design'),
                'content' => $this->getLayout()->createBlock('menu/adminhtml_item_tab_row_design')->toHtml(),
            ));
        }

        return $this;
    }
}