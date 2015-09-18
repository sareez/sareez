<?php
class Sareez_Mostviewed_Block_Adminhtml_Mostviewed extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_mostviewed';
    $this->_blockGroup = 'mostviewed';
    $this->_headerText = Mage::helper('mostviewed')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('mostviewed')->__('Add Item');
    parent::__construct();
  }
}