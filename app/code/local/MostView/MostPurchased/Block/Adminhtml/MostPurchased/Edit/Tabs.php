<?php

class MostView_MostPurchased_Block_Adminhtml_MostPurchased_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('mostpurchased_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('mostpurchased')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('mostpurchased')->__('Item Information'),
          'title'     => Mage::helper('mostpurchased')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('mostpurchased/adminhtml_mostpurchased_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}