<?php
class Int_Magetooscommerce_Block_Magetooscommerce extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getMagetooscommerce()     
     { 
        if (!$this->hasData('magetooscommerce')) {
            $this->setData('magetooscommerce', Mage::registry('magetooscommerce'));
        }
        return $this->getData('magetooscommerce');
        
    }
}