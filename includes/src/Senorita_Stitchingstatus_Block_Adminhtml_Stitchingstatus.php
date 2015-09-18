<?php
class Senorita_Stitchingstatus_Block_Adminhtml_Stitchingstatus extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_stitchingstatus';
    $this->_blockGroup = 'stitchingstatus';
    $this->_headerText = Mage::helper('stitchingstatus')->__('Stitching Manager');
    $this->_addButtonLabel = Mage::helper('stitchingstatus')->__('Add Item');
    parent::__construct();
  }
}