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

class Indies_Whatsappshare_Block_Adminhtml_Whatsappshare_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('whatsappshare_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('whatsappshare')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('whatsappshare')->__('Item Information'),
          'title'     => Mage::helper('whatsappshare')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('whatsappshare/adminhtml_whatsappshare_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}