<?php
class Senorita_Allocationstatus_Block_Adminhtml_Allocationstatus extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_allocationstatus';
    $this->_blockGroup = 'allocationstatus';
    $this->_headerText = Mage::helper('allocationstatus')->__('Allocation Manager');
    $this->_addButtonLabel = Mage::helper('allocationstatus')->__('Add Item');
    parent::__construct();
  }
}