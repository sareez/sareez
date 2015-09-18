<?php
class Sn_Sorder_Block_Adminhtml_Sorder_Grid_Renderer_Allocationstatus extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
 public function render(Varien_Object $row)
    {  
	
	 $value = $row->getData('allocationstatus_id');
	if($value==0){
		$value1 = "- - -";
return '<div>'.$value1.'</div>';
		
	}elseif($value==1){
		 $colour = "FFFF00";
		$value1 = "Processing";
return '<div style="color:#000;font-weight:bold;background:#'.$colour.';border-radius:8px;width:76%;padding-left: 16px;">'.$value1.'</div>';
		
	}elseif($value==2){
		$colour = "00FF00";
		$value1 = "Complete";
return '<div style="color:#000;font-weight:bold;background:#'.$colour.';border-radius:8px;width:76%;padding-left: 16px;">'.$value1.'</div>';

		
	}elseif($value==3){
		$colour = "FF0000";
		$value1 = "Cancel";
return '<div style="color:#000;font-weight:bold;background:#'.$colour.';border-radius:8px;width:76%;padding-left: 16px;">'.$value1.'</div>';
	}
	elseif($value==4){
		$value1 = "Order Placed";
return '<div style="color:#000;font-weight:bold;border-radius:8px;width:76%;padding-left: 16px;">'.$value1.'</div>';
	}elseif($value==5){
		$colour = "FF846B";
		$value1 = "Replacement";
return '<div style="color:#000;font-weight:bold;background:#'.$colour.';border-radius:8px;width:76%;padding-left: 16px;">'.$value1.'</div>';
	}
	elseif($value==6){
		$value1 = "Do not Ship";
return '<div style="color:#000;font-weight:bold;border-radius:8px;width:76%;padding-left: 16px;">'.$value1.'</div>';
	}
	elseif($value==7){
		$value1 = "Delay";
return '<div style="color:#000;font-weight:bold;border-radius:8px;width:76%;padding-left: 16px;">'.$value1.'</div>';
	}
	elseif($value==8){
		$value1 = "Not Allocated";
return '<div style="color:#000;font-weight:bold;border-radius:8px;width:76%;padding-left: 16px;">'.$value1.'</div>';
	}
	
    }
}
?>
