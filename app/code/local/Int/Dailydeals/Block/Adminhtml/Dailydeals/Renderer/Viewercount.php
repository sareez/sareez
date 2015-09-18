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

class Int_Dailydeals_Block_Adminhtml_Dailydeals_Renderer_Viewercount extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
   public function render(Varien_Object $row)
	{
	
		$deal_id=$row->getdailydeals_id();
		
		//$media=Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA);
		
		//$file=$media.$value;
		$coll=Mage::getModel('dailydeals/dealviewer')->getCollection()->addFieldToFilter('deal_id',$deal_id)->getData();
       $count=	count($coll);	
	
		if($count!=""){
		return $count;
		}else{
		return '0';
		}
	 
	}
}
