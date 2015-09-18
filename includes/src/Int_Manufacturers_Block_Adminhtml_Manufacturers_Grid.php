<?php

class Int_Manufacturers_Block_Adminhtml_Manufacturers_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('manufacturersGrid');
      $this->setDefaultSort('manufacturers_name');
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
	      $collection = Mage::getModel('manufacturers/manufacturers')->getCollection();
	  
	  
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
      $this->addColumn('manufacturers_id', array(
          'header'    => Mage::helper('manufacturers')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'manufacturers_id',
      ));

      $this->addColumn('manufacturers_name', array(
          'header'    => Mage::helper('manufacturers')->__('Title'),
          'align'     =>'left',
          'index'     => 'manufacturers_name',
      ));
	  
	

	
    //  $this->addColumn('content', array(
		//	'header'    => Mage::helper('manufacturers')->__('Item Content'),
			//'width'     => '150px',
			//'index'     => 'content',
      //));
	 

      $this->addColumn('status', array(
          'header'    => Mage::helper('manufacturers')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              0 => 'Disabled',
          ),
      ));
	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('manufacturers')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('manufacturers')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('manufacturers')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('manufacturers')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('manufacturers_id');
        $this->getMassactionBlock()->setFormFieldName('manufacturers');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('manufacturers')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('manufacturers')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('manufacturers/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('manufacturers')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('manufacturers')->__('Status'),
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