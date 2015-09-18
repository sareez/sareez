<?php

class Senorita_Autoinvoice_Block_Adminhtml_Autoinvoice_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('autoinvoice_form', array('legend'=>Mage::helper('autoinvoice')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('autoinvoice')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('autoinvoice')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('autoinvoice')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('autoinvoice')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('autoinvoice')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('autoinvoice')->__('Content'),
          'title'     => Mage::helper('autoinvoice')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getAutoinvoiceData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getAutoinvoiceData());
          Mage::getSingleton('adminhtml/session')->setAutoinvoiceData(null);
      } elseif ( Mage::registry('autoinvoice_data') ) {
          $form->setValues(Mage::registry('autoinvoice_data')->getData());
      }
      return parent::_prepareForm();
  }
}