<?php

class Most_ViewPurchased_Block_Adminhtml_ViewPurchased_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('viewpurchased_form', array('legend'=>Mage::helper('viewpurchased')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('viewpurchased')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('viewpurchased')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('viewpurchased')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('viewpurchased')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('viewpurchased')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('viewpurchased')->__('Content'),
          'title'     => Mage::helper('viewpurchased')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getViewPurchasedData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getViewPurchasedData());
          Mage::getSingleton('adminhtml/session')->setViewPurchasedData(null);
      } elseif ( Mage::registry('viewpurchased_data') ) {
          $form->setValues(Mage::registry('viewpurchased_data')->getData());
      }
      return parent::_prepareForm();
  }
}