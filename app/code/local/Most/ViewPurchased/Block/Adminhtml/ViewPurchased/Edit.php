<?php

class Most_ViewPurchased_Block_Adminhtml_ViewPurchased_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'viewpurchased';
        $this->_controller = 'adminhtml_viewpurchased';
        
        $this->_updateButton('save', 'label', Mage::helper('viewpurchased')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('viewpurchased')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('viewpurchased_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'viewpurchased_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'viewpurchased_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('viewpurchased_data') && Mage::registry('viewpurchased_data')->getId() ) {
            return Mage::helper('viewpurchased')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('viewpurchased_data')->getTitle()));
        } else {
            return Mage::helper('viewpurchased')->__('Add Item');
        }
    }
}