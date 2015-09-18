<?php

class Sn_Deallocation_Block_Adminhtml_Deallocation_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('deallocation_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('deallocation')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('deallocation')->__('Item Information'),
          'title'     => Mage::helper('deallocation')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('deallocation/adminhtml_deallocation_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}