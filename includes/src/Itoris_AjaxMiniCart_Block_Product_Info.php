<?php 
/**
 * ITORIS
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the ITORIS's Magento Extensions License Agreement
 * which is available through the world-wide-web at this URL:
 * http://www.itoris.com/magento-extensions-license.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to sales@itoris.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the extensions to newer
 * versions in the future. If you wish to customize the extension for your
 * needs please refer to the license agreement or contact sales@itoris.com for more information.
 *
 * @category   ITORIS
 * @package    ITORIS_AJAXMINICART
 * @copyright  Copyright (c) 2013 ITORIS INC. (http://www.itoris.com)
 * @license    http://www.itoris.com/magento-extensions-license.html  Commercial License
 */

 


class Itoris_AjaxMiniCart_Block_Product_Info extends Mage_Checkout_Block_Cart_Item_Renderer {

	protected function _construct() {
		$this->setTemplate('itoris/ajaxminicart/product/info.phtml');
	}

	public function getProductOptions() {
		switch ($this->getItem()->getProductType()) {
			case 'bundle':
				$renderer = $this->getLayout()->createBlock('bundle/checkout_cart_item_renderer');
				$renderer->setItem($this->getItem());
				return $renderer->getOptionList();
			case 'configurable':
				$renderer = $this->getLayout()->createBlock('checkout/cart_item_renderer_configurable');
				$renderer->setItem($this->getItem());
				return $renderer->getOptionList();
		}
		return parent::getProductOptions();
	}
}
?>
