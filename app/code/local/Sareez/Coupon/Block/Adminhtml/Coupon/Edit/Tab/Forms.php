<?php

class Sareez_Coupon_Block_Adminhtml_Coupon_Edit_Tab_Forms extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('coupon_form', array('legend'=>Mage::helper('coupon')->__('Manage Coupon Codes')));
     
      $fieldset->addField('coupon_qty', 'text', array(
	      'name'      => 'coupon_qty',
          'label'     => Mage::helper('coupon')->__('Coupon Qty'),
    
		  'value'  => '0',
     

      ));
	  
	  
/*	$fieldset->addField('code_length', 'text', array(
	      'name'      => 'code_length',
          'label'     => Mage::helper('coupon')->__('Code Length'),
          'class'     => 'required-entry',
          'required'  => true,

      ));*/
	  
	  
/*	$fieldset->addField('code_format', 'select', array(
		  'name'      => 'code_format',
          'label'     => Mage::helper('coupon')->__('Code Format'),
          
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('coupon')->__('Alphanumeric'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('coupon')->__('Alphabetical'),
              ),
			  
			  
			  array(
                  'value'     => 3,
                  'label'     => Mage::helper('coupon')->__('Numeric'),
              ),
			  
			  
			  
          ),
      ));*/
	  

/*	$fieldset->addField('dash_every_x_Char', 'text', array(
	      'name'      => 'dash_every_x_Char',
          'label'     => Mage::helper('coupon')->__('Dash Every X Characters'),
          'class'     => 'required-entry',
          'required'  => true,

      ));*/

	/*
	
	$fieldset->addField('filename', 'file', array(
	  'label'     => Mage::helper('coupon')->__('File'),
	  'required'  => false,
	  'name'      => 'filename',
	));
	
	*/
		
 
     
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