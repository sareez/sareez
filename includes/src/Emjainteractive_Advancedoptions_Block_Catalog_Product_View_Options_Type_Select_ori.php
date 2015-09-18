<?php

class Emjainteractive_Advancedoptions_Block_Catalog_Product_View_Options_Type_Select
    extends Emjainteractive_Advancedoptions_Block_Catalog_Product_View_Options_Abstract
{

    public function getValuesHtml()
    {
        $_option = $this->getOption();
        $_customOptions = $this->getProduct()->getCustomOptions();

        $item = $this->getQuoteItem();

        if ($_option->getType() == Mage_Catalog_Model_Product_Option::OPTION_TYPE_DROP_DOWN
            || $_option->getType() == Mage_Catalog_Model_Product_Option::OPTION_TYPE_MULTIPLE) {
            $require = ($_option->getIsRequire()) ? ' required-entry' : '';
            $extraParams = '';


            $select = $this->getLayout()->createBlock('core/html_select')
                ->setData(array(
                    'id' => 'select_'.$_option->getId(),
                    'class' => $require.' product-custom-option',
                    'value' => $this->getQuoteItemOptinValue($_option->getid())
                ));
            if ($_option->getType() == Mage_Catalog_Model_Product_Option::OPTION_TYPE_DROP_DOWN) {
                $select->setName('cart[' . $item->getId() . '][options]['.$_option->getid().']')
                    ->addOption('', $this->__('-- Please Select --'));
            } else {
                $select->setName('cart[' . $item->getId() . '][options]['.$_option->getid().'][]');
                $select->setClass('multiselect'.$require.' product-custom-option');
            }
            foreach ($_option->getValues() as $_value) {
                $priceStr = $this->_formatPrice(array(
                    'is_percent' => ($_value->getPriceType() == 'percent') ? true : false,
                    'pricing_value' => $_value->getPrice(true)
                ), false);
                $select->addOption(
                    $_value->getOptionTypeId(),
                    $_value->getTitle() . ' ' . $priceStr . ''
                );
            }
            if ($_option->getType() == Mage_Catalog_Model_Product_Option::OPTION_TYPE_MULTIPLE) {
                $extraParams = ' multiple="multiple"';
                $select->setValue(explode(',', $this->getQuoteItemOptinValue($_option->getid())));
            }
            $select->setExtraParams('onchange="opConfig.reloadPrice()"'.$extraParams);

            return $select->getHtml();
        }

        if ($_option->getType() == Mage_Catalog_Model_Product_Option::OPTION_TYPE_RADIO
            || $_option->getType() == Mage_Catalog_Model_Product_Option::OPTION_TYPE_CHECKBOX
            ) {
            $selectHtml = '<ul id="options-'.$_option->getId().'-list" class="options-list">';
            $require = ($_option->getIsRequire()) ? ' validate-one-required-by-name' : '';
            $arraySign = '';
            switch ($_option->getType()) {
                case Mage_Catalog_Model_Product_Option::OPTION_TYPE_RADIO:
                    $type = 'radio';
                    $class = 'radio';
                    if (!$_option->getIsRequire()) {
                        $selectHtml .= '<li><input type="radio" id="options_'.$_option->getId().'" class="'.$class.' product-custom-option" name="cart[' . $item->getId() . '][options]['.$_option->getId().']" onclick="opConfig.reloadPrice()" value="" checked="checked" /><span class="label"><label for="options_'.$_option->getId().'">' . $this->__('None') . '</label></span></li>';
                    }
                    break;
                case Mage_Catalog_Model_Product_Option::OPTION_TYPE_CHECKBOX:
                    $type = 'checkbox';
                    $class = 'checkbox';
                    $arraySign = '[]';
                    break;
            }
            $count = 1;
            foreach ($_option->getValues() as $_value) {
                $count++;
                $priceStr = $this->_formatPrice(array(
                    'is_percent' => ($_value->getPriceType() == 'percent') ? true : false,
                    'pricing_value' => $_value->getPrice(true)
                ));

                $checked = '';
                foreach(explode(',',$this->getQuoteItemOptinValue($_option->getId())) as $quoteItemOptionValue) {
                    if ($quoteItemOptionValue == $_value->getOptionTypeId()) {
                        $checked = 'checked=""';
                    }
                }

                $selectHtml .= '<li>' .
                               '<input type="'.$type.'" class="'.$class.' '.$require.' product-custom-option" onclick="opConfig.reloadPrice()" name="cart[' . $item->getId() . '][options]['.$_option->getId().']'.$arraySign.'" id="options_'.$_option->getId().'_'.$count.'" value="'.$_value->getOptionTypeId().'" ' . $checked . '/>' .
                               '<span class="label"><label for="options_'.$_option->getId().'_'.$count.'">'.$_value->getTitle().' '.$priceStr.'</label></span>';
                if ($_option->getIsRequire()) {
                    $selectHtml .= '<script type="text/javascript">' .
                                    '$(\'options_'.$_option->getId().'_'.$count.'\').advaiceContainer = \'options-'.$_option->getId().'-container\';' .
                                    '$(\'options_'.$_option->getId().'_'.$count.'\').callbackFunction = \'validateOptionsCallback\';' .
                                   '</script>';
                }
                $selectHtml .= '</li>';
            }
            $selectHtml .= '</ul>';
            return $selectHtml;
        }
    }

    public function getQuoteItemOptinValue($id)
    {
        $optionCode = 'option_' . $id;
        $option = $this->getQuoteItem()->getOptionByCode($optionCode);
        if ($option) {
            return $option->getValue();
        }
        return '';
    }

}
