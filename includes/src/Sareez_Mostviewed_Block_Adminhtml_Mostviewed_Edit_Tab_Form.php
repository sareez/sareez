<?php

class Sareez_Mostviewed_Block_Adminhtml_Mostviewed_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('mostviewed_form', array('legend'=>Mage::helper('mostviewed')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('mostviewed')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('mostviewed')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('mostviewed')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('mostviewed')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('mostviewed')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('mostviewed')->__('Content'),
          'title'     => Mage::helper('mostviewed')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getMostviewedData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getMostviewedData());
          Mage::getSingleton('adminhtml/session')->setMostviewedData(null);
      } elseif ( Mage::registry('mostviewed_data') ) {
          $form->setValues(Mage::registry('mostviewed_data')->getData());
      }
      return parent::_prepareForm();
  }
}