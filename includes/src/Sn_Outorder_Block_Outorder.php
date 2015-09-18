<?php
class Sn_Outorder_Block_Outorder extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getOutorder()     
     { 
        if (!$this->hasData('outorder')) {
            $this->setData('outorder', Mage::registry('outorder'));
        }
        return $this->getData('outorder');
        
    }
}