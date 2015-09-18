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
class Indies_Whatsappshare_Model_Adminhtml_System_Config_Source_Size extends Varien_Object
{
    const small  = 'small';
    const medium = 'medium';
	const large='large';

    static public function toOptionArray()
    {
        return array(
            array(
                'value' => self::small,
                'label' => Mage::helper('whatsappshare')->__('Small')
            ),
            array(
                'value' => self::medium,
                'label' => Mage::helper('whatsappshare')->__('Medium')
            ),
			array(
                'value' => self::large,
                'label' => Mage::helper('whatsappshare')->__('Large')
            )
        );
    }
}