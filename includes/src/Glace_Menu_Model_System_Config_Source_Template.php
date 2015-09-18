<?php
/*
 * Developer: Rene Voorberg
 * Team site: http://cmsideas.net/
 * Support: http://support.cmsideas.net/
 * 
 *
*/




class Glace_Menu_Model_System_Config_Source_Template
{
    public function toOptionArray()
    {
        return array(
            //array('value' => 'default', 'label' => Mage::helper('menu')->__('Default')),
            //array('value' => 'clear', 'label' => Mage::helper('menu')->__('Clear')),
            array('value' => 'style01', 'label' => Mage::helper('menu')->__('Style 01')),
        );
    }
}
