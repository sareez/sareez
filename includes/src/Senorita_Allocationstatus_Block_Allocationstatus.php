<?php
class Senorita_Allocationstatus_Block_Allocationstatus extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getAllocationstatus()     
     { 
        if (!$this->hasData('allocationstatus')) {
            $this->setData('allocationstatus', Mage::registry('allocationstatus'));
        }
        return $this->getData('allocationstatus');
        
    }
}