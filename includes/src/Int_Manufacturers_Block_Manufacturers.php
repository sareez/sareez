<?php
class Int_Manufacturers_Block_Manufacturers extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
    	if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled() && ($block = $this->getLayout()->getBlock('head'))) {
		$block->setCanLoadTinyMce(true);
		}
		return parent::_prepareLayout();
    }
    
     public function getManufacturers()     
     { 
        if (!$this->hasData('manufacturers')) {
            $this->setData('manufacturers', Mage::registry('manufacturers'));
        }
        return $this->getData('manufacturers');
        
    }
}