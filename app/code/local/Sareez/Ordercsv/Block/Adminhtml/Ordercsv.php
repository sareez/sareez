<?php
class Sareez_Ordercsv_Block_Adminhtml_Ordercsv extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_ordercsv';
    $this->_blockGroup = 'ordercsv';
    $this->_headerText = Mage::helper('ordercsv')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('ordercsv')->__('Add Item');
    parent::__construct();
  }
}