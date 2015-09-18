<?php
class Senorita_Autoinvoice_Block_Adminhtml_Autoinvoice extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_autoinvoice';
    $this->_blockGroup = 'autoinvoice';
    $this->_headerText = Mage::helper('autoinvoice')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('autoinvoice')->__('Add Item');
    parent::__construct();
  }
}