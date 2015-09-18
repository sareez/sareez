<?php

class Int_Measurementadmin_Block_Measurement_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('measurementadminGrid');
      $this->setDefaultSort('style_id');
      $this->setDefaultDir('DESC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('measurementadmin/measurementstyle')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('style_id', array(
          'header'    => Mage::helper('measurementadmin')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'style_id',
      ));

      $this->addColumn('style_name', array(
          'header'    => Mage::helper('measurementadmin')->__('Style Name'),
          'align'     =>'left',
          'index'     => 'style_name',
      ));
      
      $this->addColumn('style_category', array(
          'header'    => Mage::helper('measurementadmin')->__('Style Cactegory'),
          'align'     =>'left',
          'index'     => 'style_category',
      ));
      
      $this->addColumn('style_for', array(
          'header'    => Mage::helper('measurementadmin')->__('Style For'),
          'align'     =>'left',
          'index'     => 'style_for',
      ));
      
      $this->addColumn('status', array(
          'header'    => Mage::helper('measurement')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              2 => 'Disabled',
          ),
      ));
  	 
      $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('measurementadmin')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('measurementadmin')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('measurementadmin')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('measurementadmin')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('style_id');
        $this->getMassactionBlock()->setFormFieldName('measurement');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('measurementadmin')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('measurementadmin')->__('Are you sure?')
        ));
		
        $statuses = Mage::getSingleton('measurementadmin/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('measurementadmin')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('measurementadmin')->__('Status'),
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
