<?php
/**
* 
* Do not edit or add to this file if you wish to upgrade the module to newer
* versions in the future. If you wish to customize the module for your 
* needs please contact us to https://www.milople.com/magento-extensions/contact-us.html 
* 
* @category    Ecommerce
* @package     Indies_Whatsappshare
* @copyright   Copyright (c) 2015 Milople Technologies Pvt. Ltd. All Rights Reserved.
* @url	       https://www.milople.com/magento-extensions/whatsapp-share.html
*
* Milople was known as Indies Services earlier.
*
*/
class Indies_Whatsappshare_Block_Adminhtml_Whatsappshare_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('whatsappshareGrid');
      $this->setDefaultSort('whatsappshare_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('whatsappshare/whatsappshare')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('whatsappshare_id', array(
          'header'    => Mage::helper('whatsappshare')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'whatsappshare_id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('whatsappshare')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));

	  /*
      $this->addColumn('content', array(
			'header'    => Mage::helper('whatsappshare')->__('Item Content'),
			'width'     => '150px',
			'index'     => 'content',
      ));
	  */

      $this->addColumn('status', array(
          'header'    => Mage::helper('whatsappshare')->__('Status'),
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
                'header'    =>  Mage::helper('whatsappshare')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('whatsappshare')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('whatsappshare')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('whatsappshare')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('whatsappshare_id');
        $this->getMassactionBlock()->setFormFieldName('whatsappshare');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('whatsappshare')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('whatsappshare')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('whatsappshare/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('whatsappshare')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('whatsappshare')->__('Status'),
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