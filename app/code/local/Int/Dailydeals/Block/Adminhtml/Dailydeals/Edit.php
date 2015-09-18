<?php

class Int_Dailydeals_Block_Adminhtml_Dailydeals_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'dailydeals';
        $this->_controller = 'adminhtml_dailydeals';
        
        $this->_updateButton('save', 'label', Mage::helper('dailydeals')->__('Save Deal'));
        $this->_updateButton('delete', 'label', Mage::helper('dailydeals')->__('Delete Deal'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('dailydeals_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'dailydeals_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'dailydeals_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('dailydeals_data') && Mage::registry('dailydeals_data')->getId() ) {
            return Mage::helper('dailydeals')->__("Edit Deal '%s'", $this->htmlEscape(Mage::registry('dailydeals_data')->getTitle()));
        } else {
            return Mage::helper('dailydeals')->__('Add Deal');
        }
    }
}