<?php
class LatestTrendingDesigns_LatestTrendingDesigns_Block_Adminhtml_LatestTrendingDesigns extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_latesttrendingdesigns';
    $this->_blockGroup = 'latesttrendingdesigns';
    $this->_headerText = Mage::helper('latesttrendingdesigns')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('latesttrendingdesigns')->__('Add Item');
    parent::__construct();
  }
}