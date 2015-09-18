<?php

class Emjainteractive_Advancedoptions_Block_Catalog_Product_View_Options_Type_Date
    extends Emjainteractive_Advancedoptions_Block_Catalog_Product_View_Options_Abstract
{

    /**
     * Fill date and time options with leading zeros or not
     *
     * @var boolean
     */
    protected $_fillLeadingZeros = true;

    protected function _prepareLayout()
    {
        if ($head = $this->getLayout()->getBlock('head')) {
            $head->setCanLoadCalendarJs(true);
        }
        return parent::_prepareLayout();
    }

    /**
     * Use JS calendar settings
     *
     * @return boolean
     */
    public function useCalendar()
    {
        return false;
        return Mage::getSingleton('catalog/product_option_type_date')->useCalendar();
    }

    /**
     * Date input
     *
     * @return string Formatted Html
     */
    public function getDateHtml()
    {
        if ($this->useCalendar()) {
            return $this->getCalendarDateHtml();
        } else {
            return $this->getDropDownsDateHtml();
        }
    }

    /**
     * JS Calendar html
     *
     * @return string Formatted Html
     */
    public function getCalendarDateHtml()
    {
        $require = $this->getOption()->getIsRequire() ? ' required-entry' : '';
        $require = '';
        $datetime = $this->getQuoteItemOptionValue($this->getOption());
        $calendar = $this->getLayout()
            ->createBlock('core/html_date')
            ->setId('options_'. $this->getQuoteItem()->getId() . '_' . $this->getOption()->getId().'_date')
            ->setName('cart[' . $this->getQuoteItem()->getId() . '][options]['.$this->getOption()->getId().'][date]')
            ->setClass('product-custom-option datetime-picker input-text' . $require)
            ->setImage($this->getSkinUrl('images/calendar.gif'))
            //->setExtraParams('onchange="opConfig.reloadPrice()"')
            ->setFormat(Mage::app()->getLocale()->getDateStrFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT))
            ->setValue($datetime[0]);

        return $calendar->getHtml();
    }

    /**
     * Date (dd/mm/yyyy) html drop-downs
     *
     * @return string Formatted Html
     */
    public function getDropDownsDateHtml()
    {
        $_fieldsSeparator = '&nbsp;';
        $_fieldsOrder = Mage::getSingleton('catalog/product_option_type_date')->getConfigData('date_fields_order');
        $_fieldsOrder = str_replace(',', $_fieldsSeparator, $_fieldsOrder);

        $monthsHtml = $this->_getSelectFromToHtml('month', 1, 12);
        $daysHtml = $this->_getSelectFromToHtml('day', 1, 31);

        $_yearStart = Mage::getSingleton('catalog/product_option_type_date')->getYearStart();
        $_yearEnd = Mage::getSingleton('catalog/product_option_type_date')->getYearEnd();
        $yearsHtml = $this->_getSelectFromToHtml('year', $_yearStart, $_yearEnd);

        $_translations = array(
            'd' => $daysHtml,
            'm' => $monthsHtml,
            'y' => $yearsHtml
        );
        return strtr($_fieldsOrder, $_translations);
    }

    /**
     * Time (hh:mm am/pm) html drop-downs
     *
     * @return string Formatted Html
     */
    public function getTimeHtml()
    {
        if (Mage::getSingleton('catalog/product_option_type_date')->is24hTimeFormat()) {
            $hourStart = 0;
            $hourEnd = 23;
            $dayPartHtml = '';
        } else {
            $hourStart = 1;
            $hourEnd = 12;
            $dayPartHtml = $this->_getHtmlSelect('day_part')
                ->setOptions(array(
                    'am' => Mage::helper('catalog')->__('AM'),
                    'pm' => Mage::helper('catalog')->__('PM')
                ))
                ->getHtml();
        }
        $hoursHtml = $this->_getSelectFromToHtml('hour', $hourStart, $hourEnd);
        $minutesHtml = $this->_getSelectFromToHtml('minute', 0, 59);

        return $hoursHtml . '&nbsp;<b>:</b>&nbsp;' . $minutesHtml . '&nbsp;' . $dayPartHtml;
    }

    /**
     * Return drop-down html with range of values
     *
     * @param string $name Id/name of html select element
     * @param int $from  Start position
     * @param int $to    End position
     * @param int $value Value selected
     * @return string Formatted Html
     */
    protected function _getSelectFromToHtml($name, $from, $to, $value = null)
    {
        $options = array(
            array('value' => '', 'label' => '-')
        );
        for ($i = $from; $i <= $to; $i++) {
            $options[] = array('value' => $i, 'label' => $this->_getValueWithLeadingZeros($i));
        }
        return $this->_getHtmlSelect($name, $value)
            ->setOptions($options)
            ->getHtml();
    }

    /**
     * HTML select element
     *
     * @param string $name Id/name of html select element
     * @return Mage_Core_Block_Html_Select
     */
    protected function _getHtmlSelect($name, $value = null)
    {
        $datetime = $this->getQuoteItemOptionValue($this->getOption());
        if (!is_null($datetime)) {
            $valueMap = $this->getValueMap();
            $value = $datetime->get($valueMap[$name]);
            if($name == 'day_part') {
                $value = strtolower($value);
            }
        } else {
            $value = null;
        }

        $require = $this->getOption()->getIsRequire() ? ' required-entry' : '';
        $require = '';
        $select = $this->getLayout()->createBlock('core/html_select')
            ->setId('options_' . $this->getQuoteItem()->getId() . '_' . $this->getOption()->getId() . '_' . $name)
            ->setClass('product-custom-option datetime-picker' . $require)
            ->setExtraParams('style="width:auto;"')
            ->setName('cart[' . $this->getQuoteItem()->getId() . '][options][' . $this->getOption()->getId() . '][' . $name . ']');
        if (!is_null($value)) {
            $select->setValue($value);
        }
        return $select;
    }

    /**
     * Add Leading Zeros to number less than 10
     *
     * @param int
     * @return string
     */
    protected function _getValueWithLeadingZeros($value)
    {
        if (!$this->_fillLeadingZeros) {
            return $value;
        }
        return $value < 10 ? '0'.$value : $value;
    }

    /**
     * @param $option
     */
    public function getQuoteItemOptionValue($option)
    {
        $quoteItemOption = $this->getQuoteItem()->getOptionByCode('option_' . $option->getId());
        if ($quoteItemOption) {
            $optionValue = $quoteItemOption->getValue();

            if($this->useCalendar()) {
                return explode(',', $optionValue);
            }

            $timestamp = strtotime($optionValue);
            if ($timestamp !== false && $timestamp != -1) {
                return new Zend_Date($timestamp);
            }
        }
        return null;
    }

    /**
     * @return array
     */
    public function getValueMap(){
        $valueMap = array(
            'day' => Zend_Date::DAY,
            'month' => Zend_Date::MONTH,
            'year' => Zend_Date::YEAR,
            'hour' => Zend_Date::HOUR_AM,
            'minute'=> Zend_Date::MINUTE,
            'day_part' => Zend_Date::MERIDIEM
        );
        return $valueMap;
    }
}
