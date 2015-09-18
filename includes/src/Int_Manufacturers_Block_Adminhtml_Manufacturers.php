<?php
class Int_Manufacturers_Block_Adminhtml_Manufacturers extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_manufacturers';
    $this->_blockGroup = 'manufacturers';
    $this->_headerText = Mage::helper('manufacturers')->__('Manufacturer Manager');
    $this->_addButtonLabel = Mage::helper('manufacturers')->__('Add Manufacturer');
    parent::__construct();
  }
  
  
  
  
}