<?php
class Int_Dailydeals_Adminhtml_RelatedController extends Mage_Adminhtml_Controller_Action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('dailydeals/related');
		
		return $this;
	}    
 
	public function indexAction() {

		$this->getResponse()->setBody(
            $this->getLayout()->createBlock('dailydeals/adminhtml_dailydeals_edit_tab_related')->toHtml()
        );
		
	}

	public function editAction() {
        //die(__FILE__);
    }
 }
