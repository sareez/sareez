<?php
class Sn_Sorder_Block_Adminhtml_Sorder extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
	 
    $this->_controller = 'adminhtml_sorder';
    $this->_blockGroup = 'sorder';
    $this->_headerText = Mage::helper('sorder')->__('Order Sheet');
   $this->_addButtonLabel = Mage::helper('sorder')->__('Add Item');
    parent::__construct();
	 $this->_removeButton('add');
  }
}