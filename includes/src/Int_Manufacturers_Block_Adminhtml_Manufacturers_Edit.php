<?php

class Int_Manufacturers_Block_Adminhtml_Manufacturers_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
   
  protected function _prepareLayout() {
	parent::_prepareLayout();
	if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
		$this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
	}
}

   public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'manufacturers';
        $this->_controller = 'adminhtml_manufacturers';
        
        $this->_updateButton('save', 'label', Mage::helper('manufacturers')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('manufacturers')->__('Delete Item'));
		
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
        if( Mage::registry('manufacturers_data') && Mage::registry('manufacturers_data')->getId() ) {
            return Mage::helper('manufacturers')->__("Edit Manufacturer '%s'", $this->htmlEscape(Mage::registry('manufacturers_data')->getManufacturers_name()));
        } else {
            return Mage::helper('manufacturers')->__('Add Manufacturer');
        }
    }
    
}