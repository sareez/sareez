<?php
/**
* 
* Do not edit or add to this file if you wish to upgrade the module to newer
* versions in the future. If you wish to customize the module for your 
* needs please contact us to https://www.milople.com/magento-extensions/contact-us.html 
* 
* @category    Ecommerce
* @package     Indies_Whatsappshare
* @copyright   Copyright (c) 2015 Milople Technologies Pvt. Ltd. All Rights Reserved.
* @url	       https://www.milople.com/magento-extensions/whatsapp-share.html
*
* Milople was known as Indies Services earlier.
*
*/

class Indies_Whatsappshare_Block_Adminhtml_Whatsappshare_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'whatsappshare';
        $this->_controller = 'adminhtml_whatsappshare';
        
        $this->_updateButton('save', 'label', Mage::helper('whatsappshare')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('whatsappshare')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('whatsappshare_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'whatsappshare_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'whatsappshare_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('whatsappshare_data') && Mage::registry('whatsappshare_data')->getId() ) {
            return Mage::helper('whatsappshare')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('whatsappshare_data')->getTitle()));
        } else {
            return Mage::helper('whatsappshare')->__('Add Item');
        }
    }
}