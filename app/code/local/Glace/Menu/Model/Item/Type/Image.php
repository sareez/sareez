<?php
/*
 * Developer: Rene Voorberg
 * Team site: http://cmsideas.net/
 * Support: http://support.cmsideas.net/
 * 
 *
*/


class Glace_Menu_Model_Item_Type_Image extends Glace_Menu_Model_Item_Type_Link
{
    protected $_styleAttributes = array(
        'top'    => 'top',
        'bottom' => 'bottom',
        'left'   => 'left',
        'right'  => 'right',
    );

    public function beforeSave($object)
    {
        $this->_saveImages($object);

        return $this;
    }

    public function getImageUrl()
    {
        $image = $this->getItem()->getAttr('image');
        //$url = Mage::getBaseUrl('media').'menu'.DS.$image;
        $url = Mage::getBaseUrl('media').'menu/'.$image;
        
        return $url;
    }

    public function getStyle()
    {
        $styles = parent::getStyle();
        if ($styles) {
            $styles .= 'position:absolute;';
        }

        return $styles;
    }

    public function _saveImages($object)
    {
        //$path = Mage::getBaseDir('media').DS.'menu'.DS;
    	$path = Mage::getBaseDir('media').'/menu/';
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        if (is_array($object->getAttr('image'))) {
            $image = $object->getAttr('image');
            $image['value'] = substr($image['value'], strlen('menu/'));
            $object->setAttr($image['value'], 'image');
        }
        // pr($object);die();
        try {
            $uploader = new Mage_Core_Model_File_Uploader('attr[image]');
            $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
            $uploader->setAllowRenameFiles(true);

            $result = $uploader->save($path);
            $object->setAttr($result['file'], 'image');
        } catch (Exception $e) {
            Mage::logException($e);
        }

        return $this;
    }
}