<?php

class Senorita_Stitchingstatus_Block_Adminhtml_Stitchingstatus_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('stitchingstatus_form', array('legend'=>Mage::helper('stitchingstatus')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('stitchingstatus')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));
	  
	   $fieldset->addField('color', 'text', array(
          'label'     => Mage::helper('stitchingstatus')->__('Color Code#'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'color',
      ));

      /*$fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('stitchingstatus')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));*/
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('stitchingstatus')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('stitchingstatus')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('stitchingstatus')->__('Disabled'),
              ),
          ),
      ));
     
      /*$fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('stitchingstatus')->__('Content'),
          'title'     => Mage::helper('stitchingstatus')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));*/
     
      if ( Mage::getSingleton('adminhtml/session')->getStitchingstatusData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getStitchingstatusData());
          Mage::getSingleton('adminhtml/session')->setStitchingstatusData(null);
      } elseif ( Mage::registry('stitchingstatus_data') ) {
          $form->setValues(Mage::registry('stitchingstatus_data')->getData());
      }
      return parent::_prepareForm();
  }
}