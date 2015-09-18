<?php
/**
 * MageWorx
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MageWorx EULA that is bundled with
 * this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.mageworx.com/LICENSE-1.0.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the extension
 * to newer versions in the future. If you wish to customize the extension
 * for your needs please refer to http://www.mageworx.com/ for more information
 *
 * @category   MageWorx
 * @package    MageWorx_CustomOptions
 * @copyright  Copyright (c) 2013 MageWorx (http://www.mageworx.com/)
 * @license    http://www.mageworx.com/LICENSE-1.0.html
 */

/**
 * Advanced Product Options extension
 *
 * @category   MageWorx
 * @package    MageWorx_CustomOptions
 * @author     MageWorx Dev Team
 */
class MageWorx_CustomOptions_Model_Observer {

    // replace main product image in checkout/cart
    public function toHtmlBlockFrontBefore($observer) {
        $helper = Mage::helper('customoptions');
        if (!$helper->isEnabled() || !$helper->isImageModeEnabled()) return $this;        
        $block = $observer->getEvent()->getBlock();        
        if ($block instanceof Mage_Checkout_Block_Cart_Item_Renderer) {
            $product = $block->getProduct();
            if ($product) {
                if (is_null($product->getHasOptions())) $product->load($product->getId());
                if (($product->getTypeId()=='simple' || $product->getTypeId()=='virtual' || $product->getTypeId()=='downloadable') && $product->getHasOptions()) {
                    $post = $product->getCustomOption('info_buyRequest')->getValue();
                    if ($post) $post = unserialize ($post); else $post = array();
                    if (isset($post['options'])) $options = $post['options']; else $options = array();
                    if ($options) {
                        foreach ($options as $optionId => $value) {
                            $optionModel = $product->getOptionById($optionId);
                            if (!$optionModel) continue;
                            $optionModel->setProduct($optionModel);
                            // if replace image mode setting
                            if ($optionModel->getImageMode()==2) {
                                switch ($optionModel->getType()) {
                                    case 'drop_down':
                                    case 'radio':
                                    case 'checkbox':                        
                                    case 'multiple':
                                    case 'swatch':
                                    case 'multiswatch':
                                        if (is_array($value)) {
                                            $optionTypeIds = $value;
                                        } else {
                                            $optionTypeIds = explode(',', $value);
                                        }
                                        foreach ($optionTypeIds as $optionTypeId) {
                                            if (!$optionTypeId) continue;
                                            $images = $optionModel->getOptionValueImages($optionTypeId);
                                            if ($images) {
                                                foreach ($images as $index=>$image) {
                                                    // file
                                                    if ($image['source']==1 && (!$optionModel->getExcludeFirstImage() || ($optionModel->getExcludeFirstImage() && $index > 0))) {
                                                        // replace main image
                                                        $block->overrideProductThumbnail(Mage::getModel('customoptions/catalog_product_option_image')->init($image['image_file']));
                                                        return $this;
                                                    }
                                                }
                                            }
                                        }
                                }
                            }
                        }
                    }
                }
            }
            $block->overrideProductThumbnail(null);
        }
        return $this;
    }
    
    // add "Starting at" Price Prefix (front)
    public function toHtmlBlockFrontAfter($observer) {
        $helper = Mage::helper('customoptions');
        if (!$helper->isEnabled() || !$helper->isPricePrefixEnabled()) return $this;        
        $block = $observer->getEvent()->getBlock();        
        if ($block instanceof Mage_Catalog_Block_Product_Price) {
            $transport = $observer->getEvent()->getTransport();            
            if (Mage::app()->getRequest()->getControllerName()!='product' && Mage::app()->getRequest()->getActionName()!='configure') {
                $product = $block->getProduct();
                if ($product) {
                    if (is_null($product->getHasOptions())) $product->load($product->getId());
                    if (($product->getHasOptions() && $product->getFinalPrice()!=$product->getMaxPrice()) || ($product->getRequiredOptions() && $product->getAbsolutePrice())) {
                        $html = trim($transport->getHtml());
                        $htmlArr = explode('<', $html);
                        if (count($htmlArr)==7) {
                            $htmlArr[2] .= '<span class="price-label">'. $helper->__('Starting at') . '</span> ';
                            $html = implode('<', $htmlArr);
                            $transport->setHtml($html);
                        }                    
                    }
                }
            }
        }        
        return $this;
    }
    
    // ckeckout/cart
    public function checkQuoteItemQtyAndCustomerGroup($observer) {
        if (!Mage::helper('customoptions')->isEnabled()) return $this;
        $quoteItem = $observer->getEvent()->getItem();
        /* @var $quoteItem Mage_Sales_Model_Quote_Item */
        if (!$quoteItem || !$quoteItem->getProductId() || !$quoteItem->getQuote() || $quoteItem->getQuote()->getIsSuperMode()) {
            return $this;
        }

        $helper = Mage::helper('customoptions');      
        if (!$helper->isInventoryEnabled() && !$helper->isCustomerGroupsEnabled()) return $this;
        
        // product Qty
        $qty = 0;        
        // if update cart -> cart[182][qty]
        $quoteItemId = $quoteItem->getId();        
        if ($quoteItemId>0) {            
            $cartPost = Mage::app()->getRequest()->getParam('cart', false);
            if ($cartPost && isset($cartPost[$quoteItemId]['qty'])) $qty = $cartPost[$quoteItemId]['qty'];
        }                
        
        // standart add to cart
        if (!$qty) $qty = $quoteItem->getQty();
        
        if (!$qty) $qty = Mage::app()->getRequest()->getParam('qty', false);
        
        // get correctly options
        $options = false;        
        $post = Mage::app()->getRequest()->getParams();        
        
        if (isset($post['id'])) {
            // if update quote item 
            if ($post['id']==$quoteItemId) {
                // if quote item edited:
                if (isset($post['options'])) $options = $post['options'];
                $qty = Mage::app()->getRequest()->getParam('qty', false);                
            } else {
                return $this;
            }
        } else {
            $product = $quoteItem->getProduct();
            if (is_null($product->getHasOptions())) $product->load($product->getId());
            if (!$product->getHasOptions() || !$product->getCustomOption('info_buyRequest')) return $this;
            $post = $product->getCustomOption('info_buyRequest')->getValue();
            if ($post) $post = unserialize ($post); else $post = array();
            if (isset($post['options'])) $options = $post['options'];
        }        
        
        if ($options) {
            $customerGroupId = $helper->getCustomerGroupId();
            
            $quote = $quoteItem->getQuote();

            foreach ($options as $optionId => $option) {
                $productOption = Mage::getModel('catalog/product_option')->load($optionId);

                // check Options Customer Group
                if ($helper->isCustomerGroupsEnabled()) {
                    $groups = $productOption->getCustomerGroups();
                    if ($groups!=='' && !in_array($customerGroupId, explode(',', $groups))) {
                        $fullMessage = $helper->__('Some options are not available for your customer group. Please, edit product "%s"', $quoteItem->getProduct()->getName());
                        $message = $helper->__('Some options are not available for your customer group');
                        
                        $quoteItem->setHasError(true)->setMessage($message);
                        if ($quoteItem->getParentItem()) {
                            $quoteItem->getParentItem()->setMessage($message);
                        }
                        $quote->setHasError(true)->addMessage($fullMessage, 'options');
                        return $this;
                        break;
                    }
                }
                
                // check Options Inventory and if not Backorders
                if ($helper->isInventoryEnabled() && $helper->getOutOfStockOptions()!=2) {
                    
                    $optionType = $productOption->getType();
                    if ($productOption->getGroupByType($optionType)!=Mage_Catalog_Model_Product_Option::OPTION_GROUP_SELECT) continue;                                        
                    if (!is_array($option)) $option = array($option);
                    
                    
                    foreach ($option as $optionTypeId) {
                        if (!$optionTypeId) continue;
                        
                        $row = $productOption->getOptionValue($optionTypeId);
                        if (!$row) continue;
                        $value = new Varien_Object($row);
                        
                        list($customoptionsQty, $backorders) = $helper->getCustomoptionsQty(isset($row['customoptions_qty'])?$row['customoptions_qty']:'', isset($row['sku'])?$row['sku']:'', $quoteItem->getProductId(), $value, $quoteItem->getId(), $quote, true);
                        if ($backorders) continue;
                        if (substr($customoptionsQty, 0, 1)!='x' && $customoptionsQty!=='') {
                            
                            switch ($optionType) {
                                case 'checkbox':
                                case 'multiswatch':
                                    if (isset($post['options_'.$optionId.'_'.$optionTypeId.'_qty'])) $optionQty = intval($post['options_'.$optionId.'_'.$optionTypeId.'_qty']); else $optionQty = 1;
                                    break;
                                case 'drop_down':
                                case 'radio':
                                case 'swatch':    
                                    if (isset($post['options_'.$optionId.'_qty'])) $optionQty = intval($post['options_'.$optionId.'_qty']); else $optionQty = 1;
                                    break;
                                case 'multiple':
                                    $optionQty = 1;                            
                                    break;                       
                            }                            
                            $optionTotalQty = ($productOption->getCustomoptionsIsOnetime()?$optionQty:$optionQty*$qty);
                            
                            // is null if add new product (edit) (admin) -> correction inventory
                            if (is_null($quoteItem->getId()) && Mage::app()->getStore()->isAdmin()) $customoptionsQty += $optionTotalQty;
                            
                            if (intval($customoptionsQty)<$optionTotalQty) {
                                $productOptionResource = $productOption->getResource();
                                $message = Mage::helper('cataloginventory')->__('The requested quantity for "%s" is not available.', trim($quoteItem->getProduct()->getName() . ' / ' 
                                		. $productOptionResource->getTitle($optionId, $quoteItem->getStoreId()) . ' - '
                                		. $productOptionResource->getValueTitle($optionTypeId, $quoteItem->getStoreId())));
                                
                                if ($helper->getOutOfStockOptions()!=3) {
                                    $quoteItem->setHasError(true);
                                } else {
                                    $message .= ' ' . $helper->__('%s of the items will be backordered.', $optionTotalQty - $customoptionsQty);
                                }
                                $quoteItem->setMessage($message);
                                if ($quoteItem->getParentItem()) {
                                    $quoteItem->getParentItem()->setMessage($message);
                                }
                                
                                if ($helper->getOutOfStockOptions()!=3) {
                                    $quote->setHasError(true)->addMessage($message, 'qty');
                                }
                                //return $this;
                                //break; break;
                            }                            
                        }
                    }
                }    
            }
        }        
        return $this;
    }
        
    
    
