<?php

class Int_Dailydeals_Block_Adminhtml_Dailydeals_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('dailydeals_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('dailydeals')->__('Deal Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('dailydeals')->__('Deal Setting'),
          'title'     => Mage::helper('dailydeals')->__('Deal Setting'),
          'content'   => $this->getLayout()->createBlock('dailydeals/adminhtml_dailydeals_edit_tab_form')->toHtml(),
      ));
     
	   $this->addTab('form_section1', array(
          'label'     => Mage::helper('dailydeals')->__('Select Product'),
          'title'     => Mage::helper('dailydeals')->__('Select Product'),
          'content'   => $this->getLayout()->createBlock('dailydeals/adminhtml_dailydeals_edit_tab_related')->toHtml(),
      ));
	 	 
      return parent::_beforeToHtml();
  }
}