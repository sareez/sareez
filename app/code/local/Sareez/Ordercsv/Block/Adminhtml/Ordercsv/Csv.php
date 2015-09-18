<?php

class Sareez_Coupon_Block_Adminhtml_Ordercsv_Csv extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
	 // $this->setTemplate('ordercsv/adminhtml_ordercsv.phtml');

          
    /*
    $this->setId('couponGrid');
    $this->setDefaultSort('coupon_id');
    $this->setDefaultDir('ASC');
    $this->setSaveParametersInSession(true);
     echo $this->coupon_code();
    */
          
          
  }

 

	function coupon_code(){
		
	// return $result = array('A','B','C');
	
//  $write = Mage::getSingleton('core/resource')->getConnection('core_write');
//  $readresult=$write->query("SELECT * FROM `generatedcoupon` where coupon_id ='".$this->getRequest()->getParam('id')."' ORDER BY `generatedcoupon_id` DESC LIMIT 0 , 30 ");
//
//
//    while ($row = $readresult->fetch() ) {
//    $Ids[]=$row;
//    }
//	return $Ids;
            
            
            
            
	}
	


}