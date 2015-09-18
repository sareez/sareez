<?php
/**
* 
* Do not edit or add to this file if you wish to upgrade the module to newer
* versions in the future. If you wish to customize the module for your 
* needs please contact us to https://www.milople.com/magento-extensions/contact-us.html 
* 
* @category    Ecommerce
* @package     Indies_Whatsappshare
* @copyright   Copyright (c) 2015 Milople Technologies Pvt. Ltd. All Rights Reserved.
* @url	       https://www.milople.com/magento-extensions/whatsapp-share.html
*
* Milople was known as Indies Services earlier.
*
*/
class Indies_Whatsappshare_Model_Observer extends Mage_Core_Model_Config_Data
{
	
	public function save()
    {
  		$data = $this->_getData('fieldset_data');
  		$obj = Mage::helper('whatsappshare');
                    
		if($data['serial_key'] != '')
  		{
  			 $serialkey = $data['serial_key'];
  			 if($obj->canRun($serialkey))
   			{
        		  return parent::save();
   			}
  			 else
   			{
   				Mage::throwException($obj->getAdminMessage());
   			}
  		}
 		 else
 		 {
 			  Mage::throwException($obj->getAdminMessage());
}
    }	
}