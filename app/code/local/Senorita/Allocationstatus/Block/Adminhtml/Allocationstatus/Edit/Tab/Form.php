<?php

class Senorita_Allocationstatus_Block_Adminhtml_Allocationstatus_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('allocationstatus_form', array('legend'=>Mage::helper('allocationstatus')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('allocationstatus')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      /*$fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('allocationstatus')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));*/
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('allocationstatus')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('allocationstatus')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('allocationstatus')->__('Disabled'),
              ),
          ),
      ));
     
      /*$fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('allocationstatus')->__('Content'),
          'title'     => Mage::helper('allocationstatus')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));*/
     
      if ( Mage::getSingleton('adminhtml/session')->getAllocationstatusData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getAllocationstatusData());
          Mage::getSingleton('adminhtml/session')->setAllocationstatusData(null);
      } elseif ( Mage::registry('allocationstatus_data') ) {
          $form->setValues(Mage::registry('allocationstatus_data')->getData());
      }
      return parent::_prepareForm();
  }
}