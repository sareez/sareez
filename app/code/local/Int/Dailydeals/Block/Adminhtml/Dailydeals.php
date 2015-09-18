<?php
class Int_Dailydeals_Block_Adminhtml_Dailydeals extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_dailydeals';
    $this->_blockGroup = 'dailydeals';
    $this->_headerText = Mage::helper('dailydeals')->__('Deal Management');
    $this->_addButtonLabel = Mage::helper('dailydeals')->__('Add Deal');
    parent::__construct();
  }
}