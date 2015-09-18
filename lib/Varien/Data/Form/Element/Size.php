<?php
/*
 * Developer: Rene Voorberg
 * Team site: http://cmsideas.net/
 * Support: http://support.cmsideas.net/
 * 
 *
*/


class Varien_Data_Form_Element_Size extends Varien_Data_Form_Element_Abstract
{
    public function __construct($attributes=array())
    {
        parent::__construct($attributes);
        $this->setType('text');
        $this->setExtType('textfield');
    }

    public function getElementHtml()
    {
        $this->addClass('input-text');
        $html = '<input placeholder="width" id="'.$this->getHtmlId().'_width" name="'.$this->getName('width')
             .'" value="'.$this->getWidth().'" '.$this->serialize($this->getHtmlAttributes()).' style="width: 45px"/>'."\n";
        $html .= '<input placeholder="height" id="'.$this->getHtmlId().'_height" name="'.$this->getName('height')
             .'" value="'.$this->getHeight().'" '.$this->serialize($this->getHtmlAttributes()).' style="width: 44px"/>'."\n";
        $html .= $this->getAfterElementHtml();
        return $html;
    }

    public function getName($type = false)
    {
        $name = parent::getName();
        $name = sprintf($name, $type);

        return $name;
    }
}