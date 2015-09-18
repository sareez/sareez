<?php

class Int_Catalogmaster_Block_Adminhtml_Producttype_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
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
      $fieldset = $form->addFieldset('catalogmaster_form', array('legend'=>Mage::helper('catalogmaster')->__('Item information')));
     
      $fieldset->addField('type', 'text', array(
          'label'     => Mage::helper('catalogmaster')->__('Product Type'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'type',
      ));
      
      
      $fieldset->addField('abbreviation', 'text', array(
          'label'     => Mage::helper('catalogmaster')->__('Products Abbreviation'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'abbreviation',
      ));
	
	 
  $fieldset->addField('description', 'textarea', array(
            'name'      => 'description',
            'label'     => Mage::helper('cms')->__('Description'),
            'title'     => Mage::helper('cms')->__('Description'),
            'style'     => 'height:16em',           
            'config'    => Mage::getSingleton('cms/wysiwyg_config')->getConfig()
        ));
	  
	  
	
		
      $fieldset->addField('type_status', 'select', array(
          'label'     => Mage::helper('catalogmaster')->__('Status'),
          'name'      => 'type_status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('catalogmaster')->__('Enabled'),
              ),

              array(
                  'value'     => 0,
                  'label'     => Mage::helper('catalogmaster')->__('Disabled'),
              ),
          ),
      ));
     
    
     
      if ( Mage::getSingleton('adminhtml/session')->getCatalogmasterData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getCatalogmasterData());
          Mage::getSingleton('adminhtml/session')->setCatalogmasterData(null);
      } elseif ( Mage::registry('producttype_data') ) {
          $form->setValues(Mage::registry('producttype_data')->getData());
      }
      return parent::_prepareForm();
  }
}