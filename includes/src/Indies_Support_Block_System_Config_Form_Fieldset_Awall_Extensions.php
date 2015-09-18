<?php
/**
* 
* Do not edit or add to this file if you wish to upgrade the module to newer
* versions in the future. If you wish to customize the module for your 
* needs please contact us to https://www.milople.com/magento-extensions/contact-us.html 
* 
* @category    Ecommerce
* @package     Indies_Support
* @copyright   Copyright (c) 2015 Milople Technologies Pvt. Ltd. All Rights Reserved.
* @url	       http://www.milople.com/
*
* Milople was known as Indies Services earlier.
*
*/

class Indies_Support_Block_System_Config_Form_Fieldset_Awall_Extensions extends Mage_Adminhtml_Block_System_Config_Form_Fieldset
{
	protected $_dummyElement;
    protected $_fieldRenderer;
    protected $_values;

    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $html = $this->_getHeaderHtml($element);
        $modules = array_keys((array)Mage::getConfig()->getNode('modules')->children());
        sort($modules);
		
        foreach ($modules as $moduleName) {
			$moduleConfig = Mage::getConfig()->getNode('modules/' . $moduleName);
            list($namespace, $extension) = explode('_', $moduleName, 2);
            if ($namespace != 'Indies') {
                continue;
            }
			if($moduleName == 'Indies_Support')
			{
                continue;
            }
			if(!$moduleConfig->name)
			{
				continue;
			}
            $html .= $this->_getFieldHtml($element, $moduleName);
        }
        $html .= $this->_getFooterHtml($element);
        return $html;
    }

    protected function _getFieldRenderer()
    {
        if (empty($this->_fieldRenderer)) {
            $this->_fieldRenderer = Mage::getBlockSingleton('adminhtml/system_config_form_field');
        }
        return $this->_fieldRenderer;
    }

    protected function _getFooterHtml($element)
    {
        $html = parent::_getFooterHtml($element);
        //$html = '<h4>' . $this->__('Installed Indies Extensions') . '</h4>' . $html;
        return $html;
    }

    protected function _getFieldHtml($fieldset, $moduleName)
    {
        $moduleConfig = Mage::getConfig()->getNode('modules/' . $moduleName);
        $field = $fieldset->addField($moduleName, 'label',
            array(
                'name' => $moduleName,
                'label' => "<a href='$moduleConfig->url' target='_blank' rel='nofollow'>" . $moduleConfig->name . "</a>",
                'value' => $moduleConfig->version,
            ))->setRenderer($this->_getFieldRenderer());
        return $field->toHtml();
    }
}

