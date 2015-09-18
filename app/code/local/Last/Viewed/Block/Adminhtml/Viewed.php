<?php
class Last_Viewed_Block_Adminhtml_Viewed extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_viewed';
    $this->_blockGroup = 'viewed';
    $this->_headerText = Mage::helper('viewed')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('viewed')->__('Add Item');
    parent::__construct();
  }
}