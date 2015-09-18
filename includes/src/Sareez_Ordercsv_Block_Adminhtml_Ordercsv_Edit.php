<?php

class Sareez_Ordercsv_Block_Adminhtml_Ordercsv_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'ordercsv';
        $this->_controller = 'adminhtml_ordercsv';
        
        $this->_updateButton('save', 'label', Mage::helper('ordercsv')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('ordercsv')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('ordercsv_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'ordercsv_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'ordercsv_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('ordercsv_data') && Mage::registry('ordercsv_data')->getId() ) {
            return Mage::helper('ordercsv')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('ordercsv_data')->getTitle()));
        } else {
            return Mage::helper('ordercsv')->__('Add Item');
        }
    }
}