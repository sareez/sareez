<?php
class MostView_MostPurchased_Block_Adminhtml_MostPurchased extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_mostpurchased';
    $this->_blockGroup = 'mostpurchased';
    $this->_headerText = Mage::helper('mostpurchased')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('mostpurchased')->__('Add Item');
    parent::__construct();
  }
}