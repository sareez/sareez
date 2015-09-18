<?php

class Senorita_Stitchingstatus_Block_Adminhtml_Stitchingstatus_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'stitchingstatus';
        $this->_controller = 'adminhtml_stitchingstatus';
        
        $this->_updateButton('save', 'label', Mage::helper('stitchingstatus')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('stitchingstatus')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('stitchingstatus_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'stitchingstatus_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'stitchingstatus_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('stitchingstatus_data') && Mage::registry('stitchingstatus_data')->getId() ) {
            return Mage::helper('stitchingstatus')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('stitchingstatus_data')->getTitle()));
        } else {
            return Mage::helper('stitchingstatus')->__('Add Item');
        }
    }
}