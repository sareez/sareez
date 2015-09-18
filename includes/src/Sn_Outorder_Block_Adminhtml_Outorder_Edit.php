<?php

class Sn_Outorder_Block_Adminhtml_Outorder_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'outorder';
        $this->_controller = 'adminhtml_outorder';
        
        $this->_updateButton('save', 'label', Mage::helper('outorder')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('outorder')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('outorder_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'outorder_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'outorder_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('outorder_data') && Mage::registry('outorder_data')->getId() ) {
            return Mage::helper('outorder')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('outorder_data')->getTitle()));
        } else {
            return Mage::helper('outorder')->__('Add Item');
        }
    }
}