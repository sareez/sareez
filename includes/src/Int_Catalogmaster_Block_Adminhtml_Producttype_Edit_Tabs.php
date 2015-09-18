<?php

class Int_Catalogmaster_Block_Adminhtml_Producttype_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('catalogmaster_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('catalogmaster')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('catalogmaster')->__('Product Type Information'),
          'title'     => Mage::helper('catalogmaster')->__('Product Type Information'),
          'content'   => $this->getLayout()->createBlock('catalogmaster/adminhtml_producttype_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}