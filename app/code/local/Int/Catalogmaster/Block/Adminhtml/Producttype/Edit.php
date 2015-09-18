<?php

class Int_Catalogmaster_Block_Adminhtml_Producttype_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
   
 

   public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'catalogmaster';
        $this->_controller = 'adminhtml_producttype';
        
        $this->_updateButton('save', 'label', Mage::helper('catalogmaster')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('catalogmaster')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('block_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'block_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'block_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('producttype_data') && Mage::registry('producttype_data')->getId() ) {
            return Mage::helper('catalogmaster')->__("Edit Product Type '%s'", $this->htmlEscape(Mage::registry('producttype_data')->getType()));
        } else {
            return Mage::helper('catalogmaster')->__('Add Product Type');
        }
    }
    
}