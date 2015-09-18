<?php

class Senorita_Tailormaster_Block_Adminhtml_Tailormaster_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('tailormaster_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('tailormaster')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('tailormaster')->__('Item Information'),
          'title'     => Mage::helper('tailormaster')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('tailormaster/adminhtml_tailormaster_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}