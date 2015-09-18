<?php
class Int_Catalogmaster_Block_Adminhtml_Catalogmaster extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_catalogmaster';
    $this->_blockGroup = 'catalogmaster';
    $this->_headerText = Mage::helper('catalogmaster')->__('Catalog Manager');
    $this->_addButtonLabel = Mage::helper('catalogmaster')->__('Add Catalog');
    parent::__construct();
  }
  
  
  
  
}