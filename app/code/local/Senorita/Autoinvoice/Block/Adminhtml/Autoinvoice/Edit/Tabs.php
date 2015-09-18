<?php

class Senorita_Autoinvoice_Block_Adminhtml_Autoinvoice_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('autoinvoice_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('autoinvoice')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('autoinvoice')->__('Item Information'),
          'title'     => Mage::helper('autoinvoice')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('autoinvoice/adminhtml_autoinvoice_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}