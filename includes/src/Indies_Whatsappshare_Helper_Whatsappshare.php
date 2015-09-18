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
class Indies_Whatsappshare_Helper_Whatsappshare extends Mage_Core_Helper_Abstract
{
	public function isEnabled ()
	{
		if(Mage::getStoreConfig('whatsappshare/license_status_group/status', Mage::app()->getStore()) == '1') 
		{
			return true;
		}
		return false;
	}
	public function getSerialKey()
	{
		return(Mage::getStoreConfig('whatsappshare/license_status_group/serial_key', Mage::app()->getStore()));
	}
	public function getSize()
	{
		return(Mage::getStoreConfig('whatsappshare/whatsappshare_options/size', Mage::app()->getStore()));
		}	
}



