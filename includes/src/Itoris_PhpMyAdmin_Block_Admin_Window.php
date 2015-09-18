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
 * @package    ITORIS_PHPMYADMIN
 * @copyright  Copyright (c) 2013 ITORIS INC. (http://www.itoris.com)
 * @license    http://www.itoris.com/magento-extensions-license.html  Commercial License
 */


class Itoris_PhpMyAdmin_Block_Admin_Window extends Mage_Adminhtml_Block_Template {


	protected function _toHtml() {
		return '<div id="itoris_phpmyadmin_container" style="position:relative; height=800px;"><iframe class="itoris_phpmyadmin_iframe" height="800px" width="100%" src="' . Mage::getBaseUrl('web') . 'iphpmyadmin"></iframe></div>';
	}


}
?>