    // before create order -> setCustomOptionsDetails
    public function convertQuoteItemToOrderItem($observer) {
        if (!Mage::helper('customoptions')->isEnabled()) return $this;
        $orderItem = $observer->getEvent()->getOrderItem();                
        $item = $observer->getEvent()->getItem();
        $product = $item->getProduct();
        // if bad magento))
        if (is_null($product->getHasOptions())) $product->load($product->getId());
        if (!$product->getHasOptions()) return $this;
        
        // multiplier - to order: 3 x Red
        Mage::helper('customoptions/product_configuration')->setCustomOptionsDetails($item);
        $quoteOptions = $product->getTypeInstance(true)->getOrderOptions($product);
        $orderOptions = $orderItem->getProductOptions();        
        if (!is_array($orderOptions)) return $this;
        
        
        // htmlspecialchars_decode titles
        if (isset($quoteOptions['options']) && is_array($quoteOptions['options'])) {
            foreach ($quoteOptions['options'] as $key=>$op) {
                if (isset($op['label'])) $quoteOptions['options'][$key]['label'] = htmlspecialchars_decode($op['label']);                
                if (isset($op['value'])) $quoteOptions['options'][$key]['value'] = htmlspecialchars_decode($op['value']);
                if (isset($op['print_value'])) unset($quoteOptions['options'][$key]['print_value']);
            }
            $orderOptions['options'] = $quoteOptions['options'];
        }        
        $orderItem->setProductOptions($orderOptions);
        return $this;
    }
    
    public function orderSaveAfter($observer) {
        if (Mage::app()->getRequest()->getControllerName()=='multishipping') $this->quoteSubmitSuccess($observer);
    }
    
