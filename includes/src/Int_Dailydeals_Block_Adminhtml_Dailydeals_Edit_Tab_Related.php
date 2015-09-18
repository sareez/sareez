<?php

class Int_Dailydeals_Block_Adminhtml_Dailydeals_Edit_Tab_Related extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('dailydeals_related');
		$this->setTemplate('dailydeals/widget/grid.phtml');
        $this->setDefaultSort('id');
        $this->setUseAjax(true);
    }

    protected function _addColumnFilterToCollection($column)
    {
        // Set custom filter for in category flag
        if ($column->getId() == 'related_product') {
            $productIds = $this->_getSelectedProducts();
            if (empty($productIds)) {
                $productIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', array('in' => $productIds));
            }
            elseif (!empty($productIds)) {
                $this->getCollection()->addFieldToFilter('entity_id', array('nin' => $productIds));
            }
        }
        else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    protected function _prepareCollection()
    {
    	$excludedealid = $this->getRequest()->getParam('id');
    	$collectiondeal = Mage::getModel('dailydeals/dailydeals')->getCollection();
    	foreach($collectiondeal as $each):
    	if($each['dailydeals_id'] != $excludedealid) {
    	$exclude[] = $each['related_product'];
    	}
    	endforeach;
    	
    	
    	
    	
        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('sku')
            ->addAttributeToSelect('price')
            ->addAttributeToSelect('status')
            ->addAttributeToSelect('visibility')
            ->addAttributeToFilter('visibility', '4');
        
        	if(!empty($exclude)) {
        	$collection->addIdFilter($exclude, true);
        	}
        	
            $collection->addStoreFilter($this->getRequest()->getParam('store'))
            ->joinField('position',
                        'catalog/category_product',
                        'position',
                        'product_id=entity_id',
                        'category_id=' . (int)$this->getRequest()->getParam('id', 0),
                        'left');
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
    	
        $this->addColumn('related_product', array(
			'header'    => Mage::helper('adminhtml')->__('related_product'),
            'header_css_class' => 'a-center',
            'type' => 'radio',
            'html_name' => 'related_product',           
            'values' => $this->_getSelectedProducts(),
            'align' => 'center',
            'index' => 'entity_id'
        ));

      /*  $this->addColumn('remove_related', array(
            'header' => Mage::helper('dailydeals')->__('Remove'),
            'sortable' => false,
            'header_css_class' => 'a-center',
            'type' => 'checkbox',
            'name' => 'remove_related',
            'field_name' => 'remove_related[]',
            'align' => 'center',
            'index' => 'entity_id'
        ));
*/
        $this->addColumn('entity_id', array(
            'header' => Mage::helper('dailydeals')->__('ID'),
            'sortable' => true,
            'width' => '60px',
            'index' => 'entity_id'
        ));
        
        $this->addColumn('name', array(
            'header' => Mage::helper('dailydeals')->__('Name'),
            'index' => 'name'
        ));
        $this->addColumn('sku', array(
            'header' => Mage::helper('dailydeals')->__('SKU'),
            'width' => '120px',
            'index' => 'sku'
        ));

        $this->addColumn('type', array(
            'header' => Mage::helper('dailydeals')->__('Type'),
            'width' => 100,
            'index' => 'type_id',
            'type' => 'options',
            'options' => Mage::getSingleton('catalog/product_type')->getOptionArray(),
        ));

        $sets = Mage::getResourceModel('eav/entity_attribute_set_collection')
            ->setEntityTypeFilter(Mage::getModel('catalog/product')->getResource()->getTypeId())
            ->load()
            ->toOptionHash();

        $this->addColumn('set_name', array(
            'header' => Mage::helper('dailydeals')->__('Attrib. Set Name'),
            'width' => 130,
            'index' => 'attribute_set_id',
            'type' => 'options',
            'options' => $sets,
        ));

        $this->addColumn('product_status', array(
            'header' => Mage::helper('dailydeals')->__('Status'),
            'width' => 90,
            'index' => 'status',
            'type' => 'options',
            'options' => Mage::getSingleton('catalog/product_status')->getOptionArray(),
        ));

        $this->addColumn('visibility', array(
            'header' => Mage::helper('dailydeals')->__('Visibility'),
            'width' => 90,
            'index' => 'visibility',
            'type' => 'options',
            'options' => Mage::getSingleton('catalog/product_visibility')->getOptionArray(),
        ));

        $this->addColumn('price', array(
            'header' => Mage::helper('dailydeals')->__('Price'),
            'type' => 'currency',
            'currency_code' => (string)Mage::getStoreConfig(Mage_Directory_Model_Currency::XML_PATH_CURRENCY_BASE),
            'index' => 'price'
        ));
        $this->addColumn('position', array(
            'header' => Mage::helper('dailydeals')->__('Position'),
            'name' => 'position',
            'type' => 'number',
            'validate_class' => 'validate-number',
            'index' => 'position',
            'width' => '60px',
            'editable' => true,
        ));

        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
       return $this->getUrl('*/adminhtml_related/index', array('_current' => true));
    }

    protected function _getProduct()
    {
        return Mage::registry('dailydeals_data');
    }

    protected function _getSelectedProducts()
    {
    	
    	$deal_id = $this->getRequest()->getParam('id');
    	$deal = Mage::getModel('dailydeals/dailydeals')->load($deal_id )->getData();
    	
    	$dealproduct[] = $deal['related_product'];
    	
    	return $dealproduct;
    	
        
    }
}
