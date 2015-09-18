<?php

class Dolphin_Productqa_Block_Adminhtml_Productqa_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('productqa_form', array('legend'=>Mage::helper('productqa')->__('Item information')));
     
      $fieldset->addField('cutomer_email_status', 'hidden', array(      		
      		'name'      => 'cutomer_email_status',
      ));
      
      $fieldset->addField('product_sku', 'text', array(
          'label'     => Mage::helper('productqa')->__('Product Sku'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'product_sku',
      ));
      
/*      $fieldset->addField('name', 'text', array(
      		'label'     => Mage::helper('productqa')->__('Customer Name'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'name',
      ));
      
      $fieldset->addField('email', 'text', array(
      		'label'     => Mage::helper('productqa')->__('Customer Email'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'email',
      ));
*/      
      $fieldset->addField('status', 'select', array(
      		'label' => Mage::helper('productqa')->__('Status'),
      		'name' => 'status',
      		'values' => array(
      				array(
      						'value' => 1,
      						'label' => Mage::helper('productqa')->__('Enabled'),
      				),
      				array(
      						'value' => 2,
      						'label' => Mage::helper('productqa')->__('Disabled'),
      				),      				
      		),      		
      ));      
      

      $fieldset->addField('question', 'editor', array(
      		'label'     => Mage::helper('productqa')->__('Suggesition'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'question',
			'style'     => 'width:300px; height:300px;',
            'wysiwyg'   => false,
            'required'  => true,
      ));
     
/*      $fieldset->addField('answer', 'editor', array(
          'name'      => 'answer',
          'label'     => Mage::helper('productqa')->__('Answer'),
          'title'     => Mage::helper('productqa')->__('Answer'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
*/     
      if ( Mage::getSingleton('adminhtml/session')->getProductqaData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getProductqaData());
          Mage::getSingleton('adminhtml/session')->setProductqaData(null);
      } elseif ( Mage::registry('productqa_data') ) {
          $form->setValues(Mage::registry('productqa_data')->getData());
      }
      return parent::_prepareForm();
  }
}