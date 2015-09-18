<?php
/*
 * Developer: Rene Voorberg
 * Team site: http://cmsideas.net/
 * Support: http://support.cmsideas.net/
 * 
 *
*/


abstract class Glace_Menu_Model_Item_Type_Abstract extends Varien_Object
{
    protected $_item;
    protected $_typeId;
    protected $_styleAttributes = array();
    protected $_classAttributes = array(
        'class',
    );

    public function setItem($item)
    {
        $this->_item = $item;
        return $this;
    }

    public function setTypeId($typeId)
    {
        $this->_typeId = $typeId;
        return $this;
    }

    public function getItem($item = null)
    {
        if (is_object($item)) {
            return $item;
        }
        return $this->_item;
    }

    public function beforeSave($item)
    {
        return $this;
    }

    public function getStyle()
    {
        $styles = array();

        foreach ($this->_styleAttributes as $attr => $name) {
            $value = $this->getAttr($attr);
            if (!$value) {
                $value = $this->getItem()->getAttr($attr);
            }

            if (trim($value) == '' || $value == 'default') {
                continue;
            }

            if (in_array($attr, array('color', 'background'))) {
                $value = '#'.$value;
            }

            $styles[] = $name.':'.$value;
        }

        $styles = implode(';', $styles);
        if ($styles) {
            $styles .= ';';
        }

        return $styles;
    }

    public function getClass()
    {
        $classes = array();

        foreach ($this->_classAttributes as $attr) {
            $value = $this->getItem()->getAttr($attr);

            if (trim($value) == '') {
                continue;
            }

            $classes[] = $value;
        }

        return implode(' ', $classes);
    }

    public function isActive()
    {
        return false;
    }
}