<?php

/**
 * Iksanika llc.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.iksanika.com/products/IKS-LICENSE.txt
 *
 * @category   Iksanika
 * @package    Iksanika_Productupdater
 * @copyright  Copyright (c) 2013 Iksanika llc. (http://www.iksanika.com)
 * @license    http://www.iksanika.com/products/IKS-LICENSE.txt
 */

include_once "Mage/Adminhtml/controllers/Catalog/ProductController.php";

class Iksanika_Productupdater_Catalog_ProductController extends Mage_Adminhtml_Catalog_ProductController
{

    protected $massactionEventDispatchEnabled = true;
    public static $exportFileName = 'products';
    
    
    protected function _construct()
    {
        // Define module dependent translate
        $this->setUsedModuleName('Iksanika_Productupdater');
    }
    
    /**
     * Product list page
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('catalog/productupdater');
        $this->_addContent($this->getLayout()->createBlock('productupdater/catalog_product'));
        $this->renderLayout();
    }

    /**
     * Product grid for AJAX request
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('productupdater/catalog_product_grid')->toHtml()
        );
    }
    
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('catalog/products');
    }
    
    public function massRefreshProductsAction()
    {
        $productIds = $this->getRequest()->getParam('product');
        if (is_array($productIds)) 
        {
            try {
                foreach ($productIds as $productId) 
                {
                    $product = Mage::getModel('catalog/product')->load($productId);
                    if ($this->massactionEventDispatchEnabled)
                    {
                        Mage::dispatchEvent('catalog_product_prepare_save', array('product' => $product, 'request' => $this->getRequest()));
                    }
                    $product->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d record(s) were successfully refreshed.', count($productIds)));
            } catch (Exception $e) 
            {
                $this->_getSession()->addError($e->getMessage());
            }
        }else
        {
            $this->_getSession()->addError($this->__('Please select product(s)'));
        }
        $this->_redirect('*/*/index');
    }

    public function massUpdateProductsAction()
    {
        $productIds = $this->getRequest()->getParam('product');

        if (is_array($productIds)) 
        {
            try {
                
                foreach ($productIds as $itemId => $productId) 
                {
                    $product = Mage::getModel('catalog/product')->load($productId);
                    $productBefore = $product;
                    $stockData = null;

                    // event was not dispached by some reasons ??? so the code to prove product is below
                    // if ($this->massactionEventDispatchEnabled)
                    //    Mage::dispatchEvent('catalog_product_prepare_save', array('product' => $product, 'request' => $this->getRequest()));
                    
                    $columnForUpdate = Iksanika_Productupdater_Block_Catalog_Product_Grid::getColumnForUpdate();
                    $columnForUpdateFlip = array_flip($columnForUpdate);

                    foreach($columnForUpdate as $columnName)
                    {
                        $columnValuesForUpdate = $this->getRequest()->getParam($columnName);
                        echo $columnName;
                        // handle exceptional situation or related tables savings
                        if($columnName == 'is_in_stock')
                        {
                            if(!$stockData)
                                $stockData = $product->getStockItem();
                            $stockData->setData('is_in_stock', $columnValuesForUpdate[$itemId]); 
                        }else
                        if($columnName == 'qty')
                        {
                            if(!$stockData)
                                $stockData = $product->getStockItem();
                            $stockData->setData('qty', $columnValuesForUpdate[$itemId]);
                        }else
                        if($columnName == 'category_ids')
                        {
                            $categoryIds = explode(',', $columnValuesForUpdate[$itemId]);
                            $product->setCategoryIds($categoryIds);
                        }else
                        if($columnName == 'related_ids')
                        {
                            $relatedIds = trim($columnValuesForUpdate[$itemId]) != "" ? explode(',', trim($columnValuesForUpdate[$itemId])) : array();
                            $link = $this->getRelatedLinks($relatedIds, array(), $productId);
                            $product->setRelatedLinkData($link);
                        }else
                        if($columnName == 'cross_sell_ids')
                        {
                            $crossSellIds = trim($columnValuesForUpdate[$itemId]) != "" ? explode(',', trim($columnValuesForUpdate[$itemId])) : array();
                            $link = $this->getRelatedLinks($crossSellIds, array(), $productId);
                            $product->setCrossSellLinkData($link);
                        }else
                        if($columnName == 'up_sell_ids')
                        {
                            $upSellIds = trim($columnValuesForUpdate[$itemId]) != "" ? explode(',', trim($columnValuesForUpdate[$itemId])) : array();
                            $link = $this->getRelatedLinks($upSellIds, array(), $productId);
                            $product->setUpSellLinkData($link);
                        }else
                        if(($columnName == 'price' && isset($columnForUpdateFlip['price_percentage'])) ||
                           ($columnName == 'special_price' && isset($columnForUpdateFlip['special_price_percentage'])) ||
                           ($columnName == 'cost' && isset($columnForUpdateFlip['cost_percentage'])) ||
                           ($columnName == 'msrp' && isset($columnForUpdateFlip['msrp_percentage']))
                          )
                        {
                            $columnValuesForUpdate_Percentage = $this->getRequest()->getParam($columnName.'_percentage');
                            if(trim($columnValuesForUpdate_Percentage[$itemId])!="")
                            {
                                $updatePercent = intval($columnValuesForUpdate_Percentage[$itemId]);
                                $updatePercent = (100+$updatePercent)/100;
                                $updatePercent = ($updatePercent <= 0) ? 1 : $updatePercent;
                                $product->$columnName =  $product->$columnName * $updatePercent;
                            }else
                            {
                                $product->$columnName =  $columnValuesForUpdate[$itemId];
                            }
                        }else 
                        if(
                            $columnName == 'price_percentage' || 
                            $columnName == 'special_price_percentage' ||
                            $columnName == 'cost_percentage' ||
                            $columnName == 'msrp_percentage'
                          )
                        {
                        }else
                            $product->$columnName =  $columnValuesForUpdate[$itemId];
                    }
                    if($stockData)
                    {
                        $stockData->save();
                    }
                    $product->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d record(s) were successfully refreshed.', count($productIds)));
            } catch (Exception $e) 
            {
                $this->_getSession()->addError($e->getMessage());
            }
        }else
        {
            $this->_getSession()->addError($this->__('Please select product(s)').'. '.$this->__('You should select checkboxes for each product row which should be updated. You can click on checkboxes or use CTRL+Click on product row which should be selected.'));
        }
        $this->_redirect('*/*/index');
    }
    
    
    public function exportCsvAction()
    {
        $content    = $this->getLayout()->createBlock('productupdater/catalog_product_grid')->getCsv();
        $this->_sendUploadResponse(self::$exportFileName.'.csv', $content);
    }

    public function exportXmlAction()
    {
        $content = $this->getLayout()->createBlock('productupdater/catalog_product_grid')->getXml();
        $this->_sendUploadResponse(self::$exportFileName.'.xml', $content);
    }
    
    
    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');

        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);

        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }

    
    
    public function getRelatedLinks($productIds, $existProducts, $productId)
    {
        $link = array();
        foreach ($productIds as $relatedToId) 
        {
            if ($productId != $relatedToId) 
            {
                $link[$relatedToId] = array('position' => null);
            }
        }
        // Fetch and append to already related products.
        foreach($existProducts as $existProduct)
        {
            $link[$existProduct->getId()] = array('position' => null);
        }
        return $link;
    }
    
     /**************************************************************************
     ** MAKE PRODUCTS RELATED
     **************************************************************************/
    
    
    /** 
     * Action make cheched products list related to each other.
     **/     
    public function massRelatedEachOtherAction()
    {
        $productIds = $this->getRequest()->getParam('product');
        if (is_array($productIds)) 
        {
            try {
                foreach ($productIds as $productId) 
                {
                    $product = Mage::getModel('catalog/product')->load($productId);
                    $link = $this->getRelatedLinks($productIds, $product->getRelatedProducts(), $productId);
                    $product->setRelatedLinkData($link);
                    
                    if ($this->massactionEventDispatchEnabled)
                    {
                        Mage::dispatchEvent('catalog_product_prepare_save', array('product' => $product, 'request' => $this->getRequest()));
                    }
                    $product->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d record(s) were successfully related to each other.', count($productIds)));
            } catch (Exception $e) 
            {
                $this->_getSession()->addError($e->getMessage());
            }
        }else
        {
            $this->_getSession()->addError($this->__('Please select product(s)'));
        }
        $this->_redirect('*/*/index');
    }
    
    
    
    /** 
     * Action which make selected products to specified products list (IDs)
     **/     
    public function massRelatedToAction()
    {
        $productIds = $this->getRequest()->getParam('product');
        $productIds2List = $this->getRequest()->getParam('callbackval');
        $productIds2 = explode(',', $productIds2List);
        
        if (is_array($productIds)) 
        {
            try {
                foreach ($productIds as $productId) 
                {
                    $product = Mage::getModel('catalog/product')->load($productId);
                    $link = $this->getRelatedLinks($productIds2, $product->getRelatedProducts(), $productId);
                    $product->setRelatedLinkData($link);

                    if ($this->massactionEventDispatchEnabled)
                    {
                        Mage::dispatchEvent('catalog_product_prepare_save', array('product' => $product, 'request' => $this->getRequest()));
                    }
                    $product->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d record(s) were successfully related to products('.$productIds2List.').', count($productIds)));
            } catch (Exception $e) 
            {
                $this->_getSession()->addError($e->getMessage());
            }
        }else
        {
            $this->_getSession()->addError($this->__('Please select product(s)'));
        }
        $this->_redirect('*/*/index');
    }
    
    
    
    /**
     * Action remove all relation in checked products list.
     **/     
    public function massRelatedCleanAction() 
    {
        $productIds = $this->getRequest()->getParam('product');
        if (is_array($productIds)) 
        {
            try {
                foreach ($productIds as $productId) 
                {
                    $product = Mage::getModel('catalog/product')->load($productId);
                    $product->setRelatedLinkData(array());
                    if ($this->massactionEventDispatchEnabled)
                    {
                        Mage::dispatchEvent('catalog_product_prepare_save', array('product' => $product, 'request' => $this->getRequest()));
                    }
                    $product->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d record(s) are no longer related to any other products.', count($productIds)));
            } catch (Exception $e) 
            {
                $this->_getSession()->addError($e->getMessage());
            }
        }else
        {
            $this->_getSession()->addError($this->__('Please select product(s)'));
        }
        $this->_redirect('*/*/index');
    }

    
    
    
    
    
     
    /***************************************************************************
     ** Cross-Selling
     **************************************************************************/  
    
    
    /** 
     * This will cross sell all products with each other.     
     **/  
    public function massCrossSellEachOtherAction()
    {
        $productIds = $this->getRequest()->getParam('product');
        if (is_array($productIds)) 
        {
            try {
                foreach ($productIds as $productId) 
                {
                    $product = Mage::getModel('catalog/product')->load($productId);
                    $link = $this->getRelatedLinks($productIds, $product->getCrossSellProducts(), $productId);
                    $product->setCrossSellLinkData($link);

                    if ($this->massactionEventDispatchEnabled)
                    {
                        Mage::dispatchEvent('catalog_product_prepare_save', array('product' => $product, 'request' => $this->getRequest()));
                    }
                    $product->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d record(s) were successfully cross-related to each other.', count($productIds)));
            } catch (Exception $e) 
            {
                $this->_getSession()->addError($e->getMessage());
            }
        }else
        {
            $this->_getSession()->addError($this->__('Please select product(s)'));
        }
        $this->_redirect('*/*/index');
    }
    
    
    
    /** 
     * This will relate all products to a specifc list of products 
     **/     
    public function massCrossSellToAction()
    {
        $productIds = $this->getRequest()->getParam('product');
        $productIds2List = $this->getRequest()->getParam('callbackval');
        $productIds2 = explode(',', $productIds2List);
        
        if (is_array($productIds)) 
        {
            try {
                foreach ($productIds as $productId) 
                {
                    $product = Mage::getModel('catalog/product')->load($productId);
                    $link = $this->getRelatedLinks($productIds2, $product->getCrossSellProducts(), $productId);
                    $product->setCrossSellLinkData($link);
                    
                    if ($this->massactionEventDispatchEnabled)
                    {
                        Mage::dispatchEvent('catalog_product_prepare_save', array('product' => $product, 'request' => $this->getRequest()));
                    }
                    $product->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d record(s) were successfully set as cross-sells by products('.$productIds2List.').', count($productIds)));
            } catch (Exception $e) 
            {
                $this->_getSession()->addError($e->getMessage());
            }
        }else
        {
            $this->_getSession()->addError($this->__('Please select product(s)'));
        }
        $this->_redirect('*/*/index');
    }
    
    
    /**
     * This will unrelate related product's relations.
     **/     
    public function massCrossSellClearAction() 
    {
        $productIds = $this->getRequest()->getParam('product');
        if (is_array($productIds)) 
        {
            try {
                foreach ($productIds as $productId) 
                {
                    $product = Mage::getModel('catalog/product')->load($productId);
                    $product->setCrossSellLinkData(array());
                    if ($this->massactionEventDispatchEnabled)
                    {
                        Mage::dispatchEvent('catalog_product_prepare_save', array('product' => $product, 'request' => $this->getRequest()));
                    }
                    $product->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d record(s) now have no products as cross sell links.', count($productIds)));
            } catch (Exception $e) 
            {
                $this->_getSession()->addError($e->getMessage());
            }
        }else
        {
            $this->_getSession()->addError($this->__('Please select product(s)'));
        }
        $this->_redirect('*/*/index');
    }
    
    
    
    
    
    /***************************************************************************
     ** Up-Selling
     **************************************************************************/  
    
    
    /** 
     * This will relate all products to a specifc list of products 
     **/
    public function massUpSellToAction()
    {
        $productIds = $this->getRequest()->getParam('product');
        $productIds2List = $this->getRequest()->getParam('callbackval');
        $productIds2 = explode(',', $productIds2List);
        
        if (is_array($productIds)) 
        {
            try {
                foreach ($productIds as $productId) 
                {
                    $product = Mage::getModel('catalog/product')->load($productId);
                    $link = $this->getRelatedLinks($productIds2, $product->getUpSellProducts(), $productId);
                    $product->setUpSellLinkData($link);
                    
                    if ($this->massactionEventDispatchEnabled)
                    {
                        Mage::dispatchEvent('catalog_product_prepare_save', array('product' => $product, 'request' => $this->getRequest()));
                    }
                    $product->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d record(s) are now up-sold by products('.$productIds2List.').', count($productIds)));
            } catch (Exception $e) 
            {
                $this->_getSession()->addError($e->getMessage());
            }
        }else
        {
            $this->_getSession()->addError($this->__('Please select product(s)'));
        }
        $this->_redirect('*/*/index');
    }
    
    
    
    /**
     * This will unrelate related product's relations.
     **/
    public function massUpSellClearAction() 
    {
        $productIds = $this->getRequest()->getParam('product');
        if (is_array($productIds)) 
        {
            try {
                foreach ($productIds as $productId) 
                {
                    $product = Mage::getModel('catalog/product')->load($productId);
                    $product->setUpSellLinkData(array());
                    if ($this->massactionEventDispatchEnabled)
                    {
                        Mage::dispatchEvent('catalog_product_prepare_save', array('product' => $product, 'request' => $this->getRequest()));
                    }
                    $product->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d record(s) now have 0 up-sells', count($productIds)));
            } catch (Exception $e) 
            {
                $this->_getSession()->addError($e->getMessage());
            }
        }else
        {
            $this->_getSession()->addError($this->__('Please select product(s)'));
        }
        $this->_redirect('*/*/index');
    }

}