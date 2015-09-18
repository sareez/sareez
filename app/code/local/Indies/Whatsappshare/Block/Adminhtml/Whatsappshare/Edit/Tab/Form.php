<?php
/**
* 
* Do not edit or add to this file if you wish to upgrade the module to newer
* versions in the future. If you wish to customize the module for your 
* needs please contact us to https://www.milople.com/magento-extensions/contact-us.html 
* 
* @category    Ecommerce
* @package     Indies_Whatsappshare
* @copyright   Copyright (c) 2015 Milople Technologies Pvt. Ltd. All Rights Reserved.
* @url	       https://www.milople.com/magento-extensions/whatsapp-share.html
*
* Milople was known as Indies Services earlier.
*
*/
class Indies_Whatsappshare_Block_Adminhtml_Whatsappshare_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('whatsappshare_form', array('legend'=>Mage::helper('whatsappshare')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('whatsappshare')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('whatsappshare')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('whatsappshare')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('whatsappshare')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('whatsappshare')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('whatsappshare')->__('Content'),
          'title'     => Mage::helper('whatsappshare')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getWhatsappshareData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getWhatsappshareData());
          Mage::getSingleton('adminhtml/session')->setWhatsappshareData(null);
      } elseif ( Mage::registry('whatsappshare_data') ) {
          $form->setValues(Mage::registry('whatsappshare_data')->getData());
      }
      return parent::_prepareForm();
  }
}