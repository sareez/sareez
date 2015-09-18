<?php
class Sn_Sorder_Block_Sorder extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getSorder()     
     { 
        if (!$this->hasData('sorder')) {
            $this->setData('sorder', Mage::registry('sorder'));
        }
        return $this->getData('sorder');
        
    }
}