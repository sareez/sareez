<?php

class Sareez_Ordercsv_Block_Adminhtml_Ordercsv_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('ordercsv_form', array('legend'=>Mage::helper('ordercsv')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('ordercsv')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('ordercsv')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('ordercsv')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('ordercsv')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('ordercsv')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('ordercsv')->__('Content'),
          'title'     => Mage::helper('ordercsv')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getOrdercsvData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getOrdercsvData());
          Mage::getSingleton('adminhtml/session')->setOrdercsvData(null);
      } elseif ( Mage::registry('ordercsv_data') ) {
          $form->setValues(Mage::registry('ordercsv_data')->getData());
      }
      return parent::_prepareForm();
  }
}