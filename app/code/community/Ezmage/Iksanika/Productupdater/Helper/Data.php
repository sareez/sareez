<?php

/**
 * Iksanika llc.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.iksanika.com/products/IKS-LICENSE.txt
 *
 * @category   Iksanika
 * @package    Iksanika_Productupdater
 * @copyright  Copyright (c) 2013 Iksanika llc. (http://www.iksanika.com)
 * @license    http://www.iksanika.com/products/IKS-LICENSE.txt
 */

class Iksanika_Productupdater_Helper_Data extends Mage_Core_Helper_Abstract 
{

    public function getImageUrl($image_file)
    {
        $url = false;
        $url = Mage::getBaseUrl('media').'catalog/product'.$image_file;
        return $url;
    }
    
    public function getFileExists($image_file)
    {
        $file_exists = false;
        $file_exists = file_exists('media/catalog/product'. $image_file);
        return $file_exists;
    }
    
}
?>