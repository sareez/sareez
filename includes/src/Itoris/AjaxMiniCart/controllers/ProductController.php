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


require_once Mage::getModuleDir('controllers', 'Mage_Catalog') . DS . 'ProductController.php';

class Itoris_AjaxMiniCart_ProductController extends Mage_Catalog_ProductController {

	public function loadOptionsAction() {
		$result = array();
		try {
			$alertError = Mage::getSingleton('core/session')->getMiniCartAlertError(true);
			// Get initial data from request
			$categoryId = (int) $this->getRequest()->getParam('category', false);
			$params = new Varien_Object();
			$params->setCategoryId($categoryId);
			$params->setSpecifyOptions($this->getRequest()->getParam('options'));
			$finalPrice = null;
			$qty = null;
			if ($this->getRequest()->getParam('item_id')) {
				/** @var $quote Mage_Sales_Model_Quote */
				$quote = Mage::getSingleton('checkout/session')->getQuote();
				/** @var $item Mage_Sales_Model_Quote_Item */
				$item = $quote->getItemById($this->getRequest()->getParam('item_id'));
				if (!$item->getId()) {
					throw new Exception('Product is not loaded');
				}
				$item->setQuote(Mage::getSingleton('checkout/session')->getQuote());
				$productId = $item->getProduct()->getId();
				$params->setBuyRequest($item->getBuyRequest());
				$finalPrice = Mage::helper('tax')->displayCartPriceInclTax()
					? Mage::helper('checkout')->getPriceInclTax($item) : $item->getCalculationPrice();
				$qty = $item->getTotalQty();
			} else {
				$productId = $this->getRequest()->getParam('product_id');
				if (!$productId) {
					$requestPath = $this->getRequest()->getParam('request_path');
					if (is_numeric($requestPath)) {
						$productId = $requestPath;
					} else {
						$productId  = (int) $this->_getProductIdByRequestPath($requestPath);
					}
				}
			}
			/** @var $productHelper Mage_Catalog_Helper_Product */
			$productHelper = Mage::helper('catalog/product');
			if (method_exists($productHelper, 'initProduct')) {
				$product = $productHelper->initProduct($productId, $this, $params);
			} else {
				$this->getRequest()->setParam('id', $productId);
				$product = $this->_initProduct();
			}

			if (!$product) {
				throw new Exception('Product is not loaded');
			}
			$buyRequest = $params->getBuyRequest();
			if ($buyRequest) {
				$productHelper->prepareProductOptions($product, $buyRequest);
			}
			Mage::dispatchEvent('catalog_controller_product_view', array('product' => $product));

			if (method_exists($productHelper, 'initProduct')) {
				Mage::helper('catalog/product_view')->initProductLayout($product, $this);
			} else {
				$this->_initProductLayout($product);
			}

			if ($product->getTypeId() == 'grouped') {
				$viewBlockGrouped = $this->getLayout()->getBlock('product.info.grouped');
				$html = $viewBlockGrouped->toHtml();
				if ($this->getDataHelper()->isEnabledGroupedConfiguration()) {
					$html .= '<script type="text/javascript">optionsPrice = {};if(typeof tierPriceElement == \'undefined\'){tierPriceElement = {update:function(){}};}</script>';
					$html .= '<div id="product_addtocart_form"></div>';
					$html .= str_replace('var optionsPrice', 'optionsPrice', $this->getLayout()->getBlock('grouped_product_edit')->toHtml());
					$html = str_replace('var bundle', 'bundle', $html);
				}
			} else {
				$additionalJs = '';
				$optionsBlock = $this->getLayout()->getBlock('product.info.options.wrapper');
				$viewBlock = $this->getLayout()->getBlock('product.info');
				if ($product->getTypeId() == 'bundle') {
					$viewBlockBundle = $this->getLayout()->getBlock('product.info.bundle');
					$additionalJs = "taxCalcMethod = '" . Mage::helper('tax')->getConfig()->getAlgorithm($product->getStore()) . "';";
					$additionalJs .= "CACL_UNIT_BASE = '" . Mage_Tax_Model_Calculation::CALC_UNIT_BASE . "';";
					$additionalJs .= "CACL_ROW_BASE = '" . Mage_Tax_Model_Calculation::CALC_ROW_BASE . "';";
					$additionalJs .= "CACL_TOTAL_BASE = '" . Mage_Tax_Model_Calculation::CALC_TOTAL_BASE . "';";
					$additionalJs .= 'optionsPrice.tierPrices = [];bundle = new Product.Bundle(' . $viewBlockBundle->getJsonConfig() . ');';
					$additionalJs .= "if(typeof Itoris.BundlePromotions == 'undefined'){Itoris.BundlePromotions = Class.create();}";
				}
				$html = '<script type="text/javascript">';
				$html .= 'optionsPrice = new MiniCartProductOptionsPrice(' . $viewBlock->getJsonConfig() . ');';
				$html .= $additionalJs .'</script>';
				if ($product->getHasOptions() || $product->getTypeId() != 'simple') {
					$calendar = Mage::app()->getLayout()->createBlock('core/html_calendar')->setTemplate('page/js/calendar.phtml');
					$html .= $calendar->toHtml() . $optionsBlock->toHtml();
				}
			}
			if ($this->getDataHelper()->isEnabledDynamicProductOptions()) {
				$html = $this->_addDynamicOptionsHtml($html);
			}
			$result = array(
				'content' => $html,
				'product_name' => $product->getName(),
				'product_id'   => $product->getId(),
				'product_type' => $product->getTypeId(),
				'price'        => Mage::app()->getStore()->formatPrice($finalPrice ? $finalPrice : Mage::helper('tax')->getPrice($product, $product->getFinalPrice()), false),
				'qty'          => $qty ? (int)$qty : 1,
				'alert_error'  => $alertError,
			);
		} catch (Exception $e) {
			$result['error'] = 'Product has not been loaded';
		}
		$this->getResponse()->setBody(Zend_Json::encode($result));
	}

