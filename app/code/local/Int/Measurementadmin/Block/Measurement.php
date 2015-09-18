<?php
class Int_Measurementadmin_Block_Measurement extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'measurement';
    $this->_blockGroup = 'measurementadmin';
    $this->_headerText = Mage::helper('measurementadmin')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('measurementadmin')->__('Add Item');
    parent::__construct();
  }
}
