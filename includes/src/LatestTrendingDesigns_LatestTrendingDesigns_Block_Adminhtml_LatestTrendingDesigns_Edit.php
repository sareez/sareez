<?php

class LatestTrendingDesigns_LatestTrendingDesigns_Block_Adminhtml_LatestTrendingDesigns_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'latesttrendingdesigns';
        $this->_controller = 'adminhtml_latesttrendingdesigns';
        
        $this->_updateButton('save', 'label', Mage::helper('latesttrendingdesigns')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('latesttrendingdesigns')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('latesttrendingdesigns_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'latesttrendingdesigns_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'latesttrendingdesigns_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('latesttrendingdesigns_data') && Mage::registry('latesttrendingdesigns_data')->getId() ) {
            return Mage::helper('latesttrendingdesigns')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('latesttrendingdesigns_data')->getTitle()));
        } else {
            return Mage::helper('latesttrendingdesigns')->__('Add Item');
        }
    }
}