	protected function _getProductIdByRequestPath($requestPath) {
		$resource = Mage::getResourceModel('catalog/product_collection');
		$select = $resource->getConnection()->select()
			->from($resource->getTable('core/url_rewrite'), array('product_id'))
			->where('store_id = ?', Mage::app()->getStore()->getId())
			->where('is_system = ?', 1)
			->where('request_path =?', $requestPath);
		foreach ($resource->getConnection()->fetchAll($select) as $row) {
			return $row['product_id'];
		}
		return null;

	}

	public function addActionLayoutHandles() {
		if ($this->getRequest()->getRequestedActionName() == 'loadOptions' || $this->getRequest()->getRequestedActionName() == 'loadAllProductsOptions') {
			$update = $this->getLayout()->getUpdate();
			$update->addHandle('STORE_'.Mage::app()->getStore()->getCode());
			$package = Mage::getSingleton('core/design_package');
			$update->addHandle(
				'THEME_'.$package->getArea().'_'.$package->getPackageName().'_'.$package->getTheme('layout')
			);
			$update->addHandle('catalog_product_view');
		} else {
			parent::addActionLayoutHandles();
		}

		return $this;
	}

	public function loadAllProductsOptionsAction() {
		$result = array('products' => array());
		try {
			$alertError = Mage::getSingleton('core/session')->getMiniCartAlertError(true);
			// Get initial data from request
			$categoryId = (int) $this->getRequest()->getParam('category', false);
			$products = $this->getRequest()->getParam('products');
			foreach ($products as $requestPath) {
				Mage::unregister('current_product');
				Mage::unregister('product');
				Mage::unregister('current_category');
				Mage::unregister('storeId');
				Mage::unregister('_singleton/catalog/product_type');
				Mage::unregister('_singleton/catalog/product_option');
				$this->getLayout()->getUpdate()->resetHandles();

				if (is_numeric($requestPath)) {
					$productId = $requestPath;
				} else {
					$productId  = (int) $this->_getProductIdByRequestPath($requestPath);
				}

				$params = new Varien_Object();
				$params->setCategoryId($categoryId);
				$params->setSpecifyOptions($this->getRequest()->getParam('options'));
				$finalPrice = null;
				$qty = null;

				/** @var $productHelper Mage_Catalog_Helper_Product */
				$productHelper = Mage::helper('catalog/product');
				if (method_exists($productHelper, 'initProduct')) {
					$product = $productHelper->initProduct($productId, $this, $params);
				} else {
					$this->getRequest()->setParam('id', $productId);
					$product = $this->_initProduct();
				}

				if (!$product) {
					throw new Exception('Product is not loaded');
				}
				$buyRequest = $params->getBuyRequest();
				if ($buyRequest) {
					$productHelper->prepareProductOptions($product, $buyRequest);
				}
				Mage::dispatchEvent('catalog_controller_product_view', array('product' => $product));

				if (method_exists($productHelper, 'initProduct')) {
					Mage::helper('catalog/product_view')->initProductLayout($product, $this);
				} else {
					$this->_initProductLayout($product);
				}

				if ($product->getTypeId() == 'grouped') {
					$viewBlockGrouped = $this->getLayout()->getBlock('product.info.grouped');
					$html = $viewBlockGrouped->toHtml();
					if ($this->getDataHelper()->isEnabledGroupedConfiguration()) {
						$html .= '<script type="text/javascript">optionsPrice = {};if(typeof tierPriceElement == \'undefined\'){tierPriceElement = {update:function(){}};}</script>';
						$html .= '<div id="product_addtocart_form"></div>';
						$html .= str_replace('var optionsPrice', 'optionsPrice', $this->getLayout()->getBlock('grouped_product_edit')->toHtml());
						$html = str_replace('var bundle', 'bundle', $html);
					}
				} else {
					$additionalJs = '';
					$optionsBlock = $this->getLayout()->getBlock('product.info.options.wrapper');
					$viewBlock = $this->getLayout()->getBlock('product.info');
					if ($product->getTypeId() == 'bundle') {
						$viewBlockBundle = $this->getLayout()->getBlock('product.info.bundle');
						$additionalJs = "taxCalcMethod = '" . Mage::helper('tax')->getConfig()->getAlgorithm($product->getStore()) . "';";
						$additionalJs .= "CACL_UNIT_BASE = '" . Mage_Tax_Model_Calculation::CALC_UNIT_BASE . "';";
						$additionalJs .= "CACL_ROW_BASE = '" . Mage_Tax_Model_Calculation::CALC_ROW_BASE . "';";
						$additionalJs .= "CACL_TOTAL_BASE = '" . Mage_Tax_Model_Calculation::CALC_TOTAL_BASE . "';";
						$additionalJs .= 'optionsPrice.tierPrices = [];bundle = new Product.Bundle(' . $viewBlockBundle->getJsonConfig() . ');';
						$additionalJs .= "if(typeof Itoris.BundlePromotions == 'undefined'){Itoris.BundlePromotions = Class.create();}";
					}
					$html = '<script type="text/javascript">';
					$html .= 'optionsPrice = new MiniCartProductOptionsPrice(' . $viewBlock->getJsonConfig() . ');';
					$html .= $additionalJs .'</script>';
					if ($product->getHasOptions() || $product->getTypeId() != 'simple') {
						$calendar = Mage::app()->getLayout()->createBlock('core/html_calendar')->setTemplate('page/js/calendar.phtml');
						$html .= $calendar->toHtml() . $optionsBlock->toHtml();
					}
				}
				if ($this->getDataHelper()->isEnabledDynamicProductOptions()) {
					$html = $this->_addDynamicOptionsHtml($html);
				}
				$result['products'][] = array(
					'content' => $html,
					'product_name' => $product->getName(),
					'product_id'   => $product->getId(),
					'product_type' => $product->getTypeId(),
					'price'        => Mage::app()->getStore()->formatPrice($finalPrice ? $finalPrice : Mage::helper('tax')->getPrice($product, $product->getFinalPrice()), false),
					'qty'          => $qty ? (int)$qty : 1,
					'request_path' => $requestPath,
				);
			}
			$result['alert_error'] = $alertError;
		} catch (Exception $e) {
			$result['error'] = 'Product has not been loaded';
			$result['error_d'] = $e->getMessage();
		}
		$this->getResponse()->setBody(Zend_Json::encode($result));
	}

