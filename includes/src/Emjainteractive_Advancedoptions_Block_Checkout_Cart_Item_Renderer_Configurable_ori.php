<?php

class Emjainteractive_Advancedoptions_Block_Checkout_Cart_Item_Renderer_Configurable extends
        Mage_Checkout_Block_Cart_Item_Renderer_Configurable
{
    public function getProductOptions()
    {
        $options = array();
        if ($optionIds = $this->getItem()->getOptionByCode('option_ids')) {
            $options = array();
            foreach (explode(',', $optionIds->getValue()) as $optionId) {
                if ($option = $this->getProduct()->getOptionById($optionId)) {
                    $quoteItemOption = $this->getItem()->getOptionByCode('option_' . $option->getId());

                    $group = $option->groupFactory($option->getType())
                        ->setOption($option)
                        ->setQuoteItemOption($quoteItemOption);

                    $options[$option->getSortOrder()] = array(
                        'label' => $option->getTitle(),
                        'value' => $group->getFormattedOptionValue($quoteItemOption->getValue()),
                        'print_value' => $group->getPrintableOptionValue($quoteItemOption->getValue()),
                        'option_id' => $option->getId(),
                        'option_type' => $option->getType(),
                        'custom_view' => $group->isCustomizedView()
                    );
                }
            }
        }
        if ($addOptions = $this->getItem()->getOptionByCode('additional_options')) {
            $options = array_merge($options, unserialize($addOptions->getValue()));
        }
        ksort($options);
        return $options;
    }
}