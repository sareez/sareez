<?php

class Sareez_Coupon_Block_Adminhtml_Coupon_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'coupon';
        $this->_controller = 'adminhtml_coupon';
        
        $this->_updateButton('save', 'label', Mage::helper('coupon')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('coupon')->__('Delete Item'));
		
        
//        $this->_addButton('saveandcontinue', array(
//            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
//            'onclick'   => 'saveAndContinueEdit()',
//            'class'     => 'save',
//        ), -100);

        
        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('coupon_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'coupon_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'coupon_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('coupon_data') && Mage::registry('coupon_data')->getId() ) {
            return Mage::helper('coupon')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('coupon_data')->getTitle()));
        } else {
            return Mage::helper('coupon')->__('Add Item');
        }
    }
}