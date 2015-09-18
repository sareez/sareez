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
                
                if($_value->getTitle() =='None')
		{
		   $checked = 'checked="checked" style="display:none;"';
		   $style = "style='display:none;'";
		}
		else
		{
		 $style ="";  		    
		}    
		
		$_product = $this->getProduct();
		$categoryIds = $_product->getCategoryIds();
		if(count($categoryIds) ){
		$firstCategoryId = $categoryIds[0];
		if($firstCategoryId == 90){
				
				if($count==1){
					//echo "11";
					$testhtml = "<span class=".'"'."mark_round".'"'.">
					<a onclick=".'"'."document.getElementById('light_popup').style.display='block';document.getElementById('fade').style.display='block'".'"'." href=".'"'."javascript:void(0)".'"'.">?</a></span>
					<div class=".'"'."product_content_popup".'"'." id=".'"'."light_popup".'"'."><a onclick=".'"'."document.getElementById('light_popup').style.display='none';document.getElementById('fade').style.display='none'".'"'." href=".'"'."javascript:void(0)".'"'." class=".'"'."close_button_option".'"'.">
					
					<img src=".'"'."http://www.sareez.com/skin/frontend/default/sareez/images/dialog_close.png".'"'."></a>
					<p class=".'"'."abcdef".'"'.">
					Saree comes with an unstitched blouse </br>
					piece which needs to be stitched with </br>
					exact measurement. The measurements, </br>
					design and cuts suggestion is solely </br>
					yours. You are free to design your </br>
					blouses in a way which will suit </br>
					you best.</p>   
					
					</div> 
					<div class=".'"'."black_overlay_popup".'"'." id=".'"'."fade".'"'."></div>	
					
					<span class=".'"'."hr_lined".'"'."><img src=".'"'."http://magento-7350-19577-45479.cloudwaysapps.com/skin/frontend/default/sareez/images_001/horizontal-line.png".'"'.">
					</span>";
				
				}if($count==2){
					//echo "22";
					$testhtml = "<span class=".'"'."mark_round".'"'.">
					<a onclick=".'"'."document.getElementById('light_popup1').style.display='block';document.getElementById('fade').style.display='block'".'"'." href=".'"'."javascript:void(0)".'"'.">?</a></span>
					<div class=".'"'."product_content_popup".'"'." id=".'"'."light_popup1".'"'."><a onclick=".'"'."document.getElementById('light_popup1').style.display='none';document.getElementById('fade').style.display='none'".'"'." href=".'"'."javascript:void(0)".'"'." class=".'"'."close_button_option".'"'.">
					
					<img src=".'"'."http://www.sareez.com/skin/frontend/default/sareez/images/dialog_close.png".'"'."></a>
					<p class=".'"'."abcdef".'"'.">
					Petticoat is the inner skirt worn </br>
					under a saree to tuck in the saree.</br>
					The max available size of standard </br>
					petticoat is 36 to 38 inches in </br>
					length and waist both.</p>   
					
					</div> 
					<div class=".'"'."black_overlay_popup".'"'." id=".'"'."fade".'"'."></div>	
					
					<span class=".'"'."hr_lined".'"'."><img src=".'"'."http://magento-7350-19577-45479.cloudwaysapps.com/skin/frontend/default/sareez/images_001/horizontal-line.png".'"'.">
					</span>";
				}if($count==3){
					//echo "33";
					$testhtml = "<span class=".'"'."mark_round".'"'.">
					<a onclick=".'"'."document.getElementById('light_popup2').style.display='block';document.getElementById('fade').style.display='block'".'"'." href=".'"'."javascript:void(0)".'"'.">?</a></span>
					<div class=".'"'."product_content_popup".'"'." id=".'"'."light_popup2".'"'."><a onclick=".'"'."document.getElementById('light_popup2').style.display='none';document.getElementById('fade').style.display='none'".'"'." href=".'"'."javascript:void(0)".'"'." class=".'"'."close_button_option".'"'.">
					
					<img src=".'"'."http://www.sareez.com/skin/frontend/default/sareez/images/dialog_close.png".'"'."></a>
					<p class=".'"'."abcdef".'"'.">
					Petticoat or inner skirt can be </br>
					customised according to your </br>
					height and waist size as chosen </br>
					by you. The tailors can increase </br>
					the length and the waist size </br>
					of the petticoat as desired.</p>   
					
					</div> 
					<div class=".'"'."black_overlay_popup".'"'." id=".'"'."fade".'"'."></div>	
					
					<span class=".'"'."hr_lined".'"'."><img src=".'"'."http://magento-7350-19577-45479.cloudwaysapps.com/skin/frontend/default/sareez/images_001/horizontal-line.png".'"'.">
					</span>";
				}if($count==4){
					//echo "44";
					$testhtml = "<span class=".'"'."mark_round".'"'.">
					<a onclick=".'"'."document.getElementById('light_popup3').style.display='block';document.getElementById('fade').style.display='block'".'"'." href=".'"'."javascript:void(0)".'"'.">?</a></span>
					<div class=".'"'."product_content_popup".'"'." id=".'"'."light_popup3".'"'."><a onclick=".'"'."document.getElementById('light_popup3').style.display='none';document.getElementById('fade').style.display='none'".'"'." href=".'"'."javascript:void(0)".'"'." class=".'"'."close_button_option".'"'.">
					
					<img src=".'"'."http://www.sareez.com/skin/frontend/default/sareez/images/dialog_close.png".'"'."></a>
					<p class=".'"'."abcdef".'"'.">
					Lehenga style saree comes pre-</br>
					stitched in their pleats part. </br>
					Pleats are folding done in the</br>
					saree to gather it and making </br>
					it narrow on the front according</br>
					to the measurements of your </br>
					waist.</p>   
					
					</div> 
					<div class=".'"'."black_overlay_popup".'"'." id=".'"'."fade".'"'."></div>	
					
					<span class=".'"'."hr_lined".'"'."><img src=".'"'."http://magento-7350-19577-45479.cloudwaysapps.com/skin/frontend/default/sareez/images_001/horizontal-line.png".'"'.">
					</span>";
				}
	
	
		} elseif($firstCategoryId == 27){
			
			//echo $count;
			
			$testhtml = "<span class=".'"'."mark_round".'"'.">
		<a onclick=".'"'."document.getElementById('light_popup').style.display='block';document.getElementById('fade').style.display='block'".'"'." href=".'"'."javascript:void(0)".'"'.">?</a></span>
	<div class=".'"'."product_content_popup".'"'." id=".'"'."light_popup".'"'."><a onclick=".'"'."document.getElementById('light_popup').style.display='none';document.getElementById('fade').style.display='none'".'"'." href=".'"'."javascript:void(0)".'"'." class=".'"'."close_button_option".'"'.">
	
	<img src=".'"'."http://www.sareez.com/skin/frontend/default/sareez/images/dialog_close.png".'"'."></a>
		      <p class=".'"'."abcdef".'"'.">
			  Unstitched salwar kameez when stitched</br>
			  with your perfect measurements by the</br>
			  experts, will give you a perfect look.</br>
			  To give you this perfect look, </br>
			  measurement form is made to fill up </br>
			  and the stitching cost is taken for</br>
			  the labour.</p>   
        
         </div> 
		<div class=".'"'."black_overlay_popup".'"'." id=".'"'."fade".'"'."></div>	
	
	";
		}elseif($firstCategoryId == 3){
			//echo $count;
			
			$testhtml = "<span class=".'"'."mark_round".'"'.">
		<a onclick=".'"'."document.getElementById('light_popup').style.display='block';document.getElementById('fade').style.display='block'".'"'." href=".'"'."javascript:void(0)".'"'.">?</a></span>
	<div class=".'"'."product_content_popup".'"'." id=".'"'."light_popup".'"'."><a onclick=".'"'."document.getElementById('light_popup').style.display='none';document.getElementById('fade').style.display='none'".'"'." href=".'"'."javascript:void(0)".'"'." class=".'"'."close_button_option".'"'.">
	
	<img src=".'"'."http://www.sareez.com/skin/frontend/default/sareez/images/dialog_close.png".'"'."></a>
		      <p class=".'"'."abcdef".'"'.">
			  The lehengas are unstitched and they</br>
			  are stitched according to your </br>
			  measurements filled in the measurement</br>
			  form. With the correct measurements </br>
			  and our expert tailoring you get the </br>
			  perfect flaunting look of your </br>
			  selected lehenga choli</br>
</p>   
        
         </div> 
		<div class=".'"'."black_overlay_popup".'"'." id=".'"'."fade".'"'."></div>	
	
	";
		}
		}
		?>
        
        
                  <?php
	    
                
                if ($helper->isQntyInputEnabled() && $_option->getQntyInput() && $_option->getType()==Mage_Catalog_Model_Product_Option::OPTION_TYPE_CHECKBOX) {                    
                    if ($buyRequest) $optionValueQty = $buyRequest->getData('options_'.$_option->getId().'_'.$_value->getOptionTypeId().'_qty'); else $optionValueQty = 0;
                    if (!$optionValueQty && $checked) $optionValueQty = 1;
                    $selectHtml .=
                        '<input ' . $disabled . ' ' . $checked . ' type="' . $type . '" class="' . $class . ' ' . $require . ' product-custom-option" onclick="optionSetQtyProduct.checkboxQty(this); '.$onclick.'" name="options[' . $_option->getId() . ']' . $arraySign . '" id="options_' . $_option->getId() . '_' . $count . '" value="' . $_value->getOptionTypeId() . '" />'
                        . $imagesHtml .
                        '<span class="label">
                            <label  '.$style.' for="options_' . $_option->getId() . '_' . $count . '">' . $_value->getTitle() . ' ' . $priceStr . $qty . '</label>
                            &nbsp;&nbsp;&nbsp;
                            <label class="label-qty"><b>'.$helper->getDefaultOptionQtyLabel().'</b> <input type="text" class="input-text qty'. ($checked?' validate-greater-than-zero':'') .'" value="'.$optionValueQty.'" maxlength="12" id="options_'.$_option->getId().'_'.$_value->getOptionTypeId().'_qty" name="options_'.$_option->getId().'_'.$_value->getOptionTypeId().'_qty" onchange="'.((Mage::app()->getStore()->isAdmin())?'':'opConfig.reloadPrice();'.$setProdutQtyFunc).'" onKeyPress="if(event.keyCode==13){'.((Mage::app()->getStore()->isAdmin())?'':'opConfig.reloadPrice();') . $setProdutQtyFunc .'}" '.($checked?$disabled:'disabled').'></label>
                         </span>';
                } else {
					$_product1 = $this->getProduct();
					$categoryIds1 = $_product1->getCategoryIds();
					if(count($categoryIds1) ){
					$firstCategoryId1 = $categoryIds1[0];
					if($firstCategoryId1 == 27){
                    $selectHtml .=
                        '<input ' . $disabled . ' ' . $checked . ' type="' . $type . '" class="' . $class . ' ' . $require . ' product-custom-option" onclick="'.$onclick.'" name="options[' . $_option->getId() . ']' . $arraySign . '" id="options_' . $_option->getId() . '_' . $count . '" value="' . $_value->getOptionTypeId() . '" />'
                        . $imagesHtml .
                        '<span class="label option2_price"><label '.$style.' for="options_' . $_option->getId() . '_' . $count . '">' . "Salwars Stitching" . ' ' . $testhtml . $priceStr . $qty . '</label></span>';
					}else if($firstCategoryId1 == 3){
                    $selectHtml .=
                        '<input ' . $disabled . ' ' . $checked . ' type="' . $type . '" class="' . $class . ' ' . $require . ' product-custom-option" onclick="'.$onclick.'" name="options[' . $_option->getId() . ']' . $arraySign . '" id="options_' . $_option->getId() . '_' . $count . '" value="' . $_value->getOptionTypeId() . '" />'
                        . $imagesHtml .
                        '<span class="label option2_price"><label '.$style.' for="options_' . $_option->getId() . '_' . $count . '">' . "Lehenga Stitching" . ' ' . $testhtml . $priceStr . $qty . '</label></span>';
					} else { 
                    $selectHtml .=
                        '<input ' . $disabled . ' ' . $checked . ' type="' . $type . '" class="' . $class . ' ' . $require . ' product-custom-option" onclick="'.$onclick.'" name="options[' . $_option->getId() . ']' . $arraySign . '" id="options_' . $_option->getId() . '_' . $count . '" value="' . $_value->getOptionTypeId() . '" />'
                        . $imagesHtml .
                        '<span class="label"><label '.$style.' for="options_' . $_option->getId() . '_' . $count . '">' . $_value->getTitle() . ' ' . $testhtml . $priceStr . $qty . '</label></span>';
					}
					}


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