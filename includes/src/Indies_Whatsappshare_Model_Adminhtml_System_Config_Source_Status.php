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
class Indies_Whatsappshare_Model_Adminhtml_System_Config_Source_Status extends Varien_Object
{
    const STATUS_ENABLED  = 1;
    const STATUS_DISABLED = 0;

    static public function toOptionArray()
    {
        return array(
            array(
                'value' => self::STATUS_ENABLED,
                'label' => Mage::helper('whatsappshare')->__('Enable')
            ),
            array(
                'value' => self::STATUS_DISABLED,
                'label' => Mage::helper('whatsappshare')->__('Disable')
            )
        );
    }
}