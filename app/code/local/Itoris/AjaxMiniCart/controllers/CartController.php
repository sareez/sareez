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

 
require_once Mage::getModuleDir('controllers', 'Mage_Checkout') . DS . 'CartController.php';

class Itoris_AjaxMiniCart_CartController extends Mage_Checkout_CartController {

	public function addAction() {
		$result = array('error' => null, 'ok' => false);
		$cart   = $this->_getCart();
		$params = $this->getRequest()->getParams();
		try {
			if (isset($params['qty'])) {
				$filter = new Zend_Filter_LocalizedToNormalized(
					array('locale' => Mage::app()->getLocale()->getLocaleCode())
				);
				$params['qty'] = $filter->filter($params['qty']);
			}

			$product = $this->_initProduct();

			$related = $this->getRequest()->getParam('related_product');

			/**
			 * Check product availability
			 */
			if (!$product) {
				$result['error'] = $this->__('Product is not available');
				$this->getResponse()->setBody(Zend_Json::encode($result));
				return;
			}
			$existsItems = is_array($cart->getItems()) ? array() : $cart->getItems()->getAllIds();
			if ($product->getTypeId() == 'grouped' && Mage::helper('itoris_ajaxminicart')->isEnabledGroupedConfiguration()) {
				$this->_addGroupedProductConfiguration();
			} else {
				$cart->addProduct($product, $params);
			}

			if (!empty($related)) {
				$cart->addProductsByIds(explode(',', $related));
			}

			$cart->save();

			$this->_getSession()->setCartWasUpdated(true);

			Mage::dispatchEvent('checkout_cart_add_product_complete',
				array('product' => $product, 'request' => $this->getRequest(), 'response' => $this->getResponse())
			);
			$result['ok'] = true;
			$result['product_name'] = $product->getName();
			$this->_prepareCartConfigForResponse($result, $existsItems, false);
		} catch (Mage_Core_Exception $e) {
			$result['error'] = $e->getMessage();
		} catch (Exception $e) {
			$result['error'] = $this->__('Cannot add the item to shopping cart.');
			Mage::logException($e);
		}
		if ($this->getRequest()->getParam('use_iframe')) {
			$this->getResponse()->setBody('<div id="response">' . Zend_Json::encode($result) . '</div>');
			return;
		} else if ($result['error']) {
			Mage::getSingleton('core/session')->setMiniCartAlertError($result['error']);
			$this->_redirect('*/product/loadOptions', array('product_id' => $product->getId()));
			return;
		}

		$this->getResponse()->setBody(Zend_Json::encode($result));
	}

	protected function _addGroupedProductConfiguration() {
		$params = $this->getRequest()->getParams();
		$cart = $this->_getCart();
		$qtyCount = 0;
		foreach ($params as $paramName => $value) {
			if ($paramName == 'super_group' && is_array($params['super_group'])) {
				foreach ($value as $productId => $qty) {
					if ($qty >= 1) {
						$product = Mage::getModel('catalog/product')->load($productId);
						$productOptions = $product->getOptions();
						$options = '';
						foreach ($productOptions as $optionId => $option) {
							$options .=  $optionId . ',';
						}
						$options = substr($options, 0, -1);
						$optionArray = array();
						if (array_key_exists('options', $params)) {
							foreach ($params['options'] as $idOption => $checkValue) {
								if (strpos($options, (string)$idOption) !== false) {
									$optionArray[$idOption] = $checkValue;
								}
							}
						}
						$bundleOptions = array();
						$bundleOptionsQty = array();
						if (array_key_exists('bundle_option', $params) && array_key_exists($productId, $params['bundle_option'])) {
							$bundleOptions = $params['bundle_option'][$productId];
						}
						if (array_key_exists('bundle_option_qty', $params) && array_key_exists($productId, $params['bundle_option_qty'])) {
							$bundleOptionsQty = $params['bundle_option_qty'][$productId];
						}

						$associatedProductParams = array(
							'product' => (string)$productId,
							'options' => $optionArray,
							'super_attribute' => isset($params['super_product'][$productId]['super_attribute'])
								? $params['super_product'][$productId]['super_attribute'] : null,
							'bundle_option' => $bundleOptions,
							'bundle_option_qty' => $bundleOptionsQty,
							'qty' => $qty
						);
						$cart->addProduct($product, $associatedProductParams);
						$qtyCount++;
					}
				}
			}
		}
		if (!$qtyCount) {
			throw new Mage_Core_Exception($this->__('Cannot add the item to shopping cart.'));
		}
	}

