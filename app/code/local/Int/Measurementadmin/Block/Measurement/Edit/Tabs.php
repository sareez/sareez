<?php

class Int_Measurementadmin_Block_Measurement_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('measurementadmin_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('measurementadmin')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('measurementadmin')->__('Item Information'),
          'title'     => Mage::helper('measurementadmin')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('measurementadmin/measurement_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}
