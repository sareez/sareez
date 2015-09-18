<?php

class Sn_Sorder_Block_Adminhtml_Sorder_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'sorder';
        $this->_controller = 'adminhtml_sorder';
        
        $this->_updateButton('save', 'label', Mage::helper('sorder')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('sorder')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('sorder_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'sorder_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'sorder_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('sorder_data') && Mage::registry('sorder_data')->getId() ) {
            return Mage::helper('sorder')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('sorder_data')->getTitle()));
        } else {
            return Mage::helper('sorder')->__('Add Item');
        }
    }
}