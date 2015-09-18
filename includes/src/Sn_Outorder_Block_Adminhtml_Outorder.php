<?php
class Sn_Outorder_Block_Adminhtml_Outorder extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_outorder';
    $this->_blockGroup = 'outorder';
    $this->_headerText = Mage::helper('outorder')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('outorder')->__('Add Item');
    parent::__construct();
  }
}