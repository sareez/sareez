<?php
/*
 * Developer: Rene Voorberg
 * Team site: http://cmsideas.net/
 * Support: http://support.cmsideas.net/
 * 
 *
*/


class Varien_Data_Form_Element_Fontweight extends Varien_Data_Form_Element_Select
{
    public function __construct($attributes=array())
    {
        parent::__construct($attributes);
        $values = array();
        $values['default'] = 'Default';
        $values['normal']  = 'Normal';
        $values['lighter'] = 'Lighter';
        $values['bold']    = 'Bold';
        $values['bolder']  = 'Bolder';
        $this->setValues($values);
    }

    public function getElementHtml()
    {
        $this->addClass('select');
        $html = '<select style="width:105px" id="'.$this->getHtmlId().'" name="'.$this->getName().'" '.$this->serialize($this->getHtmlAttributes()).'>'."\n";

        $value = $this->getValue();
        if (!is_array($value)) {
            $value = array($value);
        }

        if ($values = $this->getValues()) {
            foreach ($values as $key => $option) {
                if (!is_array($option)) {
                    $html.= $this->_optionToHtml(array(
                        'value' => $key,
                        'label' => $option),
                        $value
                    );
                }
                elseif (is_array($option['value'])) {
                    $html.='<optgroup label="'.$option['label'].'">'."\n";
                    foreach ($option['value'] as $groupItem) {
                        $html.= $this->_optionToHtml($groupItem, $value);
                    }
                    $html.='</optgroup>'."\n";
                }
                else {
                    $html.= $this->_optionToHtml($option, $value);
                }
            }
        }

        $html.= '</select>'."\n";
        $html.= $this->getAfterElementHtml();
        return $html;
    }

}