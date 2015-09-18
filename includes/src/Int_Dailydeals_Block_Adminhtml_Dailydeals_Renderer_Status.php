<?php
/**
 * aheadWorks Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://ecommerce.aheadworks.com/LICENSE-L.txt
 *
 * @category   AW
 * @package    AW_Blog
 * @copyright  Copyright (c) 2009-2010 aheadWorks Co. (http://www.aheadworks.com)
 * @license    http://ecommerce.aheadworks.com/LICENSE-L.txt
 */

class Int_Dailydeals_Block_Adminhtml_Dailydeals_Renderer_Status extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
   public function render(Varien_Object $row)
	{
	
		$id=$row->getdailydeals_id();	
	
		
		
		 $coll= Mage::getModel('dailydeals/dailydeals')->load($id);
		$date_start= $coll->getdate_start();
		$date_end= $coll->getdate_end();	
		$deal_status=$coll->getstatus();
		$read = Mage::getSingleton('core/resource')->getConnection('core_read');
		$write = Mage::getSingleton('core/resource')->getConnection('core_write');
		$query=$read->fetchAll("SELECT TIMEDIFF( NOW( ) , '".$date_start."') AS diff");
		$query1=$read->fetchAll("SELECT TIMEDIFF('".$date_end."', NOW( )) AS diffend");
		$compdate=$query[0]['diff'];
		$compdateend=$query1[0]['diffend'];
		
		if($deal_status==0){		
		$status='Disabled';
		}elseif($compdate <0){
		$status='Queued';
		}elseif($compdate>=0 && $compdateend>0 ){
		$status='Running';
		}elseif($compdateend <0){
		$status='Ended';
		}
		
	
		//$data['deal_status']=$status; 
		//$model = Mage::getModel('dailydeals/dailydeals');		
			//$model->setData($data)
				//->setId(2);
				//$model->save();
		return $status;
		
	 
	}
}
