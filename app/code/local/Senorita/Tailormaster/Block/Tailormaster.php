<?php
class Senorita_Tailormaster_Block_Tailormaster extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getTailormaster()     
     { 
        if (!$this->hasData('tailormaster')) {
            $this->setData('tailormaster', Mage::registry('tailormaster'));
        }
        return $this->getData('tailormaster');
        
    }
}