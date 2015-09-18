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

 

 

class Itoris_AjaxMiniCart_Helper_Data extends Mage_Core_Helper_Abstract {

	protected $alias = 'ajax_minicart';
	protected $settings = array();

	public function isAdminRegistered() {
		try {
			return Itoris_Installer_Client::isAdminRegistered($this->getAlias());
		} catch(Exception $e) {
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			return false;
		}
	}

	public function isRegisteredAutonomous($website = null) {
		return Itoris_Installer_Client::isRegisteredAutonomous($this->getAlias(), $website);
	}

	public function registerCurrentStoreHost($sn) {
		return Itoris_Installer_Client::registerCurrentStoreHost($this->getAlias(), $sn);
	}

	public function isRegistered($website) {
		return Itoris_Installer_Client::isRegistered($this->getAlias(), $website);
	}

	public function getAlias() {
		return $this->alias;
	}

	/**
	 * @param bool $admin
	 * @return Itoris_DynamicProductOptions_Model_Settings
	 */
	public function getSettings($admin = false) {
		if ($admin) {
			$storeId = Mage::app()->getRequest()->getParam('store');
			$websiteId = $storeId ? Mage::app()->getStore($storeId)->getWebsiteId() : 0;
		} else {
			$storeId = Mage::app()->getStore()->getId();
			$websiteId = Mage::app()->getWebsite()->getId();
		}
		$settingsKey = $websiteId . '_' . $storeId;
		if (!isset($this->settings[$settingsKey])) {
			$this->settings[$settingsKey] = Mage::getModel('itoris_ajaxminicart/settings')->load($websiteId, $storeId);
		}
		return $this->settings[$settingsKey];
	}

	public function isEnabledOnFrontend() {
		return $this->isRegisteredAutonomous() && $this->getSettings()->getEnabled();
	}

	public function isEnabledGroupedConfiguration() {
		return $this->isModuleEnabled('Itoris_GroupedProductConfiguration')
			&& Mage::helper('itoris_groupedproductconfiguration')->isRegisteredFrontend();
	}

	public function isEnabledDynamicProductOptions() {
		return $this->isModuleEnabled('Itoris_DynamicProductOptions')
			&& Mage::helper('itoris_dynamicproductoptions')->isEnabledOnFrontend();
	}

}
 
?>