<?php

class Int_Manufacturers_Block_Adminhtml_Manufacturers_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('manufacturers_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('manufacturers')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('manufacturers')->__('Manufacturer Information'),
          'title'     => Mage::helper('manufacturers')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('manufacturers/adminhtml_manufacturers_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}