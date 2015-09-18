<?php

class Sareez_Coupon_Block_Adminhtml_Coupon_Edit_Tab_Condition extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('coupon_form', array('legend'=>Mage::helper('coupon')->__('Condition')));
     
   
	
	  
	$fieldset->addField('no_of_prd', 'text', array(
          'label'     => Mage::helper('coupon')->__('Number of Product'),
		  'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'no_of_prd',
      ));
	  
	  
      $fieldset->addField('action', 'select', array(
	  	  'name'      => 'action',
          'label'     => Mage::helper('coupon')->__('Action'),
          'values'    => array(
		  
              array(
			  
                  'value'     => 1,
                  'label'     => Mage::helper('coupon')->__('Percent of product price discount'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('coupon')->__('Fixed amount discount'),
              ),
			  
          ),
      ));
	  
	 $fieldset->addField('discount_amount', 'text', array(
			'name'      => 'discount_amount',
			'label'     => Mage::helper('coupon')->__('Discount Amount'),
			'class'     => 'required-entry',
			'required'  => true,
			'after_element_html' => '<small>Discount For Single Product.</small>'

      ));
	  
	  
	$fieldset->addField('min_amnt', 'text', array(
		'name'      => 'min_amnt',
		'label'     => Mage::helper('coupon')->__('Minimum Amount'),
		'class'     => 'required-entry',
		'required'  => true,
	));

		
		
/*	$fieldset->addField('multiple_coupon', 'checkbox', array(
		
		'name'		=> 'multiple_coupon',
		'label'		=> Mage::helper('coupon')->__('Apply For Multiple Coupon'),
		'values'	=> '1',
		'value'		=> '1',
		'onclick'	=> 'this.value = this.checked ? 1 : 0;',
		'disabled'	=> false,
		'readonly'	=> false
		
	));*/
	
/*	$fieldset->addField('multiple_coupon', 'select', array(
		  'name'      => 'multiple_coupon',
          'label'     => Mage::helper('coupon')->__('Apply For Multiple Coupon'),
		  'title'     => Mage::helper('coupon')->__('Apply For Multiple Coupon'),
          'values'    => array(
		  
              array(
			  
                  'value'     => '1',
                  'label'     => Mage::helper('coupon')->__('No'),
              ),

              array(
                  'value'     => '2',
                  'label'     => Mage::helper('coupon')->__('Yes'),
              ),
			  
          ),
      ));*/
	  
	  
	  
	  $fieldset->addField('special_price', 'select', array(
		
		  'name'      => 'special_price',
          'label'     => Mage::helper('coupon')->__('Include Sale Section'),
		  'title'     => Mage::helper('coupon')->__('Include Sale Section'),
          'values'    => array(
		  
              array(
			  
                  'value'     => '1',
                  'label'     => Mage::helper('coupon')->__('No'),
              ),

              array(
                  'value'     => '2',
                  'label'     => Mage::helper('coupon')->__('Yes'),
              ),
			  
          ),
      ));
	  
	  
	  
	  	$fieldset->addField('product_level', 'text', array(
			'name'      => 'product_level',
			'label'     => Mage::helper('coupon')->__('product Level'),
			'required'  => false,
			'after_element_html' => '<small>1|2|3  ( Discount For Multiple Product )</small>',
          
      ));
	  
	  	  	$fieldset->addField('discount_level', 'text', array(
			'name'      => 'discount_level',
			'label'     => Mage::helper('coupon')->__('Discount Level'),
			'required'  => false,
			'after_element_html' => '<small>10|20|30 ( Discount For Multiple Product )</small>'
          
      ));
	  
		
		
// - See more at: http://excellencemagentoblog.com/blog/2011/11/02/magento-admin-form-field/#sthash.JoQN8EvB.dpuf

	$fieldset->addField('product_category', 'multiselect', array(
	
		'name'		=> 'product_category',
		'label'		=> Mage::helper('coupon')->__('Product Category'),
		'required'	=> false,
		'values'	=> Mage::helper('coupon')->getCategoryOptionValues(true),
		'value'		=> '' 
			
	)); 

	

	

	$fieldset->addField('user', 'multiselect', array(
	
		'name'     	=> 'user',
		'label'    	=> Mage::helper('coupon')->__('User'),
		'onclick'  	=> "return false;",
		'onchange' 	=> "return false;",
		'values'   	=> Mage::helper('coupon')->getUserOptionValues(true),
		'disabled'	=> false,
		'readonly'	=> false,
		'tabindex'	=> 1
	  
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