<?php

class Most_ViewPurchased_Block_Adminhtml_ViewPurchased_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('viewpurchased_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('viewpurchased')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('viewpurchased')->__('Item Information'),
          'title'     => Mage::helper('viewpurchased')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('viewpurchased/adminhtml_viewpurchased_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}