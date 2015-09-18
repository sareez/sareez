<?php
class Sareez_Mostviewed_Block_Mostviewed extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getMostviewed()     
     { 
        if (!$this->hasData('mostviewed')) {
            $this->setData('mostviewed', Mage::registry('mostviewed'));
        }
        return $this->getData('mostviewed');
        
    }
}