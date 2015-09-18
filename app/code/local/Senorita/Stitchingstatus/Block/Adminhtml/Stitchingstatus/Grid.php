<?php

class Senorita_Stitchingstatus_Block_Adminhtml_Stitchingstatus_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('stitchingstatusGrid');
      $this->setDefaultSort('stitchingstatus_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('stitchingstatus/stitchingstatus')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('stitchingstatus_id', array(
          'header'    => Mage::helper('stitchingstatus')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'stitchingstatus_id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('stitchingstatus')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));
	  
	  $this->addColumn('color', array(
          'header'    => Mage::helper('stitchingstatus')->__('Color Code#'),
          'align'     =>'left',
          'index'     => 'color',
      ));

	  /*
      $this->addColumn('content', array(
			'header'    => Mage::helper('stitchingstatus')->__('Item Content'),
			'width'     => '150px',
			'index'     => 'content',
      ));
	  */

      $this->addColumn('status', array(
          'header'    => Mage::helper('stitchingstatus')->__('Status'),
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
                'header'    =>  Mage::helper('stitchingstatus')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('stitchingstatus')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('stitchingstatus')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('stitchingstatus')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('stitchingstatus_id');
        $this->getMassactionBlock()->setFormFieldName('stitchingstatus');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('stitchingstatus')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('stitchingstatus')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('stitchingstatus/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('stitchingstatus')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('stitchingstatus')->__('Status'),
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