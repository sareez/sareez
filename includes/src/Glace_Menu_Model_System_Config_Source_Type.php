<?php
/*
 * Developer: Rene Voorberg
 * Team site: http://cmsideas.net/
 * Support: http://support.cmsideas.net/
 * 
 *
*/


class Glace_Menu_Model_System_Config_Source_Type
{
    public function toOptionArray()
    {
        $result = array();
        $result[] = array('value' => 0, 'label' => '');

        $types = Mage::getSingleton('menu/item_type')->getOptionArray();
        foreach ($types as $code => $label) {
            $result[] = array(
                'value' => $code,
                'label' => $label,
            );
        }


        return $result;
    }
}
