<?php

class Sn_Outorder_Block_Adminhtml_Outorder_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('outorder_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('outorder')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('outorder')->__('Item Information'),
          'title'     => Mage::helper('outorder')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('outorder/adminhtml_outorder_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}