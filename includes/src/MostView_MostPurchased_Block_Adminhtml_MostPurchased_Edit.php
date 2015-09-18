<?php

class MostView_MostPurchased_Block_Adminhtml_MostPurchased_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'mostpurchased';
        $this->_controller = 'adminhtml_mostpurchased';
        
        $this->_updateButton('save', 'label', Mage::helper('mostpurchased')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('mostpurchased')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('mostpurchased_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'mostpurchased_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'mostpurchased_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('mostpurchased_data') && Mage::registry('mostpurchased_data')->getId() ) {
            return Mage::helper('mostpurchased')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('mostpurchased_data')->getTitle()));
        } else {
            return Mage::helper('mostpurchased')->__('Add Item');
        }
    }
}