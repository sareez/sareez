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

 

 

class Itoris_AjaxMiniCart_Block_Admin_Settings_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {

	protected function _prepareForm() {
		$form = new Varien_Data_Form(array(
			'action'        => $this->getUrl('*/*/save', array('_current' => true)),
			'use_container' => true,
			'id'            => 'edit_form',
			'method'        => 'post',
		));

		$configurationFieldset = $form->addFieldset('configuration_fieldset', array('legend' => $this->__('Configuration')));

		$configurationFieldset->addField('enabled', 'select', array(
			'label'  => $this->__('Enabled'),
			'title'  => $this->__('Enabled'),
			'name'   => 'settings[enabled]',
			'values' => $this->getFormHelper()->getYesNoOptionValues(),
		))->getRenderer()->setTemplate('itoris/ajaxminicart/settings/form/fieldset/element.phtml');

		$configurationFieldset->addField('enable_animation', 'select', array(
			'label'  => $this->__('Animation Effects'),
			'title'  => $this->__('Animation Effects'),
			'name'   => 'settings[enable_animation]',
			'values' => array(
				array(
					'label' => $this->__('Enabled'),
					'value' => 1,
				),
				array(
					'label' => $this->__('Disabled'),
					'value' => 0,
				),
			),
		));

		$form->setValues($this->getFormHelper()->prepareElementsValues($form));
		$this->setForm($form);

		return $this;
	}

	/**
	 * @return Itoris_AjaxMiniCart_Helper_Form
	 */
	protected function getFormHelper() {
		return Mage::helper('itoris_ajaxminicart/form');
	}
}

?>