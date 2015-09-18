<?php
class Most_ViewPurchased_Block_Adminhtml_ViewPurchased extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_viewpurchased';
    $this->_blockGroup = 'viewpurchased';
    $this->_headerText = Mage::helper('viewpurchased')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('viewpurchased')->__('Add Item');
    parent::__construct();
  }
}