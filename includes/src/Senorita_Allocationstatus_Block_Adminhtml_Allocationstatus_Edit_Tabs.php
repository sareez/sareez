<?php

class Senorita_Allocationstatus_Block_Adminhtml_Allocationstatus_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('allocationstatus_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('allocationstatus')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('allocationstatus')->__('Item Information'),
          'title'     => Mage::helper('allocationstatus')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('allocationstatus/adminhtml_allocationstatus_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}