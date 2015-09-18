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

class Int_Catalogmaster_Block_Adminhtml_Producttype_Renderer_Website extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
   public function render(Varien_Object $row)
	{
	    
		$value=$row->getwebsites();
		$stores_id = explode(',',$value);
		$i = 0;
		foreach($stores_id as $strid){
		$name[] = Mage::getModel('core/store')->load($strid)->getName(); 
			
			if($name[$i] == "Admin"){
				$name[$i] = "All Store Views";
			}
			if($name[$i] == "magnamail"){
				$name[$i] = "Magnamail";
			}
			if($name[$i] == "Default Store View"){
				$name[$i] = "Main Website";
			}
			$i++;
		}
		$str_name = implode(',',$name);
		return $str_name;
		
	 
	}
}
