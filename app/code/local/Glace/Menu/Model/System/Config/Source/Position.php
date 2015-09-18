<?php
/*
 * Developer: Rene Voorberg
 * Team site: http://cmsideas.net/
 * Support: http://support.cmsideas.net/
 * 
 *
*/




class Glace_Menu_Model_System_Config_Source_Position
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'none', 'label' => Mage::helper('menu')->__('Not Display')),
            array('value' => 'top', 'label' => Mage::helper('menu')->__('Top')),
            array('value' => 'left', 'label' => Mage::helper('menu')->__('Left')),
            array('value' => 'right', 'label' => Mage::helper('menu')->__('Right')),
            array('value' => 'footer', 'label' => Mage::helper('menu')->__('Footer'))
            //array('value' => 'top.links', 'label' => Mage::helper('menu')->__('top.links'))
        );
    }
}
