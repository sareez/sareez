<?php
class Dolphin_Productqa_Block_Productqa extends Mage_Core_Block_Template
{
	public function __construct()
    {
		parent::__construct();
		$productsku = $this->getRequest()->getParam('ps'); 
        $collection = Mage::getModel('productqa/productqa')->getCollection()
			  ->addFieldToFilter('product_sku',$productsku)	
			  ->addFieldToFilter('status',1)
        	  ->setOrder('productqa_id', 'DESC');
		$this->setCollection($collection);
    }
 
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
 
        $pager = $this->getLayout()->createBlock('page/html_pager', 'custom.pager');
        $pager->setAvailableLimit(array(5=>5,10=>10,15=>15,20=>20,25=>25,'all'=>'all'));
        $pager->setCollection($this->getCollection());
        $this->setChild('pager', $pager);
		$this->getCollection()->load();
        return $this;
    }
 
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
	
	
	
}