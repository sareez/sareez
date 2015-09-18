<?php
class Sn_Sorder_Block_Adminhtml_Sorder_Grid_Renderer_Tentativedate extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
 
 


 public function render(Varien_Object $row)
    { 
	 $today = date("Y-m-d 23:59:59");
	 
	 $value = $row->getData('tentative_date');
	 
	 $value1 = date("M d,Y" ,strtotime($value));
	 $allocationstatus_id = $row->getData('allocationstatus_id');
	
if($allocationstatus_id==1 && $value <= $today && $value!= '0000-00-00 00:00:00'){
return '<div style="color:#FFF;font-weight:bold;background:#ff0000;border-radius:8px;width:76%;padding-left: 16px;">'.$value1.'</div>';
}else if($allocationstatus_id==2 && $value <= $today && $value!= '0000-00-00 00:00:00'){
return '<div style="color:#FFF;font-weight:bold;background:#008000;border-radius:8px;width:76%;padding-left: 16px;">'.$value1.'</div>';
}
else if($value == '0000-00-00 00:00:00'){
return '<div> - - - </div>';
}
else{
return '<div>'.$value1.'</div>';
	}

	
	
	
	
    }

 
}
?>


