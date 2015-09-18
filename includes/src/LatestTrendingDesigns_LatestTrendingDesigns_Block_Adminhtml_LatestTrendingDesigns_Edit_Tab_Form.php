<?php

class LatestTrendingDesigns_LatestTrendingDesigns_Block_Adminhtml_LatestTrendingDesigns_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('latesttrendingdesigns_form', array('legend'=>Mage::helper('latesttrendingdesigns')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('latesttrendingdesigns')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('latesttrendingdesigns')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('latesttrendingdesigns')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('latesttrendingdesigns')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('latesttrendingdesigns')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('latesttrendingdesigns')->__('Content'),
          'title'     => Mage::helper('latesttrendingdesigns')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getLatestTrendingDesignsData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getLatestTrendingDesignsData());
          Mage::getSingleton('adminhtml/session')->setLatestTrendingDesignsData(null);
      } elseif ( Mage::registry('latesttrendingdesigns_data') ) {
          $form->setValues(Mage::registry('latesttrendingdesigns_data')->getData());
      }
      return parent::_prepareForm();
  }
}