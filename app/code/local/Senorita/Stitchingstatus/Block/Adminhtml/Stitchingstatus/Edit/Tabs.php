<?php

class Senorita_Stitchingstatus_Block_Adminhtml_Stitchingstatus_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('stitchingstatus_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('stitchingstatus')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('stitchingstatus')->__('Item Information'),
          'title'     => Mage::helper('stitchingstatus')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('stitchingstatus/adminhtml_stitchingstatus_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}