	protected function _addDynamicOptionsHtml($html) {
		$dynamicOptionsJs = "<script type=\"text/javascript\">
			domLoadedObservers = [];
			addDomLoadedObserver = function(emptyParam, observerFunction){
				domLoadedObservers.push(observerFunction);
			}
			DynamicProductOptionsMiniCart = Class.create();
			Object.extend(Object.extend(DynamicProductOptionsMiniCart.prototype, DynamicProductOptions.prototype), {
				initialize : function(config, options, isGrouped) {
					this.config = config;
					this.config.appearance = 'on_product_view';
					this.options = options;
					this.popup = $('itoris_dynamicproductoptions_popup');
					this.popupMask = $('itoris_dynamicproductoptions_popup_mask');
					this.productForm = $('ajax_mini_cart_product_options_form');
					this.addToCartButton = null;
					this.addToCartBlock = null;
					this.buttonConfigure = null;
					if (!this.options.length && !this.canShowWithoutOptions()) {
						return;
					}
					this.canReloadPrice = true;
					this.isInit = false;
					this.prepareOptions();
					this.initForm();
					this.isInit = true;
					if ((this.config.is_configured || this.config.option_errors.length) && this.getAppearance() == 'popup_configure') {
						this.showConfiguration();
					}
					if (this.config.option_errors.length) {
						if (this.getAppearance() == 'popup_configure' || this.getAppearance() == 'popup_cart') {
							this.showPopup();
							setTimeout(function() {alert(this.config.error_message);}.bind(this), 600);
						} else {
							alert(this.config.error_message);
						}
						for (var i = 0; i < this.config.option_errors.length; i++) {
							this.showFieldError(this.config.option_errors[i].option_id, this.config.option_errors[i].message);
						}
					}
					miniCart.dynamicOptionObjs.push(this);
				},
				getOpConfig : function() {
					if (this.config.is_grouped) {
						return eval('opConfig' + this.config.product_id);
					}
					return miniCartOpConfig;
				},
				beforeAddToCart: function() {
					this.hideDefaultMessages();
					this.skipValidationOptions = [];
					this.productForm.select('input,textarea,select').each(function(elm){
						if (elm.disabled && elm.hasClassName('required-entry')) {
							elm.removeClassName('required-entry');
							this.skipValidationOptions.push(elm);
						}
					}.bind(this));
				},
				afterAddToCart: function() {
					this.showDefaultMessages();
					this.skipValidationOptions.each(function(elm){
						elm.addClassName('required-entry');
					});
				}
			});
			</script>";
		$html = $dynamicOptionsJs . $html;
		$html .= str_replace('new DynamicProductOptions', 'new DynamicProductOptionsMiniCart', $this->getLayout()->getBlock('itoris_dynamicoptions_config')->toHtml());
		$html = str_replace('document.observe(\'dom:loaded\',', 'addDomLoadedObserver(null,', $html);
		$html .= "<script type=\"text/javascript\">
				domLoadedObservers.each(function(func){func();});
				if (typeof validateOptionsCallback == 'undefined') {
					validateOptionsCallback = function() {};
				}
			</script>";

		return $html;
	}

	/**
	 * @return Itoris_AjaxMiniCart_Helper_Data
	 */
	protected function getDataHelper() {
		return Mage::helper('itoris_ajaxminicart');
	}
}
?>