	public function removeAction() {
		$result = array('error' => null, 'ok' => false);
		$id = (int) $this->getRequest()->getParam('id');
		if ($id) {
			try {
				$item = $this->_getCart()->getQuote()->getItemById($id);
				if ($item) {
					$productName = $item->getProduct()->getName();
					$this->_getCart()->removeItem($id)
						->save();
					$result['ok'] = true;
					$result['product_name'] = $productName;
					$this->_prepareCartConfigForResponse($result);
				} else {
					$result['error'] = 'Item is not loaded';
				}
			} catch (Exception $e) {
				$result['error'] = $this->__('Cannot remove the item from shopping cart.');
				Mage::logException($e);
			}
		} else {
			$result['error'] = $this->__('Please specify item id.');
		}
		$this->getResponse()->setBody(Zend_Json::encode($result));
	}

	public function removeAllAction() {
		$result = array('error' => null, 'ok' => false);

		try {
			foreach ($this->_getCart()->getQuote()->getAllItems() as $item) {
				$this->_getCart()->removeItem($item->getId());
			}
			$this->_getCart()->save();
			$result['ok'] = true;
			$this->_prepareCartConfigForResponse($result);
		} catch (Exception $e) {
			$result['error'] = $this->__('Cannot remove the item from shopping cart.');
			Mage::logException($e);
		}

		$this->getResponse()->setBody(Zend_Json::encode($result));
	}

	public function updateItemOptionsAction() {
		$result = array('error' => null, 'ok' => false);
		$cart   = $this->_getCart();
		$id = (int)$this->getRequest()->getParam('id');
		$params = $this->getRequest()->getParams();

		if (!isset($params['options'])) {
			$params['options'] = array();
		}
		try {
			if (isset($params['qty'])) {
				$filter = new Zend_Filter_LocalizedToNormalized(
					array('locale' => Mage::app()->getLocale()->getLocaleCode())
				);
				$params['qty'] = $filter->filter($params['qty']);
			}

			$quoteItem = $cart->getQuote()->getItemById($id);
			if (!$quoteItem) {
				$result['error'] = $this->__('Quote item is not found.');
			}
			if (method_exists($cart, 'updateItem')) {
				$item = $cart->updateItem($id, new Varien_Object($params));
			} else {
				$item = $this->_updateItem($id, new Varien_Object($params));
			}
			if (is_string($item)) {
				$result['error'] = $item;
			}
			if ($item->getHasError()) {
				$result['error'] = $item->getMessage();
			}

			$related = $this->getRequest()->getParam('related_product');
			if (!empty($related)) {
				$cart->addProductsByIds(explode(',', $related));
			}

			$cart->save();

			$this->_getSession()->setCartWasUpdated(true);

			Mage::dispatchEvent('checkout_cart_update_item_complete',
				array('item' => $item, 'request' => $this->getRequest(), 'response' => $this->getResponse())
			);
			$result['ok'] = true;
			$optionsHtml = $this->getLayout()->createBlock('itoris_ajaxminicart/product_info')->setItem($item)->toHtml();
			$priceInclTax = Mage::helper('tax')->displayCartPriceInclTax();
			$checkoutHelper = Mage::helper('checkout');
			$itemPrice = $priceInclTax ? $checkoutHelper->getPriceInclTax($item) : $item->getCalculationPrice();
			$itemData = array(
				'old_id' => $id,
				'id'  => $item->getId(),
				'qty' => $item->getTotalQty(),
				'price' => Mage::app()->getStore()->formatPrice($itemPrice, false),
				'product_name' => $item->getProduct()->getName(),
				'options_html' => $optionsHtml ? htmlentities($optionsHtml, ENT_NOQUOTES) : '',
				'image_url'    => (string)Mage::helper('catalog/image')->init($item->getProduct(), 'small_image')->resize(90),
				'is_visible'   => $item->getProduct()->isVisibleInSiteVisibility(),
				'edit_url'     => Mage::app()->getStore()->getUrl('checkout/cart/configure', array('id' => $item->getId())),
			);
			$result['item_config'] = $itemData;
			$this->_prepareCartConfigForResponse($result);
		} catch (Mage_Core_Exception $e) {
			$this->_getSession()->getUseNotice(true);
			$result['error'] = $e->getMessage();
		} catch (Exception $e) {
			$result['error'] = $this->__('Cannot update the item.');
			Mage::logException($e);
		}
		$this->getResponse()->setBody('<div id="response">' . Zend_Json::encode($result) . '</div>');
	}

