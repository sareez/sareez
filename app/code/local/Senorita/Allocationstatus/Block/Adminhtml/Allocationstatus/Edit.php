<?php

class Senorita_Allocationstatus_Block_Adminhtml_Allocationstatus_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'allocationstatus';
        $this->_controller = 'adminhtml_allocationstatus';
        
        $this->_updateButton('save', 'label', Mage::helper('allocationstatus')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('allocationstatus')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('allocationstatus_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'allocationstatus_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'allocationstatus_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('allocationstatus_data') && Mage::registry('allocationstatus_data')->getId() ) {
            return Mage::helper('allocationstatus')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('allocationstatus_data')->getTitle()));
        } else {
            return Mage::helper('allocationstatus')->__('Add Item');
        }
    }
}