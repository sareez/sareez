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

 


class Itoris_AjaxMiniCart_Block_Cart extends Mage_Core_Block_Template {

	protected function _prepareLayout() {
		$head = $this->getLayout()->getBlock('head');
		$helper = Mage::helper('itoris_ajaxminicart');
		if ($head && $helper->isEnabledOnFrontend()) {
			// for products options
			$head->addJs('varien/product.js');
			$head->addJs('varien/configurable.js');
			$head->addItem('skin_js', 'js/bundle.js');
			$head->addItem('js_css', 'calendar/calendar-win2k-1.css');
			$head->addItem('js', 'calendar/calendar.js');
			$head->addItem('js', 'calendar/calendar-setup.js');

			$head->addJs('itoris/ajaxminicart/cart.js');
			$head->addCss('itoris/ajaxminicart/main.css');

			if ($helper->isEnabledGroupedConfiguration()) {
				$head->addJs('itoris/groupedproductconfiguration/groupedproduct.js');
				$head->addCss('itoris/groupedproductconfiguration/css/groupedproduct.css');
			}
			if ($helper->isEnabledDynamicProductOptions()) {
				$head->addJs('itoris/dynamicproductoptions/options.js');
				$head->addCss('itoris/dynamicproductoptions/main.css');
			}
		}
		return parent::_prepareLayout();
	}

	public function getCartConfigJson() {
		$urlParams = array('_secure' => Mage::app()->getStore()->isCurrentlySecure());
		$config = array(
			'add_to_cart_url'  => $this->getUrl('ajaxminicart/cart/add', $urlParams),
			'update_cart_url'  => $this->getUrl('ajaxminicart/cart/updateItemOptions', $urlParams),
			'load_cart_url'    => $this->getUrl('ajaxminicart/cart/loadCartContent', $urlParams),
			'remove_item_url'  => $this->getUrl('ajaxminicart/cart/remove', $urlParams),
			'remove_all_items_url'  => $this->getUrl('ajaxminicart/cart/removeAll', $urlParams),
			'load_options_url' => $this->getUrl('ajaxminicart/product/loadOptions', $urlParams),
			'load_all_products_options_url' => $this->getUrl('ajaxminicart/product/loadAllProductsOptions', $urlParams),
			'enable_animation' => (bool)Mage::helper('itoris_ajaxminicart')->getSettings()->getEnableAnimation(),
			'is_product_view' => Mage::registry('current_product') ? true : false,
			'translates'       => array(
				'configure'   => $this->__('Configure %s'),
				'add_message' => $this->__('%s has been added to your Shopping Cart'),
				'delete_message' => $this->__('%s has been removed from your Shopping Cart'),
				'update_message' => $this->__('%s has been updated'),
				'delete_all_message' => $this->__('All Products have been removed from your Shopping Cart'),
			),
		);
		if (Mage::registry('current_product')) {
			if ($this->getRequest()->getActionName() == 'configure' && $this->getRequest()->getControllerName() == 'cart') {
				$config['add_current_product_url'] = $this->getUrl('ajaxminicart/cart/updateItemOptions', array('_current' => true));
			} else {
				$config['add_current_product_url'] = $this->getUrl('ajaxminicart/cart/add', array(
					'product'    => Mage::registry('current_product'),
					'use_iframe' => 1,
				));
			}
		}

		return Zend_Json::encode($config);
	}

	protected function _toHtml() {
		$rootBlock = $this->getLayout()->getBlock('root');
		if (!Mage::helper('itoris_ajaxminicart')->isEnabledOnFrontend() || ($rootBlock && $rootBlock->getTemplate() == 'page/popup.phtml')) {
			return '';
		}
		return parent::_toHtml();
	}
}
?>