	/**
	 * for old magento
	 *
	 * @param $itemId
	 * @param null $requestInfo
	 * @param null $updatingParams
	 * @return Mage_Sales_Model_Quote_Item|string
	 */
	protected function _updateItem($itemId, $requestInfo = null, $updatingParams = null) {
		$cart = $this->_getCart();
		try {
			$item = $cart->getQuote()->getItemById($itemId);
			if (!$item) {
				Mage::throwException(Mage::helper('checkout')->__('Quote item does not exist.'));
			}
			$productId = $item->getProduct()->getId();
			$product = $product = Mage::getModel('catalog/product')
					->setStoreId(Mage::app()->getStore()->getId())
					->load($productId);
			$currentWebsiteId = Mage::app()->getStore()->getWebsiteId();
			if (!$product->getId() || !is_array($product->getWebsiteIds()) || !in_array($currentWebsiteId, $product->getWebsiteIds())) {
				Mage::throwException(Mage::helper('checkout')->__('The product could not be found.'));
			}
			if ($requestInfo instanceof Varien_Object) {
				$request = $requestInfo;
			} elseif (is_numeric($requestInfo)) {
				$request = new Varien_Object(array('qty' => $requestInfo));
			} else {
				$request = new Varien_Object($requestInfo);
			}

			if (!$request->hasQty()) {
				$request->setQty(1);
			}
			if ($product->getStockItem()) {
				$minimumQty = $product->getStockItem()->getMinSaleQty();
				// If product was not found in cart and there is set minimal qty for it
				if ($minimumQty && ($minimumQty > 0)
					&& ($request->getQty() < $minimumQty)
					&& !$cart->getQuote()->hasProductId($productId)
				) {
					$request->setQty($minimumQty);
				}
			}
			if (method_exists($cart->getQuote(), 'updateItem')) {
				$result = $cart->getQuote()->updateItem($itemId, $request, $updatingParams);
			} else {
				$result = $this->_updateQuoteItem($itemId, $request, $updatingParams);
			}
		} catch (Mage_Core_Exception $e) {
			$cart->getCheckoutSession()->setUseNotice(false);
			$result = $e->getMessage();
		}

		/**
		 * We can get string if updating process had some errors
		 */
		if (is_string($result)) {
			if ($cart->getCheckoutSession()->getUseNotice() === null) {
				$cart->getCheckoutSession()->setUseNotice(true);
			}
			Mage::throwException($result);
		}

		Mage::dispatchEvent('checkout_cart_product_update_after', array(
			'quote_item' => $result,
			'product' => $product
		));
		$cart->getCheckoutSession()->setLastAddedProductId($productId);
		return $result;
	}

	/**
	 * for old magento
	 *
	 * @param $itemId
	 * @param $buyRequest
	 * @param null $params
	 * @return Mage_Sales_Model_Quote_Item|string
	 */
	protected function _updateQuoteItem($itemId, $buyRequest, $params = null) {
		$quote = $this->_getCart()->getQuote();
		$item = $quote->getItemById($itemId);
		if (!$item) {
			Mage::throwException(Mage::helper('sales')->__('Wrong quote item id to update configuration.'));
		}
		$productId = $item->getProduct()->getId();

		//We need to create new clear product instance with same $productId
		//to set new option values from $buyRequest
		$product = Mage::getModel('catalog/product')
			->setStoreId($quote->getStore()->getId())
			->load($productId);

		if (!$params) {
			$params = new Varien_Object();
		} else if (is_array($params)) {
			$params = new Varien_Object($params);
		}
		$params->setCurrentConfig($item->getBuyRequest());
		$buyRequest = $this->_addParamsToBuyRequest($buyRequest, $params);

		$buyRequest->setResetCount(true);
		$resultItem = $quote->addProduct($product, $buyRequest);

		if (is_string($resultItem)) {
			Mage::throwException($resultItem);
		}

		if ($resultItem->getParentItem()) {
			$resultItem = $resultItem->getParentItem();
		}

		if ($resultItem->getId() != $itemId) {
			/*
			 * Product configuration didn't stick to original quote item
			 * It either has same configuration as some other quote item's product or completely new configuration
			 */
			$quote->removeItem($itemId);

			$items = $quote->getAllItems();
			foreach ($items as $item) {
				if (($item->getProductId() == $productId) && ($item->getId() != $resultItem->getId())) {
					if ($resultItem->compare($item)) {
						// Product configuration is same as in other quote item
						$resultItem->setQty($resultItem->getQty() + $item->getQty());
						$quote->removeItem($item->getId());
						break;
					}
				}
			}
		} else {
			$resultItem->setQty($buyRequest->getQty());
		}

		return $resultItem;
	}

