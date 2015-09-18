<?php

class Int_Measurementadmin_Block_Measurement_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'measurementadmin';
        $this->_controller = 'measurement';
        
        $this->_updateButton('save', 'label', Mage::helper('measurementadmin')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('measurementadmin')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('measurement_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'measurement_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'measurement_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('measurementadmin_data') && Mage::registry('measurementadmin_data')->getId() ) {
            return Mage::helper('measurementadmin')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('measurementadmin_data')->getTitle()));
        } else {
            return Mage::helper('measurementadmin')->__('Add Item');
        }
    }
}
