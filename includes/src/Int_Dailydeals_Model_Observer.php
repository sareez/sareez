<?php class Int_Dailydeals_Model_Observer
    {
        public function modifyPrice(Varien_Event_Observer $obs)
        {
		
		
            // Get the quote item
            $item = $obs->getQuoteItem();
			//echo "<pre>";
			//var_dump($item);
            // Ensure we have the parent item, if it has one
            $item = ( $item->getParentItem() ? $item->getParentItem() : $item );
            // Load the custom price
           $price = $this->_getPriceByItem($item);
			 $qty = $this->_getQtyByItem($item);
			 //$price = "5.00";
		
            // Set the custom price
            $item->setCustomPrice($price);
            $item->setOriginalCustomPrice($price);
            // Enable super mode on the product.
            $item->getProduct()->setIsSuperMode(true);
        }
        
        protected function _getPriceByItem(Mage_Sales_Model_Quote_Item $item)
        {
            $price;			
           $item_list=$item->getData();
			$id=$item_list['product_id'];
			$enable=Mage::getStoreConfig('dailydeals/dailydeals_settings/enabled');
			$collectiondeal=Mage::getModel('dailydeals/dailydeals')->getCollection()->addFieldToFilter('related_product',$id)->addFieldToFilter('deal_status','Running')->getData();
			
			
			if(!empty($collectiondeal) && $enable==1){
				
			$deal_price=$collectiondeal[0]['deal_price'];
			$deal_qty=$collectiondeal[0]['deal_qty'];	
			return $deal_price;
			}
			
			
			
        }
		
		protected function _getQtyByItem(Mage_Sales_Model_Quote_Item $item)
        {
           		
           $item_list=$item->getData();
		   
		  
		  $qty=$item_list['qty'];
		  /*
			$id=$item_list['product_id'];
			$model=Mage::getModel('dailydeals/dailydeals');
			
			$collectiondeal=Mage::getModel('dailydeals/dailydeals')->getCollection()->addFieldToFilter('related_product',$id)->getData();
			if(!empty($collectiondeal)){
			$deal_qty=$collectiondeal[0]['deal_qty'];	
			$deal_id=$collectiondeal[0]['dailydeals_id'];			
			$remaining_qty=$deal_qty-$qty;
			$deal_id=$collectiondeal[0]['dailydeals_id'];
			$data['qty_sold']=$qty;
			$data['remaining_qty']=$remaining_qty;			
			$model->setData($data)->setId($deal_id);
			$model->save();
			return $remaining_qty;
			}*/
			return $qty;
        }
        
		
		public function loaddeal()
        {
		 
		 //echo "hi"; die();
		 
		 $today = date('Y-m-d H:i:s');
		 
		 $collectiondeal=Mage::getModel('dailydeals/dailydeals')->getCollection()->getData();
		/* 
		echo "<pre>";
		 print_r($collectiondeal);
		 die(); 
		*/
		foreach($collectiondeal as $each) {
		
		if(trim($each['deal_status'])!='Disabled') {
		
			$todate =  $each['date_start'];
			$fromdate = $each['date_end'];
			
			$read = Mage::getSingleton('core/resource')->getConnection('core_read');
			$query=$read->fetchAll("SELECT TIMEDIFF( '".$fromdate."' , '".$today."') AS diff");
			
			//echo "SELECT TIMEDIFF( '".$fromdate."' , '".$today."') AS diff";
			
			 $diff=$query[0]['diff'];
			//echo "<br/>";
			
			if($diff < 0) {
			
			//echo $each['orgsplprice'];
			
			$dailydealsId = $each['dailydeals_id'];
			
			$product = $each['related_product'];
			$_pro = Mage::getModel('catalog/product')->load($product);
			$_pro->setspecial_price($each['orgsplprice']);
			//$_pro->save();
		
			$dailydeals = Mage::getSingleton('dailydeals/dailydeals')
			->load($dailydealsId)
			->setStatus('0')
			->setdeal_status('Disabled')
			->save();
			
			}
		}
	}	 
	}
		
		
        
    }
	?>