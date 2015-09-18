<?php
/*
 * Developer: Rene Voorberg
 * Team site: http://cmsideas.net/
 * Support: http://support.cmsideas.net/
 * 
 *
*/


class Varien_Data_Form_Element_Labelposition extends Varien_Data_Form_Element_Abstract
{
    protected $_positions = array('TL', 'TC', 'TR', 'ML', 'MC', 'MR', 'BL', 'BC', 'BR');

    public function __construct($attributes=array())
    {
        parent::__construct($attributes);
        $this->setType('text');
        $this->setExtType('textfield');
    }

    public function getElementHtml()
    {
        $html = '<input type="hidden" id="'.$this->getHtmlId().'" name="'.$this->getName().'" value="'.$this->getValue().'" />';
        $html .= '<div class="labelposition">';
        foreach ($this->_positions as $position) {
            $html .= '<div id="'.$this->getHtmlId().$position.'" class="labelposition-item '.$this->getHtmlId().'labelposition-item" data-position="'.$position.'"></div>';
        }
        $html .= '</div>';

        $html .= $this->getAfterElementHtml();
        return $html;
    }

    public function getAfterElementHtml()
    {
        $html = '<script type="text/javascript">';
        foreach ($this->_positions as $position) {
            $html .= 'Event.observe($("'.$this->getHtmlId().$position.'"), "click", onClick'.$this->getHtmlId().');';
        }
        $html .= '
            function onClick'.$this->getHtmlId().'(e) {
                $$(".'.$this->getHtmlId().'labelposition-item").each(function(i) { i.removeClassName("active") });
                $(e.currentTarget).toggleClassName("active");
                $("'.$this->getHtmlId().'").value = $(e.currentTarget).readAttribute("data-position");
            }';
        if ($this->getValue()) {
            $html .= '$("'.$this->getHtmlId().$this->getValue().'").toggleClassName("active");';
        }
        $html .= '
            </script>
        ';

        return $html.parent::getAfterElementHtml();
    }

}