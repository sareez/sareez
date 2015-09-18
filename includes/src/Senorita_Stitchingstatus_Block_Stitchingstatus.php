<?php
class Senorita_Stitchingstatus_Block_Stitchingstatus extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getStitchingstatus()     
     { 
        if (!$this->hasData('stitchingstatus')) {
            $this->setData('stitchingstatus', Mage::registry('stitchingstatus'));
        }
        return $this->getData('stitchingstatus');
        
    }
}