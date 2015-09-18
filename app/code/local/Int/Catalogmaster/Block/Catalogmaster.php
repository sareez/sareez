<?php
class Int_Catalogmaster_Block_Catalogmaster extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
    	if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled() && ($block = $this->getLayout()->getBlock('head'))) {
		$block->setCanLoadTinyMce(true);
		}
		return parent::_prepareLayout();
    }
    
     public function getCatalogmaster()     
     { 
        if (!$this->hasData('catalogmaster')) {
            $this->setData('catalogmaster', Mage::registry('catalogmaster'));
        }
        return $this->getData('catalogmaster');
        
    }
}