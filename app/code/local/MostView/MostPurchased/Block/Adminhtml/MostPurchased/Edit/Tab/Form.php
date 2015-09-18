<?php

class MostView_MostPurchased_Block_Adminhtml_MostPurchased_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('mostpurchased_form', array('legend'=>Mage::helper('mostpurchased')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('mostpurchased')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('mostpurchased')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('mostpurchased')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('mostpurchased')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('mostpurchased')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('mostpurchased')->__('Content'),
          'title'     => Mage::helper('mostpurchased')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getMostPurchasedData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getMostPurchasedData());
          Mage::getSingleton('adminhtml/session')->setMostPurchasedData(null);
      } elseif ( Mage::registry('mostpurchased_data') ) {
          $form->setValues(Mage::registry('mostpurchased_data')->getData());
      }
      return parent::_prepareForm();
  }
}