    // after create order - reduce inventory + sku policy
    public function quoteSubmitSuccess($observer) {
        $helper = Mage::helper('customoptions');
        
        if (!$helper->isEnabled()) return $this;
        // inventory
        if ($helper->isInventoryEnabled()) {
            $connection = Mage::getSingleton('core/resource')->getConnection('core_write');
            $tablePrefix = (string) Mage::getConfig()->getTablePrefix();          
            $orderItems = $observer->getEvent()->getOrder()->getAllItems();
            
            foreach ($orderItems as $orderItem) {
                // options sku -> reduce product inventory or options inventory
                $productOptions = $orderItem->getProductOptions();            
                if (!isset($productOptions['options'])) continue;
                
                $qty = $orderItem->getQtyOrdered();
                foreach ($productOptions['options'] as $option) {                
                    switch ($option['option_type']) {
                        case 'drop_down':
                        case 'radio':
                        case 'checkbox':                        
                        case 'multiple':
                        case 'swatch':
                        case 'multiswatch':
                            $optionId = $option['option_id'];
                            $customoptionsIsOnetime = Mage::getModel('catalog/product_option')->load($optionId)->getCustomoptionsIsOnetime();                                                
                            $optionTypeIds = explode(',', $option['option_value']);
                            
                            foreach ($optionTypeIds as $optionTypeId) {                        
                                $productOptionValueModel = Mage::getModel('catalog/product_option_value')->load($optionTypeId);
                                $customoptionsQty = $productOptionValueModel->getCustomoptionsQty();
                                $sku = $productOptionValueModel->getSku();
                                
                                if ($customoptionsQty==='' && $sku=='') continue;
                                
                                if (isset($productOptions['info_buyRequest']['options_'.$optionId.'_qty'])) {
                                    $optionQty = intval($productOptions['info_buyRequest']['options_'.$optionId.'_qty']);
                                } elseif (isset($productOptions['info_buyRequest']['options_'.$optionId.'_'.$optionTypeId.'_qty'])) {
                                    $optionQty = intval($productOptions['info_buyRequest']['options_'.$optionId.'_'.$optionTypeId.'_qty']);
                                } else {
                                    $optionQty = 1;
                                }                            
                                $optionTotalQty = ($customoptionsIsOnetime?$optionQty:$optionQty*$qty);

                                // check link inventory to other option by IGI
                                if (substr($customoptionsQty, 0, 1)=='i') {
                                    $IGI = substr($customoptionsQty, 1);
                                    $row = $helper->getRowValueByIGI($IGI, $orderItem->getProductId());
                                    if ($row) {
                                        $optionTypeId = $row['option_type_id'];
                                        $sku = $row['sku'];
                                        $customoptionsQty = $row['customoptions_qty'];
                                    }
                                }
                                
                                if ($customoptionsQty!=='' && substr($customoptionsQty, 0, 1)!='x') {
                                    $customoptionsQty = intval($customoptionsQty) - $optionTotalQty;
                                    // model 'catalog/product_option_value' - do not use!
                                    $connection->update($tablePrefix . 'catalog_product_option_type_value', array('customoptions_qty'=>$customoptionsQty), 'option_type_id = '.$optionTypeId);
                                }

                                if ($sku!=='') {
                                    $product = Mage::getModel('catalog/product')->loadByAttribute('sku', $sku);
                                    if (isset($product) && $product && $product->getId() > 0) {
                                        $item = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product);
                                        if ($item->getUseConfigManageStock()) {
                                            $manageStock = Mage::getStoreConfig(Mage_CatalogInventory_Model_Stock_Item::XML_PATH_ITEM . 'manage_stock');
                                        } else {
                                            $manageStock = $item->getManageStock();
                                        }
                                        if ($manageStock) {
                                            $item->subtractQty($optionTotalQty);
                                            $item->save();
                                        }
                                    }
                                }
                                    
                            }
                    }    
                }
            }
        }
        
        
        // OptionSkuPolicy
        if ($helper->isOptionSkuPolicyEnabled()) {
            
            $configSkuPolicy = $helper->getOptionSkuPolicyDefault();
            
            $connection = Mage::getSingleton('core/resource')->getConnection('core_write');
            $tablePrefix = (string) Mage::getConfig()->getTablePrefix();
            $order = $observer->getEvent()->getOrder();
            $orderTotalQtyOrdered = $order->getTotalQtyOrdered();
            $orderChangesFlag = false;
            $invoiceChangesFlag = false;
            $orderItems = $order->getAllItems();            
            
            foreach ($orderItems as $orderItem) {
                $orderItemChangesFlag = false;
                $orderItemRemoveFlag = false;                
                $productOptions = $orderItem->getProductOptions();
                if (!isset($productOptions['options'])) continue;
                                                
                $product = Mage::getModel('catalog/product')->setStoreId($orderItem->getStoreId())->load($orderItem->getProductId());
                                
                $productSkuPolicy = $helper->getProductSkuPolicy($product);
                if ($productSkuPolicy==0) $productSkuPolicy = $configSkuPolicy;
                
                $store = Mage::app()->getStore($orderItem->getStoreId());
                $updateProductOptions = $productOptions;
                
                $reduce = array(
                    'weight' => 0,
                    'price' => 0,
                    'base_price' => 0,
                    'total_price' => 0,
                    'base_total_price' => 0,
                    'tax_amount' => 0,
                    'base_tax_amount' => 0,
                    'cost' => 0
                );
             
                $skuReplacement = array();                
                
                $isInvoiced = false;
                foreach ($productOptions['options'] as $index=>$option) {                    
                    $optionId = $option['option_id'];
                    $optionModel = $product->getOptionById($optionId);
                    if (!$optionModel) continue;
                    $optionModel->setProduct($optionModel);
                    $customoptionsIsOnetime = $optionModel->getCustomoptionsIsOnetime();
                    $skuPolicy = $optionModel->getSkuPolicy();
                    // or $productSkuPolicy = Grouped
                    if ($skuPolicy==0 || $productSkuPolicy==3) $skuPolicy = $productSkuPolicy;                    
                    if ($skuPolicy==1) continue;
                    
                    switch ($option['option_type']) {
                        case 'drop_down':
                        case 'radio':
                        case 'checkbox':                        
                        case 'multiple':
                        case 'swatch':
                        case 'multiswatch':
                            $optionTypeIds = explode(',', $option['option_value']);
                            foreach ($optionTypeIds as $optionTypeId) {
                                if (!$optionTypeId) continue;
                                $valueModel = $optionModel->getValueById($optionTypeId);
                                $sku = $valueModel->getSku();
                                if (!$sku) continue;
                                
                                if ($skuPolicy==2 || $skuPolicy==3) { // Independent, Grouped
                                    list($reduce, $orderTotalQtyOrdered, $isInvoiced) = $this->insertNewOrderItem($sku, $option['option_type'], $orderItem, $valueModel, $productOptions, $store, $optionId, $optionTypeId, $connection, $tablePrefix, $reduce, $orderTotalQtyOrdered, $customoptionsIsOnetime, $product);
                                    if (isset($updateProductOptions['options'][$index])) unset($updateProductOptions['options'][$index]);
                                    if (isset($updateProductOptions['info_buyRequest']['options'][$optionId])) unset($updateProductOptions['info_buyRequest']['options'][$optionId]);
                                    if ($skuPolicy==3) $orderItemRemoveFlag = true;
                                    $orderChangesFlag = true;                                    
                                } elseif ($skuPolicy==4) { // Replacement
                                    $skuReplacement[] = $sku;
                                }
                                $orderItemChangesFlag = true;
                            }
                            break;
                        default:
                            $sku = $optionModel->getSku();
                            if ($sku) {
                                if ($skuPolicy==2 || $skuPolicy==3) { // Independent, Grouped
                                    list($reduce, $orderTotalQtyOrdered, $isInvoiced) = $this->insertNewOrderItem($sku, $option['option_type'], $orderItem, $optionModel, $productOptions, $store, $optionId, 0, $connection, $tablePrefix, $reduce, $orderTotalQtyOrdered, $customoptionsIsOnetime, $product);
                                    if (isset($updateProductOptions['options'][$index])) unset($updateProductOptions['options'][$index]);
                                    if (isset($updateProductOptions['info_buyRequest']['options'][$optionId])) unset($updateProductOptions['info_buyRequest']['options'][$optionId]);
                                    if ($skuPolicy==3) $orderItemRemoveFlag = true;
                                    $orderChangesFlag = true;                                    
                                } elseif ($skuPolicy==4) { // Replacement
                                    $skuReplacement[] = $sku;
                                }
                                $orderItemChangesFlag = true;
                            }
                            break;
                    }
                }
                
                if ($isInvoiced) $invoiceChangesFlag = true;
                
                if ($orderItemRemoveFlag) {
                    // remove order_item
                    $connection->delete($tablePrefix . 'sales_flat_order_item', 'item_id = ' . $orderItem->getId());                    
                    if ($isInvoiced) $connection->delete($tablePrefix . 'sales_flat_invoice_item', 'order_item_id = ' . $orderItem->getId());
                    
                    $orderTotalQtyOrdered -= $orderItem->getQtyOrdered();
                } else {
                    // update original order_item
                    
                    if ($orderItemChangesFlag) {
                        $updateItemData = array();
                        
                        // get simple $productSku
                        $productSku = $product->getSku();
                        // get correct configurable sku
                        if ($product->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE) {
                            $childrenItems = $orderItem->getChildrenItems();
                            if ($childrenItems) {
                                foreach ($childrenItems as $childrenItem) {
                                    $productSku = $childrenItem->getSku();
                                }
                            }
                        }
                        // add to $productSku - options sku
                        if (isset($updateProductOptions['info_buyRequest'])) {
                            $_buyRequest = new Varien_Object($updateProductOptions['info_buyRequest']);
                            $product->getTypeInstance(true)->processConfiguration($_buyRequest, $product);
                            $productSku = $product->getTypeInstance(true)->getOptionSku($product, $productSku);
                        }
                        
                        
                        $skuReplacement = implode('-', $skuReplacement);
                        
                        $updateItemData['sku'] = ($skuReplacement ? $skuReplacement : $productSku);
                        $updateItemData['product_options'] = serialize($updateProductOptions);

                        if ($reduce['weight']>0) $updateItemData['weight'] = $orderItem->getWeight() - $reduce['weight'];
                        if ($reduce['cost']>0) $updateItemData['base_cost'] = $orderItem->getBaseCost() - $reduce['cost'];

                        if ($reduce['price']>0) $updateItemData['price'] = $orderItem->getPrice() - ($reduce['price'] / $orderItem->getQtyOrdered());
                        if ($reduce['base_price']>0) $updateItemData['base_price'] = $orderItem->getBasePrice() - ($reduce['base_price'] / $orderItem->getQtyOrdered());

                        if ($reduce['price']>0) $updateItemData['original_price'] = $orderItem->getOriginalPrice() - ($reduce['price'] / $orderItem->getQtyOrdered());
                        if ($reduce['base_price']>0) $updateItemData['base_original_price'] = $orderItem->getBaseOriginalPrice() - ($reduce['base_price'] / $orderItem->getQtyOrdered());

                        if ($reduce['total_price']>0) $updateItemData['row_total'] = $orderItem->getRowTotal() - $reduce['total_price'];
                        if ($reduce['base_total_price']>0) $updateItemData['base_row_total'] = $orderItem->getBaseRowTotal() - $reduce['base_total_price'];

                        if ($reduce['price']>0) $updateItemData['price_incl_tax'] = $orderItem->getPriceInclTax() - ($reduce['price'] / $orderItem->getQtyOrdered()) - ($reduce['tax_amount']>0 ? $reduce['tax_amount'] / $orderItem->getQtyOrdered():0);
                        if ($reduce['base_price']>0) $updateItemData['base_price_incl_tax'] = $orderItem->getBasePriceInclTax() - ($reduce['base_price'] / $orderItem->getQtyOrdered()) - ($reduce['base_tax_amount']>0 ? $reduce['base_tax_amount'] / $orderItem->getQtyOrdered():0);

                        if ($reduce['total_price']>0) $updateItemData['row_total_incl_tax'] = $orderItem->getRowTotalInclTax() - $reduce['total_price'] - $reduce['tax_amount'];
                        if ($reduce['base_total_price']>0) $updateItemData['base_row_total_incl_tax'] = $orderItem->getBaseRowTotalInclTax() - $reduce['base_total_price'] - $reduce['base_tax_amount'];
                        
                        if ($reduce['tax_amount']>0) $updateItemData['tax_amount'] = $orderItem->getTaxAmount() - $reduce['tax_amount'];
                        if ($reduce['base_tax_amount']>0) $updateItemData['base_tax_amount'] = $orderItem->getBaseTaxAmount() - $reduce['base_tax_amount'];
                                                
                        if ($isInvoiced) {
                            if ($reduce['total_price']>0) $updateItemData['row_invoiced'] = $orderItem->getRowInvoiced() - $reduce['total_price'];
                            if ($reduce['base_total_price']>0) $updateItemData['base_row_invoiced'] = $orderItem->getBaseRowInvoiced() - $reduce['base_total_price'];
                            if ($reduce['tax_amount']>0) $updateItemData['tax_invoiced'] = $orderItem->getTaxInvoiced() - $reduce['tax_amount'];
                            if ($reduce['base_tax_amount']>0) $updateItemData['base_tax_invoiced'] = $orderItem->getBaseTaxInvoiced() - $reduce['base_tax_amount'];
                        }
                        
                        $connection->update($tablePrefix . 'sales_flat_order_item', $updateItemData, 'item_id = ' . $orderItem->getId());
                        
                        if ($isInvoiced) {
                            $updateItemData = array();
                            $updateItemData['sku'] = ($skuReplacement? $skuReplacement : $productSku);                                                        
                            if ($reduce['price']>0) $updateItemData['price'] = $orderItem->getPrice() - ($reduce['price'] / $orderItem->getQtyOrdered());
                            if ($reduce['base_price']>0) $updateItemData['base_price'] = $orderItem->getBasePrice() - ($reduce['base_price'] / $orderItem->getQtyOrdered());
                            if ($reduce['total_price']>0) $updateItemData['row_total'] = $orderItem->getRowTotal() - $reduce['total_price'];
                            if ($reduce['base_total_price']>0) $updateItemData['base_row_total'] = $orderItem->getBaseRowTotal() - $reduce['base_total_price'];
                            if ($reduce['price']>0) $updateItemData['price_incl_tax'] = $orderItem->getPriceInclTax() - ($reduce['price'] / $orderItem->getQtyOrdered()) - ($reduce['tax_amount']>0 ? $reduce['tax_amount'] / $orderItem->getQtyOrdered():0);
                            if ($reduce['base_price']>0) $updateItemData['base_price_incl_tax'] = $orderItem->getBasePriceInclTax() - ($reduce['base_price'] / $orderItem->getQtyOrdered()) - ($reduce['base_tax_amount']>0 ? $reduce['base_tax_amount'] / $orderItem->getQtyOrdered():0);
                            if ($reduce['total_price']>0) $updateItemData['row_total_incl_tax'] = $orderItem->getRowTotalInclTax() - $reduce['total_price'] - $reduce['tax_amount'];
                            if ($reduce['base_total_price']>0) $updateItemData['base_row_total_incl_tax'] = $orderItem->getBaseRowTotalInclTax() - $reduce['base_total_price'] - $reduce['base_tax_amount'];
                            $connection->update($tablePrefix . 'sales_flat_invoice_item', $updateItemData, 'order_item_id = ' . $orderItem->getId());
                        }
                    }
                }
            } 
            //update  sales_flat_order total_qty_ordered
            $orderId = $order->getId();
            if ($invoiceChangesFlag) $connection->update($tablePrefix . 'sales_flat_invoice', array('total_qty'=>$orderTotalQtyOrdered), 'order_id = ' . $orderId);
            if ($orderChangesFlag) {
                $connection->update($tablePrefix . 'sales_flat_order', array('total_qty_ordered'=>$orderTotalQtyOrdered), 'entity_id = ' . $orderId);
                // reload order to correct e-mail send
                $order->unsetData()->load($orderId);
            }
            
        }
        
