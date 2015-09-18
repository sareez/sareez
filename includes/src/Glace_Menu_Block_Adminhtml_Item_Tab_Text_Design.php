<?php
/*
 * Developer: Rene Voorberg
 * Team site: http://cmsideas.net/
 * Support: http://support.cmsideas.net/
 * 
 *
*/

class Glace_Menu_Block_Adminhtml_Item_Tab_Text_Design extends Mage_Adminhtml_Block_Widget_Form
{
    public function _prepareLayout()
    {
        parent::_prepareLayout();
        $form = new Varien_Data_Form();
        $model = Mage::registry('current_item');

        $set = $form->addFieldset('design', array('legend'=>Mage::helper('menu')->__('Custom Design')));

        $set->addField('background', 'color', array(
            'label' => Mage::helper('menu')->__('Background'),
            'name'  => 'attr[background]',
            'value' => $model->getAttr('background'),
        ));

        $this->setForm($form);
    }

}

