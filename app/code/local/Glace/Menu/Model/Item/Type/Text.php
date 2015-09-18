<?php
/*
 * Developer: Rene Voorberg
 * Team site: http://cmsideas.net/
 * Support: http://support.cmsideas.net/
 * 
 *
*/


class Glace_Menu_Model_Item_Type_Text extends Glace_Menu_Model_Item_Type_Abstract
{
    protected $_styleAttributes = array(
        'background' => 'background',
        'width'      => 'width',
        'height'     => 'height',
    );

    public function getText()
    {
        $text      = $this->getItem()->getAttr('text');
        $processor = Mage::helper('cms')->getBlockTemplateProcessor();
        $text      = $processor->filter($text);

        return $text;
    }
}