        return $this;
    }
    
    public function insertNewOrderItem($sku, $optionType, $orderItem, $optionModel, $productOptions, $store, $optionId, $optionTypeId, $connection, $tablePrefix, $reduce, $orderTotalQtyOrdered, $customoptionsIsOnetime, $product) { 
        $finalProductPrice = $product->getFinalPrice();
        
        $helper = Mage::helper('customoptions');
        
        $isInvoiced = false;
        $productBySku = Mage::getModel('catalog/product')->setStoreId($store->getId())->loadByAttribute('sku', $sku);
        // insert new order item
        $itemData = array();
        if ($productBySku && $productBySku->getId() > 0) {
            $productId = $productBySku->getId();
            $productName = $productBySku->getName();
        } else {                                    
            $productId = 0; //$orderItem->getProductId();
            $productName = $optionModel->getTitle();
        }
        //$productName .= ' ' . $orderItem->getName();
        
        $itemData['product_id'] = $productId;
        $itemData['name'] = $productName;
        
        $itemData['order_id'] = $orderItem->getOrderId();
        $itemData['quote_item_id'] = $orderItem->getQuoteItemId();
        $itemData['store_id'] = $orderItem->getStoreId();
        $itemData['created_at'] = $orderItem->getCreatedAt();
        $itemData['updated_at'] = $orderItem->getUpdatedAt();

        $itemData['product_type'] = 'simple';
        $itemData['product_options'] = '';

        $itemData['weight'] = $optionModel->getWeight();
        $reduce['weight'] += floatval($itemData['weight']);
        
        $itemData['base_cost'] = floatval($optionModel->getCost());
        $reduce['cost'] += $itemData['base_cost'];
        

        $itemData['sku'] = $sku;
                
        if (($optionType=='field' || $optionType=='area') && isset($productOptions['info_buyRequest']['options'][$optionId])) {
            $itemData['description'] = $productOptions['info_buyRequest']['options'][$optionId];
        } else {
            $itemData['description'] = $optionModel->getDescription();
        }
        
        $qty = $orderItem->getQtyOrdered();
        if ($qty==$orderItem->getQtyInvoiced()) $isInvoiced = true;
        
        if (isset($productOptions['info_buyRequest']['options_'.$optionId.'_qty'])) {
            $optionQty = intval($productOptions['info_buyRequest']['options_'.$optionId.'_qty']);
        } elseif (isset($productOptions['info_buyRequest']['options_'.$optionId.'_'.$optionTypeId.'_qty'])) {
            $optionQty = intval($productOptions['info_buyRequest']['options_'.$optionId.'_'.$optionTypeId.'_qty']);
        } else {
            $optionQty = 1;
        }
        $optionTotalQty = ($customoptionsIsOnetime?$optionQty:$optionQty*$qty);
        $orderTotalQtyOrdered += $optionTotalQty;
        $itemData['qty_ordered'] = $optionTotalQty;
        if ($isInvoiced) $itemData['qty_invoiced'] = $optionTotalQty;
        
        // get price data
        $basePrice = $helper->getOptionPriceByQty($optionModel, $optionTotalQty, $product);
        // option taxClassId
        $taxClassId = ($optionModel->getIsSkuPrice() ? $optionModel->getTaxClassId() : $product->getTaxClassId());
                
        // calculate tax
        if ($basePrice!=0) {
            //$quote = Mage::getSingleton('checkout/cart')->getQuote();
            $quote = Mage::getSingleton('checkout/session')->getQuote();
            
            if (Mage::helper('tax')->priceIncludesTax($store)) {
                $basePriceInclTax = $basePrice;
                $basePrice = $helper->getPriceExcludeTax($basePrice, $quote, $taxClassId);
            } else {    
                $basePriceInclTax = $basePrice + $helper->getTaxPrice($basePrice, $quote, $taxClassId);
            }
        } else {
            $basePriceInclTax = 0;
        }
        
        // convert basePrice - to price
        $price = $store->convertPrice($basePrice, false, false);
        $priceInclTax = $store->convertPrice($basePriceInclTax, false, false);
        
        //$basePrice = (($optionModel->getPriceType()=='percent') ? $finalProductPrice * $optionModel->getPrice() / 100 : $optionModel->getPrice());        
        $itemData['base_price'] = $basePrice;
        $reduce['base_price'] += floatval($itemData['base_price']) * $optionTotalQty;
        
        
        $itemData['price'] = $price;
        $reduce['price'] += floatval($itemData['price']) * $optionTotalQty;

        $itemData['original_price'] = $itemData['price'];
        $itemData['base_original_price'] = $itemData['base_price'];                                                                        

        $itemData['row_total'] = $itemData['price'] * $optionTotalQty;
        $reduce['total_price'] += floatval($itemData['row_total']);
        $itemData['base_row_total'] = $itemData['base_price'] * $optionTotalQty;
        $reduce['base_total_price'] += floatval($itemData['base_row_total']);
        
        $itemData['price_incl_tax'] = $priceInclTax;
        $itemData['base_price_incl_tax'] = $basePriceInclTax;

        $itemData['row_total_incl_tax'] = $itemData['price_incl_tax'] * $optionTotalQty;
        $itemData['base_row_total_incl_tax'] = $itemData['base_price_incl_tax'] * $optionTotalQty;
        
        $itemData['tax_percent'] = $helper->getTaxRate($quote, $taxClassId);
        
        $itemData['tax_amount'] = ($priceInclTax - $price) * $optionTotalQty;
        $reduce['tax_amount'] += floatval($itemData['tax_amount']);
        
        $itemData['base_tax_amount'] = ($basePriceInclTax  - $basePrice) * $optionTotalQty;
        $reduce['base_tax_amount'] += floatval($itemData['base_tax_amount']);
        
        if ($isInvoiced) {
            $itemData['qty_invoiced'] = $itemData['qty_ordered'];
            
            $itemData['row_invoiced'] = $itemData['row_total'];
            $itemData['base_row_invoiced'] = $itemData['base_row_total'];
            
            $itemData['tax_invoiced'] = $itemData['tax_amount'];
            $itemData['base_tax_invoiced'] = $itemData['base_tax_amount'];
        }

        //print_r($itemData); exit;
        $connection->insert($tablePrefix . 'sales_flat_order_item', $itemData);
        $orderItemId = $connection->lastInsertId($tablePrefix . 'sales_flat_order_item');
        
        // insert invoice item
        if ($isInvoiced && $orderItemId) {
            $invoice = $orderItem->getOrder()->getInvoiceCollection()->getFirstItem();
            if ($invoice && $invoice->getId()) {            
                $itemInvoiceData = array();            
                $itemInvoiceData['parent_id'] = $invoice->getId();
                
                $itemInvoiceData['price'] = $itemData['price'];
                $itemInvoiceData['base_price'] = $itemData['base_price'];
                
                $itemInvoiceData['row_total'] = $itemData['row_total'];
                $itemInvoiceData['base_row_total'] = $itemData['base_row_total'];
                
                $itemInvoiceData['tax_amount'] = $itemData['tax_amount'];
                $itemInvoiceData['base_tax_amount'] = $itemData['base_tax_amount'];                
                
                $itemInvoiceData['price_incl_tax'] = $itemData['price_incl_tax'];
                $itemInvoiceData['base_price_incl_tax'] = $itemData['base_price_incl_tax'];
                
                $itemInvoiceData['row_total_incl_tax'] = $itemData['row_total_incl_tax'];
                $itemInvoiceData['base_row_total_incl_tax'] = $itemData['base_row_total_incl_tax'];                
                
                $itemInvoiceData['qty'] = $optionTotalQty;
                $itemInvoiceData['product_id'] = $productId;
                $itemInvoiceData['order_item_id'] = $orderItemId;
                $itemInvoiceData['sku'] = $sku;                
                $itemInvoiceData['name'] = $productName;
                $connection->insert($tablePrefix . 'sales_flat_invoice_item', $itemInvoiceData);
            }            
        }
        
        return array($reduce, $orderTotalQtyOrdered, $isInvoiced);
    }
    
    public function cancelOrderItem($observer) {
        $helper = Mage::helper('customoptions');
        if (!$helper->isInventoryEnabled()) return $this;
        
        $orderItem = $observer->getEvent()->getItem();
        $connection = Mage::getSingleton('core/resource')->getConnection('core_write');
        $tablePrefix = (string) Mage::getConfig()->getTablePrefix();
        
        // qty cancel now
        $qty = intval($orderItem->getQtyToCancel());

        // options sku -> increase product inventory or options inventory
        $productOptions = $orderItem->getProductOptions();
        if (!isset($productOptions['options'])) return $this;
        
        
        foreach ($productOptions['options'] as $option) {                
            switch ($option['option_type']) {
                case 'drop_down':
                case 'radio':
                case 'checkbox':                        
                case 'multiple':
                case 'swatch':
                case 'multiswatch':
                    $optionId = $option['option_id'];
                    $customoptionsIsOnetime = Mage::getModel('catalog/product_option')->load($optionId)->getCustomoptionsIsOnetime();
                    $optionTypeIds = explode(',', $option['option_value']);
                    foreach ($optionTypeIds as $optionTypeId) {                    
                        $productOptionValueModel = Mage::getModel('catalog/product_option_value')->load($optionTypeId);
                        $customoptionsQty = $productOptionValueModel->getCustomoptionsQty();
                        $sku = $productOptionValueModel->getSku();
                        if ($customoptionsQty==='' && $sku=='') continue;
                        
                        if (isset($productOptions['info_buyRequest']['options_'.$optionId.'_qty'])) {
                            $optionQty = intval($productOptions['info_buyRequest']['options_'.$optionId.'_qty']);
                        } elseif (isset($productOptions['info_buyRequest']['options_'.$optionId.'_'.$optionTypeId.'_qty'])) {
                            $optionQty = intval($productOptions['info_buyRequest']['options_'.$optionId.'_'.$optionTypeId.'_qty']);                            
                        } else {
                            $optionQty = 1;
                        }                                                                        
                        $optionTotalQty = ($customoptionsIsOnetime?$optionQty:$optionQty*$qty);                        
                        
                        // check link inventory to other option by IGI
                        if (substr($customoptionsQty, 0, 1)=='i') {
                            $IGI = substr($customoptionsQty, 1);
                            $row = $helper->getRowValueByIGI($IGI, $orderItem->getProductId());
                            if ($row) {
                                $optionTypeId = $row['option_type_id'];
                                $sku = $row['sku'];
                                $customoptionsQty = $row['customoptions_qty'];
                            }
                        }
                        
                        if ($customoptionsQty!=='' && substr($customoptionsQty, 0, 1)!='x') {
                            $customoptionsQty = $customoptionsQty + $optionTotalQty;                                
                            // model 'catalog/product_option_value' - do not use!
                            $connection->update($tablePrefix . 'catalog_product_option_type_value', array('customoptions_qty'=>$customoptionsQty), 'option_type_id = '.$optionTypeId);                                
                        }

                        if ($sku!=='') {
                            $product = Mage::getModel('catalog/product')->loadByAttribute('sku', $sku);
                            if (isset($product) && $product && $product->getId() > 0) {
                                $item = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product);                                    
                                $item->addQty($optionTotalQty);
                                $item->save();
                            }
                        }
                            
                    }    
            }            

        }        
        
        return $this;
        
    }

    public function creditMemoRefund($observer) {
        $helper = Mage::helper('customoptions');
        if (!$helper->isInventoryEnabled()) return $this;

        $orderItems = $observer->getEvent()->getCreditmemo()->getOrder()->getItemsCollection();                
        $connection = Mage::getSingleton('core/resource')->getConnection('core_write');
        $tablePrefix = (string) Mage::getConfig()->getTablePrefix();             
        $creditmemoData = Mage::app()->getRequest()->getParam('creditmemo');
        
        foreach ($orderItems as $orderItem) {
            // if not ckecked "Return to Stock"
            if (!isset($creditmemoData['items'][$orderItem->getId()]['back_to_stock'])) continue;            
            
            // qty refund now            
            $qty = intval($orderItem->getQtyRefunded()) - intval($orderItem->getOrigData('qty_refunded'));
            
            // options sku -> increase product inventory and options inventory
            $productOptions = $orderItem->getProductOptions();
            if (!isset($productOptions['options'])) continue;
            
            foreach ($productOptions['options'] as $option) {                
                switch ($option['option_type']) {
                    case 'drop_down':
                    case 'radio':
                    case 'checkbox':                        
                    case 'multiple':
                    case 'swatch':
                    case 'multiswatch':
                        $optionId = $option['option_id'];
                        $customoptionsIsOnetime = Mage::getModel('catalog/product_option')->load($optionId)->getCustomoptionsIsOnetime();                        
                        $optionTypeIds = explode(',', $option['option_value']);
                        foreach ($optionTypeIds as $optionTypeId) {                        
                            $productOptionValueModel = Mage::getModel('catalog/product_option_value')->load($optionTypeId);
                            $customoptionsQty = $productOptionValueModel->getCustomoptionsQty();
                            $sku = $productOptionValueModel->getSku();
                            if ($customoptionsQty==='' && $sku=='') continue;
                            
                            if (isset($productOptions['info_buyRequest']['options_'.$optionId.'_qty'])) {
                                $optionQty = intval($productOptions['info_buyRequest']['options_'.$optionId.'_qty']);
                            } elseif (isset($productOptions['info_buyRequest']['options_'.$optionId.'_'.$optionTypeId.'_qty'])) {
                                $optionQty = intval($productOptions['info_buyRequest']['options_'.$optionId.'_'.$optionTypeId.'_qty']);    
                            } else {
                                $optionQty = 1;
                            }                            
                            $optionTotalQty = ($customoptionsIsOnetime?$optionQty:$optionQty*$qty);
                            
                            // check link inventory to other option by IGI
                            if (substr($customoptionsQty, 0, 1)=='i') {
                                $IGI = substr($customoptionsQty, 1);
                                $row = $helper->getRowValueByIGI($IGI, $orderItem->getProductId());
                                if ($row) {
                                    $optionTypeId = $row['option_type_id'];
                                    $sku = $row['sku'];
                                    $customoptionsQty = $row['customoptions_qty'];
                                }
                            }
                            
                            if ($customoptionsQty!=='' && substr($customoptionsQty, 0, 1)!='x') {
                                $customoptionsQty = $customoptionsQty + $optionTotalQty;
                                // model 'catalog/product_option_value' - do not use!
                                $connection->update($tablePrefix . 'catalog_product_option_type_value', array('customoptions_qty'=>$customoptionsQty), 'option_type_id = '.$optionTypeId);
                            }

                            if ($sku!=='') {
                                $product = Mage::getModel('catalog/product')->loadByAttribute('sku', $sku);
                                if (isset($product) && $product && $product->getId() > 0) {
                                    $item = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product);                                    
                                    $item->addQty($optionTotalQty);
                                    $item->save();
                                }
                            }
                                
                        }     
                }    
                    
            }
        }            
        return $this;                                              
    }

    // set weight, cost and sku_police apply to cart
    public function quoteItemSetProduct($observer) {
        $helper = Mage::helper('customoptions');        
        if (!$helper->isEnabled() || (!$helper->isWeightEnabled() && !$helper->isOptionSkuPolicyEnabled() && !$helper->isOptionSkuPolicyApplyToCart() && !$helper->isCostEnabled())) return $this;
        
        
        $quoteItem = $observer->getEvent()->getQuoteItem();
        if (!$quoteItem || !$quoteItem->getProductId() || !$quoteItem->getQuote()) return $this;
        
        $product = $quoteItem->getProduct();
        
        // prepare post data
        $infoBuyRequestValue= $product->getCustomOption('info_buyRequest')->getValue();
        if ($infoBuyRequestValue) $post = unserialize($infoBuyRequestValue); else $post = array();
        
        if ($helper->isOptionSkuPolicyApplyToCart()) {
            //if (isset($post['sku_policy_name'])) $quoteItem->setName($post['sku_policy_name']);
            if (isset($post['sku_policy_weight'])) $quoteItem->setWeight($post['sku_policy_weight']);
            if (isset($post['sku_policy_sku'])) $quoteItem->setSku($post['sku_policy_sku']);
        }
        
        if (!$helper->isWeightEnabled() && !$helper->isOptionSkuPolicyEnabled() && !$helper->isCostEnabled()) return $this;
        
        if (isset($post['options'])) $options = $post['options']; else $options = false;      
            
        if ($options) {
            
            // if ProductSkuPolicy = Grouped -> disable inventory
            if ($helper->getProductSkuPolicy($product)==3) {
                $stockItem = $product->getStockItem();
                $stockItem->setUseConfigManageStock(0);
                $stockItem->setManageStock(0);
            }
            
            if (!$helper->isWeightEnabled() && !$helper->isCostEnabled()) return $this;
            
            $customerGroupId = $helper->getCustomerGroupId();

            $optionsWeight = 0;
            $optionsCost = 0;
            
            foreach ($options as $optionId => $option) {                     
                $productOption = Mage::getModel('catalog/product_option')->load($optionId);
                
                // check Options Customer Group
                if ($helper->isCustomerGroupsEnabled() && $productOption->getCustomerGroups()!=='' && !in_array($customerGroupId, explode(',', $productOption->getCustomerGroups()))) continue;
                
                // set options weight and cost
                $optionType = $productOption->getType();                    
                if ($productOption->getGroupByType($optionType)!=Mage_Catalog_Model_Product_Option::OPTION_GROUP_SELECT) continue;
                if (!is_array($option)) $option = array($option);
                //product Qty
                $qty = intval($quoteItem->getQty());
                
                
                foreach ($option as $optionTypeId) {
                    if (!$optionTypeId) continue;
                    
                    switch ($optionType) {
                        case 'checkbox':
                        case 'multiswatch':
                            if (isset($post['options_'.$optionId.'_'.$optionTypeId.'_qty'])) $optionQty = intval($post['options_'.$optionId.'_'.$optionTypeId.'_qty']); else $optionQty = 1;
                            break;
                        case 'drop_down':
                        case 'radio':
                        case 'swatch':    
                            if (isset($post['options_'.$optionId.'_qty'])) $optionQty = intval($post['options_'.$optionId.'_qty']); else $optionQty = 1;
                            break;
                        case 'multiple':
                            $optionQty = 1;                            
                            break;                       
                    }
                    
                    $row = $productOption->getOptionValue($optionTypeId);
                    
                    // get option weight
                    if (isset($row['weight']) && $row['weight']>0) {
                        $weight = floatval($row['weight']);
                        if ($productOption->getCustomoptionsIsOnetime()) $weight = $weight / $qty;
                        $optionsWeight += $weight * $optionQty;                        
                    }
                    
                    // get option cost
                    if (isset($row['cost']) && $row['cost']>0) {
                        $cost = floatval($row['cost']);
                        if ($productOption->getCustomoptionsIsOnetime()) $cost = $cost / $qty;
                        $optionsCost += $cost * $optionQty;                        
                    }
                    
                }
            }
            
            if ($helper->isWeightEnabled() && $optionsWeight>0) {
                // check absolute weight
                if (!$helper->getProductAbsoluteWeight($product)) $optionsWeight += $quoteItem->getWeight();
                // set weight for qty=1
                $quoteItem->setWeight($optionsWeight);    
            }
            
            if ($helper->isCostEnabled() && $optionsCost>0) {
                // check absolute price
                if (!$helper->getProductAbsolutePrice($product)) $optionsCost += $quoteItem->getBaseCost();
                // set baseCost for qty=1
                $quoteItem->setBaseCost($optionsCost);    
            }
            
        }
        return $this;
    }
    
    
    
    // isOptionSkuPolicyApplyToCart
    public function quoteProductAddAfter($observer) {
        $helper = Mage::helper('customoptions');
        if (!$helper->isEnabled() || !$helper->isOptionSkuPolicyEnabled() || !$helper->isOptionSkuPolicyApplyToCart()) return $this;
        $configSkuPolicy = $helper->getOptionSkuPolicyDefault();
        
        $items = $observer->getEvent()->getItems();
        foreach ($items as $item) {
            $itemChangesFlag = false;
            $itemRemoveFlag = false;
            
            $product = $item->getProduct();
            
            // if bad magento))
            if (is_null($product->getHasOptions())) $product->load($product->getId());
            if (!$product->getHasOptions()) continue;
            
            $productSkuPolicy = $helper->getProductSkuPolicy($product);
            if ($productSkuPolicy==0) $productSkuPolicy = $configSkuPolicy;
            
            $infoBuyRequestValue= $product->getCustomOption('info_buyRequest')->getValue();
            if ($infoBuyRequestValue) $infoBuyRequestValue = unserialize($infoBuyRequestValue); else $infoBuyRequestValue = array();
            
            if (isset($infoBuyRequestValue['options'])) $options = $infoBuyRequestValue['options']; else $options = false;
            
            if ($options) {
                foreach ($options as $optionId => $value) {                     
                    $optionModel = $product->getOptionById($optionId);
                    if (!$optionModel) continue;
                    $optionModel->setProduct($optionModel);
                    
                    $customoptionsIsOnetime = $optionModel->getCustomoptionsIsOnetime();
                    $skuPolicy = $optionModel->getSkuPolicy();

                    // or $productSkuPolicy = Grouped
                    if ($skuPolicy==0 || $productSkuPolicy==3) $skuPolicy = $productSkuPolicy; 
                    if ($skuPolicy==1) continue;
                    
                    switch ($optionModel->getType()) {
                        case 'drop_down':
                        case 'radio':
                        case 'checkbox':                        
                        case 'multiple':
                        case 'swatch':
                        case 'multiswatch':
                            if (is_array($value)) {
                                $optionTypeIds = $value;
                            } else {
                                $optionTypeIds = explode(',', $value);
                            }
                            
                            foreach ($optionTypeIds as $index=>$optionTypeId) {
                                if (!$optionTypeId) continue;
                                $valueModel = $optionModel->getValueById($optionTypeId);
                                $sku = $valueModel->getSku();
                                if (!$sku) continue;
                                
                                $productIdBySku = $helper->getProductIdBySku($sku);
                                if (!$productIdBySku) continue;
                                
                                
                                if ($skuPolicy==2 || $skuPolicy==3) { // Independent, Grouped
                                    // add new product by $productIdBySku
                                    if (isset($infoBuyRequestValue['options_'.$optionId.'_qty'])) {
                                        $optionQty = intval($infoBuyRequestValue['options_'.$optionId.'_qty']);
                                    } elseif (isset($infoBuyRequestValue['options_'.$optionId.'_'.$optionTypeId.'_qty'])) {
                                        $optionQty = intval($infoBuyRequestValue['options_'.$optionId.'_'.$optionTypeId.'_qty']);
                                    } else {
                                        $optionQty = 1;
                                    }
                                    
                                    
                                    $optionTotalQty = ($customoptionsIsOnetime?$optionQty:$optionQty*$item->getQty());
                                    $request = new Varien_Object();
                                    $request->setQty($optionTotalQty);
                                    
                                    $optionResourceModel = $optionModel->getResource();
                                    $request->setSkuPolicyName($optionResourceModel->getValueTitle($optionTypeId, $item->getStoreId()));
                                    if ($helper->isWeightEnabled()) $request->setSkuPolicyWeight($valueModel->getWeight());
                                    if ($helper->isCostEnabled()) $request->setSkuPolicyCost($valueModel->getCost());
                                    
                                    //$item->getQuote() or Mage::getSingleton('checkout/cart')
                                    $result = $item->getQuote()->addProduct(Mage::getModel('catalog/product')->setStoreId($item->getStoreId())->load($productIdBySku), $request);
                                    if (!is_object($result)) continue;
                                    
                                    // remove option or optionValue from item
                                    if (is_array($value)) {
                                        unset($value[$index]);
                                    } else {
                                        $value = '';
                                    }
                                    if ($value) {
                                        // if remove optionValue
                                        $infoBuyRequestValue['options'][$optionId] = $value;
                                        $itemOption = $item->getOptionByCode('option_'.$optionId);
                                        $itemOption->setValue((is_array($value)?implode(',', $value):$value));
                                        $item->addOption($itemOption);
                                    } else {
                                        // if remove option
                                        unset($infoBuyRequestValue['options'][$optionId]);
                                        $item->removeOption('option_'.$optionId);
                                        
                                        $itemOptionIds = $item->getOptionByCode('option_ids');
                                        $optionIds = $itemOptionIds->getValue();
                                        if ($optionIds) {
                                            $optionIds = explode(',', $optionIds);
                                            $i = array_search($optionId, $optionIds);
                                            if ($i!==false) unset($optionIds[$i]);
                                            if ($optionIds) {
                                                $optionIds = implode(',', $optionIds);
                                            }
                                            
                                        }
                                        if ($optionIds) {
                                            $itemOptionIds->setValue($optionIds);
                                            $item->addOption($itemOptionIds);
                                        } else {
                                            $item->removeOption('option_ids');
                                        }
                                    }
                                    $infoBuyRequest = $item->getOptionByCode('info_buyRequest');
                                    $infoBuyRequest->setValue(serialize($infoBuyRequestValue));
                                    $item->addOption($infoBuyRequest);
                                    // end remove option from item
                                    
                                    $itemChangesFlag = true;
                                    if ($skuPolicy==3) $itemRemoveFlag = true;
                                } elseif ($skuPolicy==4) {
                                    $infoBuyRequest = $item->getOptionByCode('info_buyRequest');
                                    $infoBuyRequestValue['sku_policy_sku'] = $sku;
                                    $infoBuyRequest->setValue(serialize($infoBuyRequestValue));
                                    $item->addOption($infoBuyRequest);
                                }
                            }
                            break;
                        default:
                            if (!$value) continue;
                            
                            $sku = $optionModel->getSku();
                            if (!$sku) continue;
                            $productIdBySku = $helper->getProductIdBySku($sku);
                            if (!$productIdBySku) continue;
                                
                            if ($skuPolicy==2 || $skuPolicy==3) { // Independent, Grouped
                                // add new product by $productIdBySku
                                $optionTotalQty = ($customoptionsIsOnetime?1:$item->getQty());
                                $request = new Varien_Object();
                                $request->setQty($optionTotalQty);
                                $optionResourceModel = $optionModel->getResource();
                                $request->setSkuPolicyName($optionResourceModel->getTitle($optionId, $item->getStoreId()));
                                
                                //$item->getQuote() or Mage::getSingleton('checkout/cart')
                                $result = $item->getQuote()->addProduct(Mage::getModel('catalog/product')->setStoreId($item->getStoreId())->load($productIdBySku));
                                if (!is_object($result)) continue;
                                
                                // remove option from item
                                unset($infoBuyRequestValue['options'][$optionId]);
                                $item->removeOption('option_'.$optionId);

                                $itemOptionIds = $item->getOptionByCode('option_ids');
                                $optionIds = $itemOptionIds->getValue();
                                if ($optionIds) {
                                    $optionIds = explode(',', $optionIds);
                                    $i = array_search($optionId, $optionIds);
                                    if ($i!==false) unset($optionIds[$i]);
                                    if ($optionIds) {
                                        $optionIds = implode(',', $optionIds);
                                    }

                                }
                                if ($optionIds) {
                                    $itemOptionIds->setValue($optionIds);
                                    $item->addOption($itemOptionIds);
                                } else {
                                    $item->removeOption('option_ids');
                                }
                                $infoBuyRequest = $item->getOptionByCode('info_buyRequest');
                                $infoBuyRequest->setValue(serialize($infoBuyRequestValue));
                                $item->addOption($infoBuyRequest);
                                // end remove option from item
                                
                                $itemChangesFlag = true;
                                if ($skuPolicy==3) $itemRemoveFlag = true;
                            } elseif ($skuPolicy==4) {
                                $infoBuyRequest = $item->getOptionByCode('info_buyRequest');
                                $infoBuyRequestValue['sku_policy_sku'] = $sku;
                                $infoBuyRequest->setValue(serialize($infoBuyRequestValue));
                                $item->addOption($infoBuyRequest);
                            }
                                                       
                            break;
                    }
                }
            }
            if ($itemRemoveFlag) {
                $itemsCollection = $item->getQuote()->getItemsCollection();
                foreach($itemsCollection as $key=>$itm) {
                    if ($itm===$item) $itemsCollection->removeItemByKey($key);
                }
            } elseif ($itemChangesFlag) {
                // update item
                $quote = $item->getQuote();
                $itemsCollection = $quote->getItemsCollection();
                $itemRemoveFlag = false;
                foreach($itemsCollection as $key=>$itm) {
                    if ($itm->getProductId()==$item->getProductId() && $itm!==$item) {
                        
                        // get current $item - $options
                        if (isset($infoBuyRequestValue['options'])) $options = $infoBuyRequestValue['options']; else $options = false;
                        
                        // get other $itm - $optns
                        $prdct = $itm->getProduct();
                        // if bad magento))
                        if (is_null($prdct->getHasOptions())) $prdct->load($prdct->getId());
                        $optns = false;
                        if ($prdct->getHasOptions()) {
                            $infoBuyRequestValue= $prdct->getCustomOption('info_buyRequest')->getValue();
                            if ($infoBuyRequestValue) $infoBuyRequestValue = unserialize($infoBuyRequestValue); else $infoBuyRequestValue = array();
                            if (isset($infoBuyRequestValue['options'])) $optns = $infoBuyRequestValue['options'];
                        }
                        
                        // compare options
                        if ($optns===$options) {
                            $itm->setQty($itm->getQty() + $item->getQty());
                            $itemRemoveFlag = true;
                        }
                        
                    }
                    if ($itemRemoveFlag && $itm===$item) $itemsCollection->removeItemByKey($key);
                }
            }
        }
    }
    
    public function catalogProductCollectionLoadBefore($observer) {
        $collection = $observer->getCollection();
        $query = new Zend_Db_Expr("IF((
            SELECT vm.view_mode AS required_options 
            FROM ".Mage::getSingleton('core/resource')->getTableName('catalog_product_option')." AS cpo 
            LEFT JOIN ".Mage::getSingleton('core/resource')->getTableName('custom_options_option_view_mode')." AS vm ON cpo.option_id=vm.option_id AND (vm.store_id='". intval(Mage::app()->getStore()->getId()) ."' OR vm.store_id=0)
            WHERE e.entity_id=cpo.product_id  AND cpo.is_require=1 ORDER BY vm.store_id DESC LIMIT 0,1)='1','1','0')");

       $inject = $collection->getSelect()->getPart('columns');
       $inject[] = array('e',$query,'required_options');
       $collection->getSelect()->setPart('columns',$inject);
    }
    
    public function orderItemsLoadBefore($observer) {
        $helper = Mage::helper('customoptions');
        if ($helper->isEnabled() && $helper->isOptionSkuPolicyEnabled()) {
            $observer->getEvent()->getOrderItemCollection()->setOrder('quote_item_id', 'ASC')->setOrder('item_id', 'ASC');
        }
    }

}