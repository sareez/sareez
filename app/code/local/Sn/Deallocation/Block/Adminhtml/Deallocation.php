<?php
class Sn_Deallocation_Block_Adminhtml_Deallocation extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_deallocation';
    $this->_blockGroup = 'deallocation';
    $this->_headerText = Mage::helper('deallocation')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('deallocation')->__('Add Item');
    parent::__construct();
  }
}