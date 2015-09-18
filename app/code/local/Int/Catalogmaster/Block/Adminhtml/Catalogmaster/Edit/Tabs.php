<?php

class Int_Catalogmaster_Block_Adminhtml_Catalogmaster_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('catalogmaster_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('catalogmaster')->__('Catalog Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('catalogmaster')->__('Catalog Information'),
          'title'     => Mage::helper('catalogmaster')->__('Catalog Information'),
          'content'   => $this->getLayout()->createBlock('catalogmaster/adminhtml_catalogmaster_edit_tab_form')->toHtml(),
      ));
      
      	/* 
	 $this->addTab('form_section1', array(
          'label'     => Mage::helper('catalogmaster')->__('Product Type'),
          'title'     => Mage::helper('catalogmaster')->__('Product Type'),
          'content'   => $this->getLayout()->createBlock('catalogmaster/adminhtml_producttype_edit_tab_form')->toHtml(),
      ));
          
      $this->addTab('form_section2', array(
          'label'     => Mage::helper('catalogmaster')->__('Catalog Grid'),
          'title'     => Mage::helper('catalogmaster')->__('Catalog Grid'),
          'content'   => $this->getLayout()->createBlock('catalogmaster/adminhtml_catalogmaster_grid')->toHtml(),
      ));
      
           
        */
	 
     
      return parent::_beforeToHtml();
  }
}