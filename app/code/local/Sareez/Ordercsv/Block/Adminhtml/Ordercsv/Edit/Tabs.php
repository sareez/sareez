<?php

class Sareez_Ordercsv_Block_Adminhtml_Ordercsv_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('ordercsv_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('ordercsv')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      
      
        $this->addTab('form_section', array(
          'label'     => Mage::helper('ordercsv')->__('Item Information'),
          'title'     => Mage::helper('ordercsv')->__('Item Information'),
           'content'   => $this->getLayout()->createBlock('ordercsv/adminhtml_ordercsv_grids')->toHtml(),
      ));
      
      
      
      $this->addTab('form_section1', array(
          'label'     => Mage::helper('ordercsv')->__('Item Information'),
          'title'     => Mage::helper('ordercsv')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('ordercsv/adminhtml_ordercsv_edit_tab_form')->toHtml(),
      ));
      
      // 'content'   => $this->getLayout()->createBlock('ordercsv/adminhtml_ordercsv_edit_tab_form')->toHtml(),
      
      
      
   
      
      
     
      return parent::_beforeToHtml();
  }
}