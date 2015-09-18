<?php

class Int_Dailydeals_Block_Adminhtml_Dailydeals_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('dailydealsGrid');
      $this->setDefaultSort('dailydeals_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('dailydeals/dailydeals')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('dailydeals_id', array(
          'header'    => Mage::helper('dailydeals')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'dailydeals_id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('dailydeals')->__('Deal Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));
	  
	      $this->addColumn('related_product', array(
          'header'    => Mage::helper('dailydeals')->__('Product Title'),
          'align'     =>'left',
          'index'     => 'related_product',
		  'renderer'  => 'Int_Dailydeals_Block_Adminhtml_Dailydeals_Renderer_Productname',
		  
      ));
	  
	  $this->addColumn('related_product1', array(
          'header'    => Mage::helper('dailydeals')->__('Product SKU'),
          'align'     =>'left',
          'index'     => 'related_product',
		  'renderer'  => 'Int_Dailydeals_Block_Adminhtml_Dailydeals_Renderer_Productsku',
		  
      ));
	  
	   $this->addColumn('store_id', array(
          'header'    => Mage::helper('dailydeals')->__('Available Stores'),
          'align'     =>'left',
          'index'     => 'store_id',
		  'renderer'  => 'Int_Dailydeals_Block_Adminhtml_Dailydeals_Renderer_Store',
      ));
	  
	    $this->addColumn('deal_price', array(
          'header'    => Mage::helper('dailydeals')->__('Deal Price'),
          'align'     =>'left',
          'index'     => 'deal_price',
      ));
	  
	    $this->addColumn('deal_qty', array(
          'header'    => Mage::helper('dailydeals')->__('Deal Quantity'),
          'align'     =>'left',
          'index'     => 'deal_qty',
      ));
	  
	    $this->addColumn('date_start', array(
          'header'    => Mage::helper('dailydeals')->__('Date/Time Form'),
          'align'     =>'left',
          'index'     => 'date_start',
		  'type' => 'time',
      ));
	  
	    $this->addColumn('date_end', array(
          'header'    => Mage::helper('dailydeals')->__('Date/Time To'),
          'align'     =>'left',
          'index'     => 'date_end',
		  'type' => 'time',
      ));
$this->addColumn('qty_sold', array(
          'header'    => Mage::helper('dailydeals')->__('Quantity Sold'),
          'align'     =>'left',
          'index'     => 'qty_sold',
      ));
	
	  /*
      $this->addColumn('content', array(
			'header'    => Mage::helper('dailydeals')->__('Item Content'),
			'width'     => '150px',
			'index'     => 'content',
      ));
	  */
$this->addColumn('viewer', array(
          'header'    => Mage::helper('dailydeals')->__('No.Of Views'),
          'align'     =>'left',
          'index'     => 'dailydeals_id',
		  'renderer'  => 'Int_Dailydeals_Block_Adminhtml_Dailydeals_Renderer_Viewercount',
		  
      ));
	  
	  
     $this->addColumn('deal_status', array(
          'header'    => Mage::helper('dailydeals')->__('Deal Status'),
          'align'     =>'left',
          'index'     => 'deal_status',
      ));

        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('dailydeals')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('dailydeals')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                      'field'     => 'id'
                    ), 
					array(
                        'caption'   => Mage::helper('dailydeals')->__('Delete'),
                        'url'       => array('base'=> '*/*/delete'),
                      'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
	
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('dailydeals_id');
        $this->getMassactionBlock()->setFormFieldName('dailydeals');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('dailydeals')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('dailydeals')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('dailydeals/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('dailydeals')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('dailydeals')->__('Status'),
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