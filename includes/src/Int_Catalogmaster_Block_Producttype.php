<?php
class Int_Catalogmaster_Block_Producttype extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
    	if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled() && ($block = $this->getLayout()->getBlock('head'))) {
		$block->setCanLoadTinyMce(true);
		}
		return parent::_prepareLayout();
    }
    
     public function getProducttype()     
     { 
        if (!$this->hasData('producttype')) {
            $this->setData('producttype', Mage::registry('producttype'));
        }
        return $this->getData('producttype');
        
    }
}