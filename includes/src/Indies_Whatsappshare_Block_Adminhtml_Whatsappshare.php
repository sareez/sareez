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
class Indies_Whatsappshare_Block_Adminhtml_Whatsappshare extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_whatsappshare';
    $this->_blockGroup = 'whatsappshare';
    $this->_headerText = Mage::helper('whatsappshare')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('whatsappshare')->__('Add Item');
    parent::__construct();
  }
}