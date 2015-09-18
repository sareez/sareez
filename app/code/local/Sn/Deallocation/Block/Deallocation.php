<?php
class Sn_Deallocation_Block_Deallocation extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getDeallocation()     
     { 
        if (!$this->hasData('deallocation')) {
            $this->setData('deallocation', Mage::registry('deallocation'));
        }
        return $this->getData('deallocation');
        
    }
}