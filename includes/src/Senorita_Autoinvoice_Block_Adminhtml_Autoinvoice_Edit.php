<?php

class Senorita_Autoinvoice_Block_Adminhtml_Autoinvoice_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'autoinvoice';
        $this->_controller = 'adminhtml_autoinvoice';
        
        $this->_updateButton('save', 'label', Mage::helper('autoinvoice')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('autoinvoice')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('autoinvoice_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'autoinvoice_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'autoinvoice_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('autoinvoice_data') && Mage::registry('autoinvoice_data')->getId() ) {
            return Mage::helper('autoinvoice')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('autoinvoice_data')->getTitle()));
        } else {
            return Mage::helper('autoinvoice')->__('Add Item');
        }
    }
}