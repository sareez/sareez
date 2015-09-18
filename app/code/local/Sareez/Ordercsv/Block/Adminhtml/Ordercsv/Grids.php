<?php

class Sareez_Ordercsv_Block_Adminhtml_Ordercsv_Grids extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('ordercsvGrid');
      $this->setDefaultSort('ordercsv_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
      $this->setTemplate('ordercsv/adminhtml_ordercsv.phtml');
  }

  public function orderProcess()
  {
      $testArray = array( 'asd', 'sdfds', 'dfg' );
      
      return  $testArray;
      
  }

}