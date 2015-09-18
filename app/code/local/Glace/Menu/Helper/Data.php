<?php
/*
 * Developer: Rene Voorberg
 * Team site: http://cmsideas.net/
 * Support: http://support.cmsideas.net/
 * 
 *
*/



class Glace_Menu_Helper_Data extends Mage_Core_Helper_Data
{
    public function isTabAllowed($tab)
    {
        $ignore = explode(',', Mage::getStoreConfig('menu/tabs/custom_tab'));

        if (in_array($tab, $ignore)) {
            return false;
        }

        return true;
    }
}