	/**
	 * for old magento
	 *
	 * @param $buyRequest
	 * @param $params
	 * @return Varien_Object
	 */
	protected function _addParamsToBuyRequest($buyRequest, $params) {
		if (is_array($buyRequest)) {
			$buyRequest = new Varien_Object($buyRequest);
		}
		if (is_array($params)) {
			$params = new Varien_Object($params);
		}


		// Ensure that currentConfig goes as Varien_Object - for easier work with it later
		$currentConfig = $params->getCurrentConfig();
		if ($currentConfig) {
			if (is_array($currentConfig)) {
				$params->setCurrentConfig(new Varien_Object($currentConfig));
			} else if (!($currentConfig instanceof Varien_Object)) {
				$params->unsCurrentConfig();
			}
		}

		/*
		 * Notice that '_processing_params' must always be object to protect processing forged requests
		 * where '_processing_params' comes in $buyRequest as array from user input
		 */
		$processingParams = $buyRequest->getData('_processing_params');
		if (!$processingParams || !($processingParams instanceof Varien_Object)) {
			$processingParams = new Varien_Object();
			$buyRequest->setData('_processing_params', $processingParams);
		}
		$processingParams->addData($params->getData());

		return $buyRequest;
	}

	public function loadCartContentAction() {
		$result = array('ok' => false);
		try {
			$this->_prepareCartConfigForResponse($result, array(), false);
			$result['ok'] = true;
		} catch (Exception $e) {
			$result['error'] = $e->getMessage();
		}
		$this->getResponse()->setBody(Zend_Json::encode($result));
	}

	protected function _prepareCartConfigForResponse(&$result, $existsItems = null, $withoutItemsInfo = true) {
		$cart = $this->_getCart();
		if (!$withoutItemsInfo) {
			if (is_null($existsItems)) {
				$existsItems = $cart->getItems()->getAllIds();
			}
		}
		$summaryQty = $cart->getSummaryQty();
		$result['items_count'] = $summaryQty;
		$result['grand_total'] = Mage::app()->getStore()->formatPrice($cart->getQuote()->getGrandTotal(), false);

		/** @var $cartHelper Mage_Checkout_Helper_Cart */
		$cartHelper = Mage::helper('checkout/cart');
		if ($summaryQty == 1) {
			$linkText = $cartHelper->__('%s item  ', $summaryQty);
			//$linkText .= $result['grand_total'];
		} elseif ($summaryQty > 0) {
			$linkText = $cartHelper->__('%s items  ', $summaryQty);
			//$linkText .= $result['grand_total'];
		} else {
			$linkText = $cartHelper->__('0 item  ');
			//$linkText .= $result['grand_total'];
		}
		$result['link_text'] = htmlentities($linkText);
		//$result['link_text'] .= "</br>";
		$result['link_text'] .= $result['grand_total'];
		$priceInclTax = Mage::helper('tax')->displayCartPriceInclTax();
		$checkoutHelper = Mage::helper('checkout');
		if (!$withoutItemsInfo) {
			$result['items'] = array();
			/** @var $item Mage_Sales_Model_Quote_Item */
			foreach ($cart->getItems() as $item) {
				if ($item->getParentItemId()) {
					continue;
				}
				$itemData = array(
					'id'  => $item->getId(),
					'qty' => $item->getTotalQty(),
				);
				if (!in_array($item->getId(), $existsItems)) {
					$itemPrice = $priceInclTax ? $checkoutHelper->getPriceInclTax($item) : $item->getCalculationPrice();
					$itemData['price'] = Mage::app()->getStore()->formatPrice($itemPrice, false);
					$itemData['image_url'] = (string)Mage::helper('catalog/image')->init($item->getProduct(), 'small_image')->resize(90);
					$itemData['product_name'] = $item->getProduct()->getName();
					$optionsHtml = $this->getLayout()->createBlock('itoris_ajaxminicart/product_info')->setItem($item)->toHtml();
					$itemData['options_html'] = $optionsHtml ? htmlentities($optionsHtml, ENT_NOQUOTES) : '';
					$itemData['is_visible'] = $item->getProduct()->isVisibleInSiteVisibility();
					$itemData['edit_url'] = $item->getProduct()->getProductUrl();
				}
				$result['items'][] = $itemData;
			}
		}
	}
}
?>
