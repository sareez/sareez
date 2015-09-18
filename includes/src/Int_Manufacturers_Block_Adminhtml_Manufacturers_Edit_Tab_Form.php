<?php

class Int_Manufacturers_Block_Adminhtml_Manufacturers_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{


    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
    }
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('manufacturers_form', array('legend'=>Mage::helper('manufacturers')->__('Item information')));
     
      $fieldset->addField('manufacturers_name', 'text', array(
          'label'     => Mage::helper('manufacturers')->__('Manufacturers name'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'manufacturers_name',
      ));
	  
	  $fieldset->addField('manufacturers_email', 'text', array(
          'label'     => Mage::helper('manufacturers')->__('Manufacturers Email'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'manufacturers_email',
      ));
	  
	 $fieldset->addField('manufacturers_phone', 'text', array(
          'label'     => Mage::helper('manufacturers')->__('Manufacturers Phone'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'manufacturers_phone',
      ));
	
	  $fieldset->addField('manufacturers_url', 'text', array(
          'label'     => Mage::helper('manufacturers')->__('Manufacturers Url'),
          'required'  => false,
          'name'      => 'manufacturers_url',
      ));
	
	  $fieldset->addField('manufacturers_image', 'image', array(
          'label'     => Mage::helper('manufacturers')->__('File'),
          'required'  => false,
          'name'      => 'manufacturers_image',
	  ));
	 
 $fieldset->addField('manufacturers_address', 'textarea', array(
            'name'      => 'manufacturers_address',
            'label'     => Mage::helper('cms')->__('Address'),
            'title'     => Mage::helper('cms')->__('Address'),
            'style'     => 'height:36em',
            'required'  => false,
            'config'    => Mage::getSingleton('cms/wysiwyg_config')->getConfig()
        ));
		
		$fieldset->addField('manufacturers_htc_title_tag', 'textarea', array(
            'name'      => 'manufacturers_htc_title_tag',
            'label'     => Mage::helper('cms')->__('Meta Title'),
            'title'     => Mage::helper('cms')->__('Meta Title'),
            'style'     => 'height:17em',
            'required'  => false,
            'config'    => Mage::getSingleton('cms/wysiwyg_config')->getConfig()
        ));
		
		$fieldset->addField('manufacturers_htc_desc_tag', 'textarea', array(
            'name'      => 'manufacturers_htc_desc_tag',
            'label'     => Mage::helper('cms')->__('Meta Description'),
            'title'     => Mage::helper('cms')->__('Meta Description'),
            'style'     => 'height:17em',
            'required'  => false,
            'config'    => Mage::getSingleton('cms/wysiwyg_config')->getConfig()
        ));
		
		$fieldset->addField('manufacturers_htc_keywords_tag', 'textarea', array(
            'name'      => 'manufacturers_htc_keywords_tag',
            'label'     => Mage::helper('cms')->__('Meta Keywords'),
            'title'     => Mage::helper('cms')->__('Meta Keywords'),
            'style'     => 'height:17em',
            'required'  => false,
            'config'    => Mage::getSingleton('cms/wysiwyg_config')->getConfig()
        ));
	  
	  
	
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('manufacturers')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('manufacturers')->__('Enabled'),
              ),

              array(
                  'value'     => 0,
                  'label'     => Mage::helper('manufacturers')->__('Disabled'),
              ),
          ),
      ));
     
    
     
      if ( Mage::getSingleton('adminhtml/session')->getManufacturersData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getManufacturersData());
          Mage::getSingleton('adminhtml/session')->setManufacturersData(null);
      } elseif ( Mage::registry('manufacturers_data') ) {
          $form->setValues(Mage::registry('manufacturers_data')->getData());
      }
      return parent::_prepareForm();
  }
}