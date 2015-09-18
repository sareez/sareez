<?php

class Sareez_Mostviewed_Block_Adminhtml_Mostviewed_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('mostviewed_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('mostviewed')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('mostviewed')->__('Item Information'),
          'title'     => Mage::helper('mostviewed')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('mostviewed/adminhtml_mostviewed_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}