<?php

class Last_Viewed_Block_Adminhtml_Viewed_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'viewed';
        $this->_controller = 'adminhtml_viewed';
        
        $this->_updateButton('save', 'label', Mage::helper('viewed')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('viewed')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('viewed_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'viewed_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'viewed_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('viewed_data') && Mage::registry('viewed_data')->getId() ) {
            return Mage::helper('viewed')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('viewed_data')->getTitle()));
        } else {
            return Mage::helper('viewed')->__('Add Item');
        }
    }
}