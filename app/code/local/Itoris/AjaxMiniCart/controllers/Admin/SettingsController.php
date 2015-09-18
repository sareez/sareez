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

 

 

class Itoris_AjaxMiniCart_Admin_SettingsController extends Itoris_AjaxMiniCart_Controller_Admin_Controller {

	public function indexAction() {
		$this->_getSession()->setBeforUrl(Mage::helper('core/url')->getCurrentUrl());
		$websiteCode = $this->getRequest()->getParam('website');
		if (!empty($websiteCode)) {
			$website = Mage::app()->getWebsite($websiteCode);
			if (!Mage::helper('itoris_ajaxminicart')->isRegistered($website)) {
				$error = '<b style="color:red">'
						 . Mage::helper('itoris_ajaxminicart')->__('The extension is not registered for the website selected. Please register it with an additional S/N.')
						 . '</b>';
				Mage::getSingleton('adminhtml/session')->addError($error);
			}
		}
		$this->loadLayout();
		$this->renderLayout();
	}

	public function saveAction() {
		$settings = $this->getRequest()->getPost('settings');
		$useDefault = $this->getRequest()->getPost('use_default');
		if (!is_array($settings) && !is_array($useDefault)) {
			$this->_redirect('*/*');
			return;
		}
		$storeId = $this->getRequest()->getParam('store');
		if ($storeId) {
			$websiteId = Mage::app()->getStore($storeId)->getWebsiteId();
		} else {
			$websiteId = 0;
		}

		try{
			/** @var $model Itoris_AjaxMiniCart_Model_Settings */
			$model = Mage::getModel('itoris_ajaxminicart/settings');
			if (is_array($useDefault)) {
				foreach ($useDefault as $code) {
					if (isset($settings[$code])) {
						unset($settings[$code]);
					}
				}
			}
			$model->save($settings, $websiteId, $storeId);
			$this->_getSession()->addSuccess($this->__('Settings have been saved'));
		} catch (Exception $e) {
			$this->_getSession()->addError($e->getMessage());
			$this->_getSession()->addError($this->__('Settings have not been saved'));
		}

		$this->_redirectReferer($this->_getSession()->getBeforeUrl());
	}

	protected function _isAllowed() {
		return Mage::getSingleton('admin/session')->isAllowed('admin/system/itoris_extensions/ajaxminicart');
	}
}
?>