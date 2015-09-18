<?php

class Senorita_Tailormaster_Block_Adminhtml_Tailormaster_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('tailormaster_form', array('legend'=>Mage::helper('tailormaster')->__('Item information')));
     
	  $fieldset->addField('tailorname', 'text', array(
          'label'     => Mage::helper('tailormaster')->__('Tailor Name'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'tailorname',
      ));
	  
	  $fieldset->addField('address', 'editor', array(
          'name'      => 'address',
          'label'     => Mage::helper('tailormaster')->__('Tailor Address'),
          'title'     => Mage::helper('tailormaster')->__('Tailor Address'),
          'style'     => 'width:200px; height:100px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
	  
	  $fieldset->addField('phone', 'text', array(
          'label'     => Mage::helper('tailormaster')->__('Tailor Phone'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'phone',
      ));
	  
	  $fieldset->addField('leavingdate', 'text', array(
          'label'     => Mage::helper('tailormaster')->__('Leaving Date'),
          'required'  => false,
          'name'      => 'leavingdate',
		  'value'     => 'Continuing'
      ));

/*      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('tailormaster')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
*/		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('tailormaster')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('tailormaster')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('tailormaster')->__('Disabled'),
              ),
          ),
      ));
     
     
      if ( Mage::getSingleton('adminhtml/session')->getTailormasterData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getTailormasterData());
          Mage::getSingleton('adminhtml/session')->setTailormasterData(null);
      } elseif ( Mage::registry('tailormaster_data') ) {
          $form->setValues(Mage::registry('tailormaster_data')->getData());
      }
      return parent::_prepareForm();
  }
}