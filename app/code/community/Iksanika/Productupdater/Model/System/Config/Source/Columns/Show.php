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

class Iksanika_Productupdater_Model_System_Config_Source_Columns_Show
{
    public function toOptionArray()
    {
        $columns = array(
            array(
                'value' => 'id',   
                'label' => __('ID')
            ),
            array(
                'value' => 'type_id',   
                'label' => __('Type (simple, bundle, etc)')
            ),
            array(
                'value' => 'attribute_set_id',   
                'label' => _('Attribute Set')
            ),
            array(
                'value' => 'qty',   
                'label' => __('Quantity')
            ),
            array(
                'value' => 'is_in_stock',   
                'label' => __('Is in Stock')
            ),
            array(
                'value' => 'websites',   
                'label' => __('Websites')
            ),
            array(
                'value' => 'category_ids',   
                'label' => __('Category ID\'s')
            ),
            array(
                'value' => 'price_percentage',   
                'label' => __('Updater: Price (in Percent)')
            ),
            array(
                'value' => 'special_price_percentage',   
                'label' => __('Updater: Special Price (in Percent)')
            ),
            array(
                'value' => 'cost_percentage',   
                'label' => __('Updater: Cost (in Percent)')
            ),
            array(
                'value' => 'msrp_percentage',   
                'label' => __('Updater: MSRP (in Percent)')
            ),
            array(
                'value' => 'related_ids',   
                'label' => __('Related: Relative Products IDs')
            ),
            array(
                'value' => 'cross_sell_ids',   
                'label' => __('Related: Cross-Sell Products IDs')
            ),
            array(
                'value' => 'up_sell_ids',   
                'label' => __('Related: Up-Sell Products IDs')
            ),
        );
        
        $columnsCollection = 
            Mage::getResourceModel('eav/entity_attribute_collection')
            ->setEntityTypeFilter( Mage::getModel('eav/entity')->setType('catalog_product')->getTypeId() )
	    ->addFilter("is_visible", 1);

        foreach($columnsCollection->getItems() as $column) 
        {
            $columns[] = array(
                'value' => $column->getAttributeCode(),   
                'label' => $column->getFrontendLabel()
            );
        }
        
        return $columns;
    }
}