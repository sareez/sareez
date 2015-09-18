<?php

class Int_Catalogmaster_Block_Adminhtml_Producttype_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('catalogmasterGrid');
      $this->setDefaultSort('p_type_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }
  
  protected function _getStore() {
        $storeId = (int) $this->getRequest()->getParam('store', 0);
        return Mage::app()->getStore($storeId);
    }
 
  protected function _prepareCollection()
  {
  
	  $store = $this->_getStore();
	 
      $collection = Mage::getModel('catalogmaster/producttype')->getCollection();
	  
	  
	  if ($store->getId()) {
        	//$collection->addFieldToFilter('websites', array('eq' => $store->getId() ));
			$collection->addStoreFilter($store);
           // $collection->addStoreFilter($store);
        }
		
		
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('p_type_id', array(
          'header'    => Mage::helper('catalogmaster')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'p_type_id',
      ));
      
      $this->addColumn('abbreviation', array(
          'header'    => Mage::helper('catalogmaster')->__('Products Abbreviation'),
          'align'     =>'left',
          'index'     => 'abbreviation',
      ));
       
      $this->addColumn('type', array(
          'header'    => Mage::helper('catalogmaster')->__('Product Type'),
          'align'     =>'left',
          'index'     => 'type',
      ));
	  
	

	
    //  $this->addColumn('content', array(
		//	'header'    => Mage::helper('catalogmaster')->__('Item Content'),
			//'width'     => '150px',
			//'index'     => 'content',
      //));
	 

      $this->addColumn('type_status', array(
          'header'    => Mage::helper('catalogmaster')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'type_status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              0 => 'Disabled',
          ),
      ));
	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('catalogmaster')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('catalogmaster')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('catalogmaster')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('catalogmaster')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('catalogmaster_id');
        $this->getMassactionBlock()->setFormFieldName('catalogmaster');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('catalogmaster')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('catalogmaster')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('catalogmaster/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('catalogmaster')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('catalogmaster')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}