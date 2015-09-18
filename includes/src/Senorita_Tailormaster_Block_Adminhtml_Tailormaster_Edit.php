<?php

class Senorita_Tailormaster_Block_Adminhtml_Tailormaster_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'tailormaster';
        $this->_controller = 'adminhtml_tailormaster';
        
        $this->_updateButton('save', 'label', Mage::helper('tailormaster')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('tailormaster')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('tailormaster_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'tailormaster_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'tailormaster_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('tailormaster_data') && Mage::registry('tailormaster_data')->getId() ) {
            return Mage::helper('tailormaster')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('tailormaster_data')->getTitle()));
        } else {
            return Mage::helper('tailormaster')->__('Add Item');
        }
    }
}