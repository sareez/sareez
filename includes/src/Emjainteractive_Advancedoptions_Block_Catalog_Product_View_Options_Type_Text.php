<?php

class Emjainteractive_Advancedoptions_Block_Catalog_Product_View_Options_Type_Text
    extends Emjainteractive_Advancedoptions_Block_Catalog_Product_View_Options_Abstract
{

    /**
     * @return string
     */
    public function getQuoteItemOptionValue($option)
    {
        $quoteItemOption = $this->getQuoteItem()->getOptionByCode('option_' . $option->getId());
        if ($quoteItemOption) {
            return $quoteItemOption->getValue();
        }
        return '';
    }

}
