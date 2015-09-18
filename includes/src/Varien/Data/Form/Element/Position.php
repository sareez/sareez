<?php
/*
 * Developer: Rene Voorberg
 * Team site: http://cmsideas.net/
 * Support: http://support.cmsideas.net/
 * 
 *
*/


class Varien_Data_Form_Element_Position extends Varien_Data_Form_Element_Abstract
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
        $html = '<table><tr><td></td><td>';
        $html .= '<input placeholder="top" id="'.$this->getHtmlId().'_top" name="'.$this->getName('top')
             .'" value="'.$this->getTop().'" '.$this->serialize($this->getHtmlAttributes()).' style="width: 50px"/>'."\n";
        $html .= '</td><td></td></tr>';
        $html .= '<tr><td>';
        $html .= '<input placeholder="left" id="'.$this->getHtmlId().'_left" name="'.$this->getName('left')
             .'" value="'.$this->getLeft().'" '.$this->serialize($this->getHtmlAttributes()).' style="width: 50px"/>'."\n";

        $html .= '</td><td></td><td>';
        $html .= '<input placeholder="right" id="'.$this->getHtmlId().'_right" name="'.$this->getName('right')
             .'" value="'.$this->getRight().'" '.$this->serialize($this->getHtmlAttributes()).' style="width: 50px"/>'."\n";
        $html .= '</td></tr>';
        $html .= '<tr><td></td><td>';
        $html .= '<input placeholder="bottom" id="'.$this->getHtmlId().'_bottom" name="'.$this->getName('bottom')
             .'" value="'.$this->getBottom().'" '.$this->serialize($this->getHtmlAttributes()).' style="width: 50px"/>'."\n";
        $html .= '</td><td></td></tr></table>';
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