<?php
class Senorita_Autoinvoice_Block_Autoinvoice extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getAutoinvoice()     
     { 
        if (!$this->hasData('autoinvoice')) {
            $this->setData('autoinvoice', Mage::registry('autoinvoice'));
        }
        return $this->getData('autoinvoice');
        
    }
}