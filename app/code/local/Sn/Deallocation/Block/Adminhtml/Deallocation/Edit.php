<?php

class Sn_Deallocation_Block_Adminhtml_Deallocation_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'deallocation';
        $this->_controller = 'adminhtml_deallocation';
        
        $this->_updateButton('save', 'label', Mage::helper('deallocation')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('deallocation')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('deallocation_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'deallocation_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'deallocation_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('deallocation_data') && Mage::registry('deallocation_data')->getId() ) {
            return Mage::helper('deallocation')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('deallocation_data')->getTitle()));
        } else {
            return Mage::helper('deallocation')->__('Add Item');
        }
    }
}