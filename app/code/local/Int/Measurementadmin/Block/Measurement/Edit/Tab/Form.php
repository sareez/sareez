<?php

class Int_Measurementadmin_Block_Measurement_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('measurementadmin_form', array('legend'=>Mage::helper('measurementadmin')->__('Item information')));
     
      $fieldset->addField('style_name', 'text', array(
          'label'     => Mage::helper('measurementadmin')->__('Style Name'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'style_name',
      ));
	
      $fieldset->addField('style_category', 'select', array(
          'label'     => Mage::helper('measurementadmin')->__('Style Category'),
          'name'      => 'style_category',
          'values'    => array(
              array(
                  'value'     => 'Sleeve Style',
                  'label'     => Mage::helper('measurementadmin')->__('Sleeve Style'),
              ),

              array(
                  'value'     => 'Front Neck Style',
                  'label'     => Mage::helper('measurementadmin')->__('Front Neck Style'),
              ),
              
              array(
                  'value'     => 'Back Neck Style',
                  'label'     => Mage::helper('measurementadmin')->__('Back Neck Style'),
              ),
              
              array(
                  'value'     => 'Kameez Style',
                  'label'     => Mage::helper('measurementadmin')->__('Kameez Style'),
              ),
              
              array(
                  'value'     => 'Salwar Style',
                  'label'     => Mage::helper('measurementadmin')->__('Salwar Style'),
              ),
              
              array(
                  'value'     => 'Lehnga Style',
                  'label'     => Mage::helper('measurementadmin')->__('Lehnga Style'),
              ),
              
              array(
                  'value'     => 'Churidar Style',
                  'label'     => Mage::helper('measurementadmin')->__('Churidar Style'),
              ),
          ),
      ));
      
      $fieldset->addField('style_for', 'select', array(
          'label'     => Mage::helper('measurementadmin')->__('Style For'),
          'name'      => 'style_for',
          'values'    => array(
              array(
                  'value'     => 'Blouse',
                  'label'     => Mage::helper('measurementadmin')->__('Blouse'),
              ),

              array(
                  'value'     => 'Kameez',
                  'label'     => Mage::helper('measurementadmin')->__('Kameez'),
              ),
              
              array(
                  'value'     => 'Choli',
                  'label'     => Mage::helper('measurementadmin')->__('Choli'),
              ),
              
          ),
      ));
      
      $fieldset->addField('style_image', 'image', array(          
      			'name'      => 'style_image',
                'multiple'  => 'multiple',
                'mulitple'  => false,
                'label'     => Mage::helper('measurementadmin')->__('Style Image'),
                'title'     => Mage::helper('measurementadmin')->__('Style Image'),
                'required'  => false,
                'disabled'  => $isElementDisabled	
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('measurementadmin')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('measurementadmin')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('measurementadmin')->__('Disabled'),
              ),
          ),
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getMeasurementadminData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getMeasurementadminData());
          Mage::getSingleton('adminhtml/session')->setMeasurementadminData(null);
      } elseif ( Mage::registry('measurementadmin_data') ) {
          $form->setValues(Mage::registry('measurementadmin_data')->getData());
      }
      return parent::_prepareForm();
  }
}