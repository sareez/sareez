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

class MageWorx_CustomOptions_Block_Catalog_Product_View_Options_Type_Select extends Mage_Catalog_Block_Product_View_Options_Type_Select {

    static $isFirstOption = true;

    public function getValuesHtml() {
        $_option = $this->getOption();        
        $helper = Mage::helper('customoptions');
        $displayQty = $helper->canDisplayQtyForOptions();
        $outOfStockOptions = $helper->getOutOfStockOptions();
        $enabledInventory = $helper->isInventoryEnabled();
        $enabledDependent = $helper->isDependentEnabled();
        $enabledSpecialPrice = $helper->isSpecialPriceEnabled();
        
        if ((version_compare(Mage::getVersion(), '1.5.0', '>=') && version_compare(Mage::getVersion(), '1.9.0', '<')) || version_compare(Mage::getVersion(), '1.10.0', '>=')) {
            $configValue = $this->getProduct()->getPreconfiguredValues()->getData('options/' . $_option->getId());                                                    
        } else {
            $configValue = false;
        }
        
        $buyRequest = false;
        $quoteItemId = 0;
        if ($helper->isQntyInputEnabled() && Mage::app()->getRequest()->getControllerName()!='product') {
            $quoteItemId = (int) $this->getRequest()->getParam('id');
            if ($quoteItemId) {                
                if (Mage::app()->getStore()->isAdmin()) {
                    $item = Mage::getSingleton('adminhtml/session_quote')->getQuote()->getItemById($quoteItemId);
                } else {
                    $item = Mage::getSingleton('checkout/cart')->getQuote()->getItemById($quoteItemId);           
                }
                if ($item) {
                    $buyRequest = $item->getBuyRequest();
                    if ($_option->getType() != Mage_Catalog_Model_Product_Option::OPTION_TYPE_CHECKBOX) {
                        $optionQty = $buyRequest->getData('options_' . $_option->getId() . '_qty');
                        $_option->setOptionQty($optionQty);
                    }
                }
            }
        }
        
        if ($_option->getType()==Mage_Catalog_Model_Product_Option::OPTION_TYPE_DROP_DOWN || $_option->getType()==Mage_Catalog_Model_Product_Option::OPTION_TYPE_MULTIPLE 
            || $_option->getType()==MageWorx_CustomOptions_Model_Catalog_Product_Option::OPTION_TYPE_SWATCH || $_option->getType()==MageWorx_CustomOptions_Model_Catalog_Product_Option::OPTION_TYPE_MULTISWATCH) {
            
            $require = '';
            if ($_option->getType()==MageWorx_CustomOptions_Model_Catalog_Product_Option::OPTION_TYPE_SWATCH || $_option->getType()==MageWorx_CustomOptions_Model_Catalog_Product_Option::OPTION_TYPE_MULTISWATCH) {
                $require = ' hidden';
            }
            if ($_option->getIsRequire(true)) {                
                if ($enabledDependent && $_option->getIsDependent()) $require .= ' required-dependent'; else $require .= ' required-entry';
            }
            
            $extraParams = ($enabledDependent && $_option->getIsDependent()?' disabled="disabled"':'');
            $select = $this->getLayout()->createBlock('core/html_select')
                    ->setData(array(
                        'id' => 'select_' . $_option->getId(),
                        'class' => $require . ' product-custom-option' . ($_option->getType()==MageWorx_CustomOptions_Model_Catalog_Product_Option::OPTION_TYPE_SWATCH || $_option->getType()==MageWorx_CustomOptions_Model_Catalog_Product_Option::OPTION_TYPE_MULTISWATCH ? ' swatch' : '')
                    ));
            if ($_option->getType()==Mage_Catalog_Model_Product_Option::OPTION_TYPE_DROP_DOWN || $_option->getType()==MageWorx_CustomOptions_Model_Catalog_Product_Option::OPTION_TYPE_SWATCH) {
                $select->setName('options[' . $_option->getid() . ']')->addOption('', $this->__('-- Please Select --'));
            } else {
                $select->setName('options[' . $_option->getid() . '][]');
                $select->setClass('multiselect' . $require . ' product-custom-option');
            }
            
            $imagesHtml = '';
            $showImgFlag = false;
            $setProdutQtyJs = '';
            
            foreach ($_option->getValues() as $_value) {
                $qty = '';
                $customoptionsQty = $helper->getCustomoptionsQty($_value->getCustomoptionsQty(), $_value->getSku(), $this->getProduct()->getId(), $_value, $quoteItemId);
                if ($enabledInventory && $outOfStockOptions==1 && ($customoptionsQty===0 || $_value->getIsOutOfStock())) continue;
                
                $selectOptions = array();
                $disabled = '';
                if ($enabledInventory && $customoptionsQty===0 && $outOfStockOptions==0) {
                    $selectOptions['disabled'] = $disabled = 'disabled';
                }
                
                $selected = '';
                if ($_value->getDefault()==1 && !$disabled && !$configValue) {
                    if (!$enabledDependent || !$_option->getIsDependent()) $selectOptions['selected'] = $selected = 'selected';
                } elseif ($configValue) {
                    $selected = (is_array($configValue) && in_array($_value->getOptionTypeId(), $configValue)) ? 'selected' : '';
                }

                if ($enabledInventory) {
                    if ($displayQty && substr($customoptionsQty, 0, 1)!='x' && $customoptionsQty!=='') {
                        $qty = ' (' . ($customoptionsQty > 0 ? $customoptionsQty : $helper->__('Out of stock')) . ')';
                    }                
                    if (substr($customoptionsQty, 0, 1)=='x') {
                        if (!$setProdutQtyJs) {
                            $setProdutQtyJs = 'optionSetQtyProductData['.$_option->getId().'] = [];';
                        } 
                        $setProdutQtyJs .= 'optionSetQtyProductData['.$_option->getId().']['.$_value->getOptionTypeId().']='.intval(substr($customoptionsQty, 1)).';';
                    }
                }
                if ($setProdutQtyJs) $setProdutQtyFunc = 'optionSetQtyProduct.setQty();'; else $setProdutQtyFunc = '';
                
                
                $priceStr = $helper->getFormatedOptionPrice($this->getProduct(), $_option, $_value);
                
                // swatch
                if ($_option->getType()==MageWorx_CustomOptions_Model_Catalog_Product_Option::OPTION_TYPE_SWATCH || $_option->getType()==MageWorx_CustomOptions_Model_Catalog_Product_Option::OPTION_TYPE_MULTISWATCH) {
                    $images = $_value->getImages();
                    
                    if (count($images)>0) {
                        $showImgFlag = true;
                        if ($disabled) {
                            $onClick = 'return false;';
                            $className = 'swatch swatch-disabled';
                        } else {
                            $onClick = 'optionSwatch.select('. $_option->getId() .', '.$_value->getOptionTypeId().'); return false;';
                            $className = 'swatch';
                        }
                        
                        if ($buyRequest) $optionValueQty = $buyRequest->getData('options_'.$_option->getId().'_'.$_value->getOptionTypeId().'_qty'); else $optionValueQty = 0;
                        
                        $image = $images[0];
                        if ($image['source']==1) { // file
                            $arr = $helper->getImgHtml($image['image_file'], false, false, true);
                            if (isset($arr['big_img_url'])) {
                                $imagesHtml .= '<li id="swatch_'. $_value->getOptionTypeId() .'" class="'. $className .'">'.
                                        '<a href="'.$arr['big_img_url'].'" onclick="'. $onClick .'">'.
                                            '<img src="'.$arr['url'].'" title="'.$this->htmlEscape($_value->getTitle() . ' - ' . strip_tags(str_replace(array('<s>', '</s>'), array('(', ')'), $priceStr))).'" class="swatch small-image-preview v-middle" />'.
                                        '</a>'.
                                        (($helper->isQntyInputEnabled() && $_option->getQntyInput() && $_option->getType()==MageWorx_CustomOptions_Model_Catalog_Product_Option::OPTION_TYPE_MULTISWATCH) ? '<br/><label><b>'. $helper->getDefaultOptionQtyLabel() .'</b> <input type="text" class="input-text qty'. ($selected ? ' validate-greater-than-zero' : '') .'" value="'.$optionValueQty.'" maxlength="12" id="options_'.$_option->getId().'_'.$_value->getOptionTypeId().'_qty" name="options_'.$_option->getId().'_'.$_value->getOptionTypeId().'_qty" onchange="'.((Mage::app()->getStore()->isAdmin())?'':'opConfig.reloadPrice();') . $setProdutQtyFunc .'" onKeyPress="if(event.keyCode==13){'.((Mage::app()->getStore()->isAdmin())?'':'opConfig.reloadPrice();'.$setProdutQtyFunc).'}" '. ($selected?$disabled:'disabled') .'></label>' : '') .
                                    '</li>';
                            }
                        } elseif ($image['source']==2) { // color
                            $imagesHtml .= '<li id="swatch_'. $_value->getOptionTypeId() .'" class="'. $className .'">'.
                                        '<a href="#" onclick="'. $onClick .'">'.
                                            '<div class="swatch container-swatch-color small-image-preview v-middle"" title="'.$this->htmlEscape($_value->getTitle() . ' - ' . strip_tags(str_replace(array('<s>', '</s>'), array('(', ')'), $priceStr))).'">'.
                                                '<div class="swatch-color" style="background:'. $image['image_file'] .';">&nbsp;</div>'.
                                            '</div>'.
                                        '</a>'.
                                        (($helper->isQntyInputEnabled() && $_option->getQntyInput() && $_option->getType()==MageWorx_CustomOptions_Model_Catalog_Product_Option::OPTION_TYPE_MULTISWATCH) ? '<br/><label><b>'. $helper->getDefaultOptionQtyLabel() .'</b> <input type="text" class="input-text qty'. ($selected ? ' validate-greater-than-zero' : '') .'" value="'.$optionValueQty.'" maxlength="12" id="options_'.$_option->getId().'_'.$_value->getOptionTypeId().'_qty" name="options_'.$_option->getId().'_'.$_value->getOptionTypeId().'_qty" onchange="'.((Mage::app()->getStore()->isAdmin())?'':'opConfig.reloadPrice();') . $setProdutQtyFunc .'" onKeyPress="if(event.keyCode==13){'.((Mage::app()->getStore()->isAdmin())?'':'opConfig.reloadPrice();'.$setProdutQtyFunc).'}" '. ($selected?$disabled:'disabled') .'></label>' : '') .
                                    '</li>';
                        }
                    }
                } else {
                    if (!$imagesHtml && $_value->getImages()) {
                        $showImgFlag = true;
                            if ($_option->getImageMode()==1 || ($_option->getImageMode()>1 && $_option->getExcludeFirstImage())) {
                            $imagesHtml = '<div id="customoptions_images_'. $_option->getId() .'" class="customoptions-images-div" style="display:none"></div>';
                        }
                    }
                }
                
                $select->addOption($_value->getOptionTypeId(), $_value->getTitle() . ' ' . $priceStr . $qty, $selectOptions);
            }
            if ($_option->getType() == Mage_Catalog_Model_Product_Option::OPTION_TYPE_MULTIPLE || $_option->getType()==MageWorx_CustomOptions_Model_Catalog_Product_Option::OPTION_TYPE_MULTISWATCH) {
                $extraParams .= ' multiple="multiple"';
            }
            
            if ($_option->getType()==MageWorx_CustomOptions_Model_Catalog_Product_Option::OPTION_TYPE_SWATCH || $_option->getType()==MageWorx_CustomOptions_Model_Catalog_Product_Option::OPTION_TYPE_MULTISWATCH) {
                $extraParams .= ' style="float: left; height: 1px;"';
            }                        
            
            if ($showImgFlag) $showImgFunc = 'optionImages.showImage(this);'; else $showImgFunc = '';
            
            if ($_option->getType()==MageWorx_CustomOptions_Model_Catalog_Product_Option::OPTION_TYPE_SWATCH || $_option->getType()==MageWorx_CustomOptions_Model_Catalog_Product_Option::OPTION_TYPE_MULTISWATCH) $showImgFunc .= ' optionSwatch.change(this)';
            
            $select->setExtraParams('onchange="'.(($enabledDependent)?'dependentOptions.select(this); ':'')                
                .((Mage::app()->getStore()->isAdmin())?'':'opConfig.reloadPrice();')
                .$setProdutQtyFunc
                .$showImgFunc.'"'.$extraParams);
            
            if ($configValue) $select->setValue($configValue);
            
            if ((count($select->getOptions())>1 && ($_option->getType()==Mage_Catalog_Model_Product_Option::OPTION_TYPE_DROP_DOWN || $_option->getType()==MageWorx_CustomOptions_Model_Catalog_Product_Option::OPTION_TYPE_SWATCH)) || (count($select->getOptions())>0 && ($_option->getType()==Mage_Catalog_Model_Product_Option::OPTION_TYPE_MULTIPLE || $_option->getType()==MageWorx_CustomOptions_Model_Catalog_Product_Option::OPTION_TYPE_MULTISWATCH))) {
                $outHTML = $select->getHtml();
                if ($_option->getType()==MageWorx_CustomOptions_Model_Catalog_Product_Option::OPTION_TYPE_SWATCH || $_option->getType()==MageWorx_CustomOptions_Model_Catalog_Product_Option::OPTION_TYPE_MULTISWATCH) {
                    $outHTML = '<ul id="ul_swatch_'. $_option->getId() .'">' . $imagesHtml . '</ul>' . $outHTML;
                } else {
                    if ($imagesHtml) {
                        if ($helper->isImagesAboveOptions()) $outHTML = $imagesHtml.$outHTML; else $outHTML .= $imagesHtml;
                    }
                }
                
                if ($setProdutQtyJs) {$outHTML.='<script type="text/javascript">'.$setProdutQtyJs.'optionSetQtyProduct.hideQty();</script>'; $_option->setOptionSetQtyProduct(1);}                
                
                return $outHTML;
            }
            
        } elseif ($_option->getType()==Mage_Catalog_Model_Product_Option::OPTION_TYPE_RADIO || $_option->getType()==Mage_Catalog_Model_Product_Option::OPTION_TYPE_CHECKBOX) {
            $selectHtml = '';
            $setProdutQtyJs = '';            
                        
            $require = '';
            if ($_option->getIsRequire(true)) {                
                if ($enabledDependent && $_option->getIsDependent()) $require = ' required-dependent'; else $require = ' validate-one-required-by-name';
            }
            
            $arraySign = '';
            switch ($_option->getType()) {
                case Mage_Catalog_Model_Product_Option::OPTION_TYPE_RADIO:
                    $type = 'radio';
                    $class = 'radio';
                    break;
                case Mage_Catalog_Model_Product_Option::OPTION_TYPE_CHECKBOX:
                    $type = 'checkbox';
                    $class = 'checkbox';
                    $arraySign = '[]';
                    break;
            }
            $count = 0;
            foreach ($_option->getValues() as $_value) {
                $count++;
                
                $priceStr = $helper->getFormatedOptionPrice($this->getProduct(), $_option, $_value);
                
                $qty = '';
                $customoptionsQty = $helper->getCustomoptionsQty($_value->getCustomoptionsQty(), $_value->getSku(), $this->getProduct()->getId(), $_value, $quoteItemId);
                
                if ($enabledInventory && $outOfStockOptions==1 && ($customoptionsQty===0 || $_value->getIsOutOfStock())) continue;
                
                $inventory = ($enabledInventory && $customoptionsQty===0) ? false : true;
                $disabled = (!$inventory && $outOfStockOptions==0) || ($enabledDependent && $_option->getIsDependent()) ? 'disabled="disabled"' : '';
                if ($enabledInventory) {
                    if ($displayQty && substr($customoptionsQty, 0, 1)!='x' && $customoptionsQty!=='') {
                        $qty = ' (' . ($customoptionsQty > 0 ? $customoptionsQty : $helper->__('Out of stock')) . ')';
                    }

                    if (substr($customoptionsQty, 0, 1)=='x') {
                        if (!$setProdutQtyJs) {
                            $setProdutQtyJs = 'optionSetQtyProductData['.$_option->getId().'] = [];';
                        } 
                        $setProdutQtyJs .= 'optionSetQtyProductData['.$_option->getId().']['.$_value->getOptionTypeId().']='.intval(substr($customoptionsQty, 1)).';';                        
                    }
                }    
                
                                
                if ($disabled && $enabledDependent && $helper->hideDependentOption() && $_option->getIsDependent()) $selectHtml .= '<li style="display: none;">'; else $selectHtml .= '<li>';
                
                $imagesHtml = '';
                $images = $_value->getImages();
                if ($images) {
                    if ($_option->getImageMode()==1) {
                        foreach($images as $image) {
                            if ($image['source']==1) { // file
                                $imagesHtml .= $helper->getImgHtml($image['image_file']);
                            } elseif ($image['source']==2) { // color
                                $imagesHtml .= $this->getColorHtml($image['image_file']);
                            }
                        }
                    } elseif ($_option->getExcludeFirstImage()) {
                        $image = $images[0];
                        if ($image['source']==1) { // file
                            $imagesHtml = $helper->getImgHtml($image['image_file']);
                        } elseif ($image['source']==2) { // color
                            $imagesHtml = $this->getColorHtml($image['image_file']);
                        }
                    }
                }
                                
                if ($configValue) {                    
                    if ($arraySign) {
                        $checked = (is_array($configValue) && in_array($_value->getOptionTypeId(), $configValue)) ? 'checked' : '';
                    } else {
                        $checked = ($configValue == $_value->getOptionTypeId() ? 'checked' : '');
                    }
                } else {
                    $checked = ($_value->getDefault()==1 && !$disabled) ? 'checked' : '';
                }
                
                if ($setProdutQtyJs) $setProdutQtyFunc = 'optionSetQtyProduct.setQty();'; else $setProdutQtyFunc = '';
                if ($checked) $setProdutQtyJs .= $setProdutQtyFunc;                
                
                if ($images && $_option->getImageMode()>1) $showImgFunc = 'optionImages.showImage(this);'; else $showImgFunc = '';
                
                $onclick = (($enabledDependent)?'dependentOptions.select(this);':'') . ((Mage::app()->getStore()->isAdmin())?'':'opConfig.reloadPrice();') . $setProdutQtyFunc . $showImgFunc;
  
                
                if ($helper->isQntyInputEnabled() && $_option->getQntyInput() && $_option->getType()==Mage_Catalog_Model_Product_Option::OPTION_TYPE_CHECKBOX) {                    
                    if ($buyRequest) $optionValueQty = $buyRequest->getData('options_'.$_option->getId().'_'.$_value->getOptionTypeId().'_qty'); else $optionValueQty = 0;
                    if (!$optionValueQty && $checked) $optionValueQty = 1;
                    $selectHtml .=
                        '<input ' . $disabled . ' ' . $checked . ' type="' . $type . '" class="' . $class . ' ' . $require . ' product-custom-option" onclick="optionSetQtyProduct.checkboxQty(this); '.$onclick.'" name="options[' . $_option->getId() . ']' . $arraySign . '" id="options_' . $_option->getId() . '_' . $count . '" value="' . $_value->getOptionTypeId() . '" />'
                        . $imagesHtml .
                        '<span class="label">
                            <label for="options_' . $_option->getId() . '_' . $count . '">' . $_value->getTitle() . ' ' . $priceStr . $qty . '</label>
                            &nbsp;&nbsp;&nbsp;
                            <label class="label-qty"><b>'.$helper->getDefaultOptionQtyLabel().'</b> <input type="text" class="input-text qty'. ($checked?' validate-greater-than-zero':'') .'" value="'.$optionValueQty.'" maxlength="12" id="options_'.$_option->getId().'_'.$_value->getOptionTypeId().'_qty" name="options_'.$_option->getId().'_'.$_value->getOptionTypeId().'_qty" onchange="'.((Mage::app()->getStore()->isAdmin())?'':'opConfig.reloadPrice();'.$setProdutQtyFunc).'" onKeyPress="if(event.keyCode==13){'.((Mage::app()->getStore()->isAdmin())?'':'opConfig.reloadPrice();') . $setProdutQtyFunc .'}" '.($checked?$disabled:'disabled').'></label>
                         </span>';
                } else {
                    $selectHtml .=
                        '<input ' . $disabled . ' ' . $checked . ' type="' . $type . '" class="' . $class . ' ' . $require . ' product-custom-option" onclick="'.$onclick.'" name="options[' . $_option->getId() . ']' . $arraySign . '" id="options_' . $_option->getId() . '_' . $count . '" value="' . $_value->getOptionTypeId() . '" />'
                        . $imagesHtml .
                        '<span class="label"><label for="options_' . $_option->getId() . '_' . $count . '">' . $_value->getTitle() . ' ' . $priceStr . $qty . '</label></span>';
                }
                                                
                if ($_option->getIsRequire(true)) {
                    $selectHtml .= '<script type="text/javascript">' .
                            '$(\'options_' . $_option->getId() . '_' . $count . '\').advaiceContainer = \'options-' . $_option->getId() . '-container\';' .
                            '$(\'options_' . $_option->getId() . '_' . $count . '\').callbackFunction = \'validateOptionsCallback\';' .
                            '</script>';
                }
                $selectHtml .= '</li>';                                                
            }
            
            if ($selectHtml) $selectHtml = '<ul id="options-' . $_option->getId() . '-list" class="options-list">'.$selectHtml.'</ul>';
            self::$isFirstOption = false;
            if ($setProdutQtyJs) {$selectHtml.='<script type="text/javascript">'.$setProdutQtyJs.' optionSetQtyProduct.hideQty();</script>'; $_option->setOptionSetQtyProduct(1);}
            
            return $selectHtml;
        }
    }
    
    public function getColorHtml($color) {
        return '<div class="container-swatch-color small-image-preview v-middle">'.
                    '<div class="swatch-color" style="background:'. $color .';">&nbsp;</div>'.
                '</div>';
    }
}