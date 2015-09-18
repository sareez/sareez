<?php
class Int_Catalogmaster_Block_Adminhtml_Producttype extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_producttype';
    $this->_blockGroup = 'catalogmaster';
    $this->_headerText = Mage::helper('catalogmaster')->__('Product Type Manager');
    $this->_addButtonLabel = Mage::helper('catalogmaster')->__('Add Product Type');
    parent::__construct();
  }
  
  
  
  
}