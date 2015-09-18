<?php

class Emjainteractive_Advancedoptions_Helper_Checkout_Cart extends Mage_Checkout_Helper_Cart
{
    /**
     * @param Mage_Sales_Model_Quote_Item $item
     * @return string
     */
    public function getItemEditOptionsHtml(Mage_Sales_Model_Quote_Item $item)
    {
        $product = $item->getProduct();
        $optionsBlock = $this->getLayout()->createBlock('emjainteractive_advancedoptions/catalog_product_view_options','product.info.options.' . $item->getId())
            ->addOptionRenderer('file','emjainteractive_advancedoptions/catalog_product_view_options_type_text','emjainteractive/advancedoptions/catalog/product/view/options/type/text.phtml')
            ->addOptionRenderer('select','emjainteractive_advancedoptions/catalog_product_view_options_type_select','emjainteractive/advancedoptions/catalog/product/view/options/type/select.phtml')
            ->addOptionRenderer('date','emjainteractive_advancedoptions/catalog_product_view_options_type_date','emjainteractive/advancedoptions/catalog/product/view/options/type/date.phtml')
            ->addOptionRenderer('text','emjainteractive_advancedoptions/catalog_product_view_options_type_text','emjainteractive/advancedoptions/catalog/product/view/options/type/text.phtml')
            ->setTemplate('catalog/product/view/options.phtml')
            ->setProduct($product)
            ->setQuoteItem($item);

        $jsBlock = $this->getLayout()->createBlock('core/template','options_js' . $item->getId())
            ->setTemplate('catalog/product/view/options/js.phtml');

        return $jsBlock->toHtml() . $optionsBlock->toHtml();
    }

    /**
     * @param Mage_Catalog_Model_Product $product
     * @return boolean
     */
    public function productHasOptions(Mage_Catalog_Model_Product $product)
    {
        if (count($product->getOptions()) > 0) {
            return true;
        }
        return false;
    }

    /**
     * @return string
     */
    public function getEditButtonLabel()
    {
        return Mage::getStoreConfig('advancedoptions/checkout_cart/edit_button_label');
    }

    /**
     * @return string 
     */
    public function getAddButtonLabel()
    {  
        return Mage::getStoreConfig('advancedoptions/checkout_cart/add_button_label');
    }

    /**
     * @return string 
     */
    public function getRemoveButtonLabel()
    {  
        return Mage::getStoreConfig('advancedoptions/checkout_cart/remove_button_label');
    }

    /**
     * @return string 
     */
    public function getRemovedMessage()
    {  
        return Mage::getStoreConfig('advancedoptions/checkout_cart/removed_message');
    }

    /**
     * @return string
     */
    public function getEditedMessage()
    {
        return Mage::getStoreConfig('advancedoptions/checkout_cart/edited_message');
    }
}
