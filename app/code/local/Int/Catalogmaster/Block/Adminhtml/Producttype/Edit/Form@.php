<?php

class Int_Catalogmaster_Block_Adminhtml_Catalogmaster_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form(array(
                                      'id' => 'edit_form',
                                      'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                                      'method' => 'post',
        							  'enctype' => 'multipart/form-data'
        							    if (!Mage::app()->isSingleStoreMode()) {
   											$fieldset->addField('store_id', 'multiselect', array(
           																'name'      => 'stores[]',
           																'label'     => Mage::helper('MODULE')->__('Store View'),
           																'title'     => Mage::helper('MODULE')->__('Store View'),
           																'required'  => true,
           																'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
   											));
  										 }
  										 else {
   											$fieldset->addField('store_id', 'hidden', array(
           																 'name'      => 'stores[]',
           																 'value'     => Mage::app()->getStore(true)->getId()
   									  		));
   											$model->setStoreId(Mage::app()->getStore(true)->getId());
  										 }
                                   )
      );

      $form->setUseContainer(true);
      $this->setForm($form);
      return parent::_prepareForm();
  }
}