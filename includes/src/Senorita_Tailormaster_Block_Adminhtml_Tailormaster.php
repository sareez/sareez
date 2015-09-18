<?php
class Senorita_Tailormaster_Block_Adminhtml_Tailormaster extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_tailormaster';
    $this->_blockGroup = 'tailormaster';
    $this->_headerText = Mage::helper('tailormaster')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('tailormaster')->__('Add Item');
    parent::__construct();
  }
}