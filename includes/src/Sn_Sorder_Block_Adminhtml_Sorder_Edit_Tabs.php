<?php

class Sn_Sorder_Block_Adminhtml_Sorder_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('sorder_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('sorder')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('sorder')->__('Item Information'),
          'title'     => Mage::helper('sorder')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('sorder/adminhtml_sorder_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}