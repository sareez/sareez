<?php

class Sn_Outorder_Block_Adminhtml_Outorder_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('outorder_form', array('legend'=>Mage::helper('outorder')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('outorder')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('outorder')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('outorder')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('outorder')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('outorder')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('outorder')->__('Content'),
          'title'     => Mage::helper('outorder')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getOutorderData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getOutorderData());
          Mage::getSingleton('adminhtml/session')->setOutorderData(null);
      } elseif ( Mage::registry('outorder_data') ) {
          $form->setValues(Mage::registry('outorder_data')->getData());
      }
      return parent::_prepareForm();
  }
}