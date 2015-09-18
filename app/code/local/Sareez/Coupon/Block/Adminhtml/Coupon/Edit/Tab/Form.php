<?php

class Sareez_Coupon_Block_Adminhtml_Coupon_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('coupon_form', array('legend'=>Mage::helper('coupon')->__('Rule information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('coupon')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));


	/*
	
	$fieldset->addField('filename', 'file', array(
	  'label'     => Mage::helper('coupon')->__('File'),
	  'required'  => false,
	  'name'      => 'filename',
	));
	
	*/
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('coupon')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('coupon')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('coupon')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('coupon')->__('Content'),
          'title'     => Mage::helper('coupon')->__('Content'),
          'style'     => 'width:273px; height:122px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
	 
	
	
	  
	  
     
      if ( Mage::getSingleton('adminhtml/session')->getCouponData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getCouponData());
          Mage::getSingleton('adminhtml/session')->setCouponData(null);
      } elseif ( Mage::registry('coupon_data') ) {
          $form->setValues(Mage::registry('coupon_data')->getData());
      }
      return parent::_prepareForm();
  }
}