<?php
/*
 * Developer: Rene Voorberg
 * Team site: http://cmsideas.net/
 * Support: http://support.cmsideas.net/
 * 
 *
*/


class Varien_Data_Form_Element_Color extends Varien_Data_Form_Element_Abstract
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
        $html = '<input placeholder="color" id="'.$this->getHtmlId().'" name="'.$this->getName()
             .'" class="color" value="'.$this->getEscapedValue().'" '.$this->serialize($this->getHtmlAttributes()).' style="width: 100px"/>'."\n";
        $html .= '<script>jscolor.bind()</script>';
        $html .= $this->getAfterElementHtml();
        return $html;
    }
}