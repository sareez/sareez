<?php
class Sn_Sorder_Block_Adminhtml_Sorder_Grid_Renderer_Manufacturers extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
 
 


 public function render(Varien_Object $row)
    {  
	
	 $value = $row->getData('stitchingstatus_id');
	
	//return '<div style="color:#FFF;font-weight:bold;background:#'.$colour.';border-radius:8px;width:76%;padding-left: 16px;">'.$value.'</div>';
	
	if($value==0){
		$value1 = "- - -";
return '<div>'.$value1.'</div>';
		
	}elseif($value==1){
		 $colour = "14EFFF";
		$value1 = "Send For Stitching";
return '<div style="color:#FFF;font-weight:bold;background:#'.$colour.';border-radius:8px;width:76%;padding-left: 16px;">'.$value1.'</div>';
		
	}elseif($value==2){
		$colour = "B7E620";
		$value1 = "Received";
return '<div style="color:#FFF;font-weight:bold;background:#'.$colour.';border-radius:8px;width:76%;padding-left: 16px;">'.$value1.'</div>';

		
	}elseif($value==3){
		$colour = "2998BA";
		$value1 = "Product is on hold due to stitching issue";
return '<div style="color:#FFF;font-weight:bold;background:#'.$colour.';border-radius:8px;width:76%;padding-left: 16px;">'.$value1.'</div>';

		
	}elseif($value==5){
		$colour = "914DF7";
		$value1 = "Cst Donot Want Stitching";
return '<div style="color:#FFF;font-weight:bold;background:#'.$colour.';border-radius:8px;width:76%;padding-left: 16px;">'.$value1.'</div>';

		
	}elseif($value==6){
		$colour = "E53DFF";
		$value1 = "Awaiting cst reply";
return '<div style="color:#FFF;font-weight:bold;background:#'.$colour.';border-radius:8px;width:76%;padding-left: 16px;">'.$value1.'</div>';

		
	}elseif($value==7){
		$colour = "FFA33B";
		$value1 = "Measurement Not Received";
return '<div style="color:#FFF;font-weight:bold;background:#'.$colour.';border-radius:8px;width:76%;padding-left: 16px;">'.$value1.'</div>';

		
	}elseif($value==8){
		$colour = "B7E620";
		$value1 = "Stitching Not Required";
return '<div style="color:#FFF;font-weight:bold;background:#'.$colour.';border-radius:8px;width:76%;padding-left: 16px;">'.$value1.'</div>';

		
	}if($value==9){
		$colour = "914DF7";
		$value1 = "Measurement received";
return '<div style="color:#FFF;font-weight:bold;background:#'.$colour.';border-radius:8px;width:76%;padding-left: 16px;">'.$value1.'</div>';

		
	}elseif($value==10){
		$colour = "FF1F96";
		$value1 = "Remarks";
return '<div style="color:#FFF;font-weight:bold;background:#'.$colour.';border-radius:8px;width:76%;padding-left: 16px;">'.$value1.'</div>';

		
	}elseif($value==11){
		$colour = "DE0E0E";
		$value1 = "Cancel";
return '<div style="color:#FFF;font-weight:bold;background:#'.$colour.';border-radius:8px;width:76%;padding-left: 16px;">'.$value1.'</div>';

		
	}elseif($value==12){
		$colour = "702C0F";
		$value1 = "Check Latest Update";
return '<div style="color:#FFF;font-weight:bold;background:#'.$colour.';border-radius:8px;width:76%;padding-left: 16px;">'.$value1.'</div>';

		
	}elseif($value==13){
		$colour = "E85A72";
		$value1 = "Problem in measurement";
return '<div style="color:#FFF;font-weight:bold;background:#'.$colour.';border-radius:8px;width:76%;padding-left: 16px;">'.$value1.'</div>';

		
	}elseif($value==14){
		$colour = "3E8714";
		$value1 = "Ready to Ship";
return '<div style="color:#FFF;font-weight:bold;background:#'.$colour.';border-radius:8px;width:76%;padding-left: 16px;">'.$value1.'</div>';

		
	}elseif($value==15){
		$colour = "107543";
		$value1 = "Shipped";
return '<div style="color:#FFF;font-weight:bold;background:#'.$colour.';border-radius:8px;width:76%;padding-left: 16px;">'.$value1.'</div>';

		
	}
	
	
	
	
    }

 
}
?>


