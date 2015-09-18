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
class Indies_Whatsappshare_Helper_Data extends Mage_Core_Helper_Abstract
{
const MULTIPLE_FILTERS_DELIMITER = ',';	
	public function getDomain ()
		{
			$domain = $_SERVER['SERVER_NAME'];
			$temp = explode('.', $domain);
			$exceptions = array(
				'co.uk',
				'com.au',
				'com.hk',
				'co.nz',
				'co.in',
				'com.sg'
				);

				$count = count($temp);
				$last = $temp[($count-2)] . '.' . $temp[($count-1)];

				if(in_array($last, $exceptions))	{
					$new_domain = $temp[($count-3)] . '.' . $temp[($count-2)] . '.' . $temp[($count-1)];
				}
				else	{
					$new_domain = $temp[($count-2)] . '.' . $temp[($count-1)];
				}
				return $new_domain;
		}


		public function checkEntry ($domain, $serial)
		{
			$key = sha1(base64_decode('V2hhdHNhcHBzaGFyZQ=='));
			if(sha1($key.$domain) == $serial)
			{
				return true;
			}
			return false;
		}


		public function isEnabled()
		{
			if(Mage::getStoreConfig('whatsappshare/license_status_group/status', Mage::app()->getStore()) == '1') {
				return true;
			}
			return false;
			
		}
	public function canRun($temp = '')
    {
		if($_SERVER['SERVER_NAME'] == "localhost" || $_SERVER['SERVER_NAME'] == "127.0.0.1")
		 {
			return true;
		}
		if(!$temp)
		{
			//fetch serial key modulewise
			$temp = Mage::getStoreConfig('whatsappshare/license_status_group/serial_key',Mage::app()->getStore());
// here change 'customconfig' with modulename
		}
		$url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
		$parsedUrl = parse_url($url);
		$host = explode('.', $parsedUrl['host']);
		$subdomains = array_slice($host, 0, count($host) - 2 );
		
		if(sizeof($subdomains) && ($subdomains[0] == 'test'|| $subdomains[0] == 'demo'))
		{
			return true;
		}
		$original = $this->checkEntry($_SERVER['SERVER_NAME'], $temp);
        $wildcard = $this->checkEntry($this->getDomain(), $temp);

		if(!$original && !$wildcard){
            return false;
        }
        return true;
    }


		

		public function getMessage ()
		{
			
			return base64_decode('PGRpdiBzdHlsZT0iYm9yZGVyOjNweCBzb2xpZCAjRkYwMDAwOyBtYXJnaW46MTVweCAwOyBwYWRkaW5nOjVweDsiPkxpY2Vuc2Ugb2YgPGI+TWlsb3BsZSBXaGF0c2FwcHNoYXJlPC9iPiBtb2R1bGUgaGFzIGJlZW4gdmlvbGF0ZWQuIFRvIGdldCBsaWNlbnNlIGtleSBwbGVhc2UgY29udGFjdCB1cyBvbiA8Yj5odHRwczovL3d3dy5taWxvcGxlLmNvbS9tYWdlbnRvLWV4dGVuc2lvbnMvY29udGFjdHMvPC9iPi48L2Rpdj4=');
		}
		public function getAdminMessage ()
		{
			return base64_decode('PGRpdj5MaWNlbnNlIG9mIDxiPk1pbG9wbGUgV2hhdHNhcHBzaGFyZTwvYj4gbW9kdWxlIGhhcyBiZWVuIHZpb2xhdGVkLiBUbyBnZXQgbGljZW5zZSBrZXkgcGxlYXNlIGNvbnRhY3QgdXMgb24gPGI+aHR0cHM6Ly93d3cubWlsb3BsZS5jb20vbWFnZW50by1leHRlbnNpb25zL2NvbnRhY3RzLzwvYj4uPC9kaXY+');
		}

}