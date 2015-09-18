<?php

class Last_Viewed_Block_Adminhtml_Viewed_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('viewed_form', array('legend'=>Mage::helper('viewed')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('viewed')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('viewed')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('viewed')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('viewed')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('viewed')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('viewed')->__('Content'),
          'title'     => Mage::helper('viewed')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getViewedData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getViewedData());
          Mage::getSingleton('adminhtml/session')->setViewedData(null);
      } elseif ( Mage::registry('viewed_data') ) {
          $form->setValues(Mage::registry('viewed_data')->getData());
      }
      return parent::_prepareForm();
  }
}