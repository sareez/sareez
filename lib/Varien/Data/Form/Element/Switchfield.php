<?php
/*
 * Developer: Rene Voorberg
 * Team site: http://cmsideas.net/
 * Support: http://support.cmsideas.net/
 * 
 *
*/


class Varien_Data_Form_Element_Switchfield extends Varien_Data_Form_Element_Abstract
{
    public function getElementHtml()
    {
        $this->addClass('select');

        $html = '<select
            id="'.$this->getHtmlId().'" name="'.$this->getName().'" '.$this->serialize($this->getHtmlAttributes()).'>'."\n";

        $value = $this->getValue();
        if (!is_array($value)) {
            $value = array($value);
        }

        if ($values = $this->getValues()) {
            foreach ($values as $key => $option) {
                $html .= $this->_optionToHtml(array('value' => $key, 'label' => $option), $value);
            }
        }

        $html .= '</select>'."\n";
        $html .= $this->getAfterElementHtml();
        return $html;
    }

    public function getAfterElementHtml()
    {
        $html = '<script type="text/javascript">
            Event.observe($("'.$this->getHtmlId().'"), "change", onChange'.$this->getHtmlId().');
            function onChange'.$this->getHtmlId().'(e) {
                var currentValue = $("'.$this->getHtmlId().'").value;
                var values = [];
                $$("#'.$this->getHtmlId().' option").each(function(element) {
                    values.push(element.value);
                });
                values.each(function(item) {
                    var id = "'.$this->getHtmlId().'_" + item;
                    if ($(id)) {
                        $(id).up(1).hide();
                    }
                });

                var id = "'.$this->getHtmlId().'_" + currentValue;
                if ($(id)) {
                    $(id).up(1).show();
                }
            }
            onChange'.$this->getHtmlId().'();
            </script>
        ';


        return $html.parent::getAfterElementHtml();
    }


    protected function _optionToHtml($option, $selected)
    {
        $html = '<option value="'.$this->_escape($option['value']).'"';
        if (in_array($option['value'], $selected)) {
            $html.= ' selected="selected"';
        }
        $html.= '>'.$this->_escape($option['label']). '</option>'."\n";

        return $html;
    }


    public function getHtmlAttributes()
    {
        return array('title', 'class', 'style', 'onclick', 'onchange', 'disabled', 'readonly', 'tabindex');
    }
}