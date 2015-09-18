<?php
class Sareez_Ordercsv_Block_Ordercsv extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getOrdercsv()     
     { 
        if (!$this->hasData('ordercsv')) {
            $this->setData('ordercsv', Mage::registry('ordercsv'));
        }
        return $this->getData('ordercsv');
        
    }
}