<?php

class Wyomind_Orderseraser_Adminhtml_OrderseraserController extends Mage_Adminhtml_Controller_Action {

    public function getVersion() {
        return substr(Mage::getVersion(), 0, 3);
    }

   

    public function massDeleteAction() {

        $orderIds = $this->getRequest()->getPost('order_ids', array());
        $countDeleteOrder = 0;
        foreach ($orderIds as $orderId) {
            if (version_compare(Mage::getVersion(), '1.3.0', '<=') && Mage::getModel('orderseraser/orderseraser')->_erase1($orderId))
                $countDeleteOrder++;
            elseif (Mage::getModel('orderseraser/orderseraser')->_erase2($orderId))
			
			$order = Mage::getModel('sales/order')->load($orderId);
					$invoices = $order->getInvoiceCollection();
					foreach ($invoices as $invoice){
					$invoice->delete();
					}
					$creditnotes = $order->getCreditmemosCollection();
					foreach ($creditnotes as $creditnote){
					$creditnote->delete();
					}
					$shipments = $order->getShipmentsCollection();
					foreach ($shipments as $shipment){
					$shipment->delete();
					}
					$order->delete();
					
					$transaction = Mage::getSingleton('core/resource')->getConnection('core_write');
					$transaction->query("DELETE FROM sales_flat_order_item_stitching WHERE order_id = '".$orderId."'");

			
                $countDeleteOrder++;
        }
        if ($countDeleteOrder > 0) {
            $this->_getSession()->addSuccess($this->__('%s order(s) successfully deleted', $countDeleteOrder));
        } else {
            $this->_getSession()->addError($this->__('Unable to delete orders.'));
        }
       
        $this->_redirect('adminhtml/sales_order/');
       
    }

    public function deleteAction() {

        if ($orderId = $this->getRequest()->getParam('order_id')) {
		
            try {

                if (version_compare(Mage::getVersion(), '1.3.0', '<='))
                    Mage::getModel('orderseraser/orderseraser')->_erase1($orderId);
                else
				
				$order = Mage::getModel('sales/order')->load($orderId);
					$invoices = $order->getInvoiceCollection();
					foreach ($invoices as $invoice){
					$invoice->delete();
					}
					$creditnotes = $order->getCreditmemosCollection();
					foreach ($creditnotes as $creditnote){
					$creditnote->delete();
					}
					$shipments = $order->getShipmentsCollection();
					foreach ($shipments as $shipment){
					$shipment->delete();
					}
					
					$transaction = Mage::getSingleton('core/resource')->getConnection('core_write');
					$transaction->query("DELETE FROM sales_flat_order_item_stitching WHERE order_id = '".$orderId."'");
				
					
					Mage::getModel('orderseraser/orderseraser')->_erase2($orderId);

                $this->_getSession()->addSuccess(
                        $this->__('Order was successfully deleted.')
                );
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addError($this->__('Unable to delete order.'));
            }
           
            $this->_redirect('adminhtml/sales_order/');
           
        }
    }

}