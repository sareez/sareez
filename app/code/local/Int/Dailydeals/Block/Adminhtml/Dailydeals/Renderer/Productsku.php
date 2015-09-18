<?php
/**
 * aheadWorks Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://ecommerce.aheadworks.com/LICENSE-L.txt
 *
 * @category   AW
 * @package    AW_Blog
 * @copyright  Copyright (c) 2009-2010 aheadWorks Co. (http://www.aheadworks.com)
 * @license    http://ecommerce.aheadworks.com/LICENSE-L.txt
 */

class Int_Dailydeals_Block_Adminhtml_Dailydeals_Renderer_Productsku extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
   public function render(Varien_Object $row)
	{
	
		$pro_id=$row->getrelated_product();
		
		//$media=Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA);
		
		//$file=$media.$value;
		$product_collection=Mage::getModel('catalog/product')->load($pro_id);
       $sku=	$product_collection->getSku();		
	
		
		return $sku;
		
	 
	}
}
