<?php

class Last_Viewed_Block_Adminhtml_Viewed_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('viewed_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('viewed')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('viewed')->__('Item Information'),
          'title'     => Mage::helper('viewed')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('viewed/adminhtml_viewed_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}