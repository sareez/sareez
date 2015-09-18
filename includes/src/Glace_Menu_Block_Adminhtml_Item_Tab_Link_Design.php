<?php
/*
 * Developer: Rene Voorberg
 * Team site: http://cmsideas.net/
 * Support: http://support.cmsideas.net/
 * 
 *
*/


class Glace_Menu_Block_Adminhtml_Item_Tab_Link_Design extends Mage_Adminhtml_Block_Widget_Form
{
    public function _prepareLayout()
    {
        parent::_prepareLayout();
        $form = new Varien_Data_Form();
        $model = Mage::registry('current_item');

        $set = $form->addFieldset('design', array('legend'=>Mage::helper('menu')->__('Custom Design')));


        //css class
        //font size
        //font weight
        //color
        //background color

        $set->addField('css', 'text', array(
            'label' => Mage::helper('menu')->__('Css Class'),
            'name'  => 'attr[css_class]',
            'value' => $model->getAttr('css_class'),
        ));

        $set->addField('color', 'color', array(
            'label' => Mage::helper('menu')->__('Color'),
            'name'  => 'attr[color]',
            'value' => $model->getAttr('color'),
        ));

        $set->addField('background', 'color', array(
            'label' => Mage::helper('menu')->__('Background'),
            'name'  => 'attr[background]',
            'value' => $model->getAttr('background'),
        ));

        $set->addField('fontsize', 'fontsize', array(
            'label' => Mage::helper('menu')->__('Font Size'),
            'name'  => 'attr[fontsize]',
            'value' => $model->getAttr('fontsize'),
        ));

        $set->addField('fontweight', 'fontweight', array(
            'label' => Mage::helper('menu')->__('Font Weight'),
            'name'  => 'attr[fontweight]',
            'value' => $model->getAttr('fontweight'),
        ));

        $set->addField('header', 'headerstyle', array(
            'label'    => Mage::helper('menu')->__('Style'),
            'name'     => 'attr[headerstyle]',
            'value'    => $model->getAttr('headerstyle'),
            'required' => false,
        ));

        $this->setForm($form);
    }

}

