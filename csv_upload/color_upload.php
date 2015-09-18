<?php require_once '../app/Mage.php';Mage::app(); ?>
<?php
$conn = mysql_connect("localhost","root","rootwdp") or die("ERROR::Not connected to SERVER"); 
$db = mysql_select_db("sareees_db",$conn) or die("ERROR::Not connected to DATABASE");



require_once('excel_reader/excel_reader.php');
$excel = new PhpExcelReader;
$excel->read('customer_excel/products.xls');
$excel_data = $excel->sheets;
/* echo "<pre>";
print_r($excel_data);
echo "</pre>"; */

foreach($excel_data[0]['cells'] as $sareez_colors)
{
	 //$inserted_colors = array();
	 
	 	$inserted_data= mysql_query("SELECT DISTINCT(a.value) from eav_attribute_option_value a INNER JOIN eav_attribute_option b ON a.option_id = b.option_id WHERE b.attribute_id = 182");
		while($colors = mysql_fetch_assoc($inserted_data))
		{
			$inserted_colors[] = $colors['value'];
		}

		if(!strrchr($sareez_colors[1],"and")){
			$split_color = $sareez_colors[1];
			if(!in_array(trim($split_color), $inserted_colors))
			{
				$arg_attribute = 'color';
				$arg_value = $split_color;

				$attr_model = Mage::getModel('catalog/resource_eav_attribute');
				$attr = $attr_model->loadByCode('catalog_product', $arg_attribute);
				$attr_id = $attr->getAttributeId();

				$option['attribute_id'] = $attr_id;
				$option['value']['any_option_name'][0] = trim($arg_value);
				$option['value']['any_option_name'][1] = trim($arg_value);

				$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
				$setup->addAttributeOption($option);
				//echo $split_color."<br/>";
			}
			else
			{
				echo $split_color."<----Inserted---->"."<br/>";
			}
			
		} else {
		$split_colors = explode('and', $sareez_colors[1]);
		foreach($split_colors as $split_colora)
		{
			$split_color = $split_colora;
			if(!in_array(trim($split_color), $inserted_colors))
			{
				$arg_attribute = 'color';
				$arg_value = $split_color;

				$attr_model = Mage::getModel('catalog/resource_eav_attribute');
				$attr = $attr_model->loadByCode('catalog_product', $arg_attribute);
				$attr_id = $attr->getAttributeId();

				$option['attribute_id'] = $attr_id;
				$option['value']['any_option_name'][0] = trim($arg_value);
				$option['value']['any_option_name'][1] = trim($arg_value);

				$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
				$setup->addAttributeOption($option);
				//echo $split_color."<br/>";
			}
			else
			{
				echo $split_color."<----Inserted---->"."<br/>";
			}
		}
		}
 /* 		$split_colors = explode('and', $sareez_colors[1]);
		foreach($split_colors as $split_color)
		{
			//$split_color = $split_colora;
			if(!in_array($split_color, $inserted_colors))
			{
				echo $split_color."<br/>";
			}
			else
			{
				echo $split_color."<----Inserted---->"."<br/>";
			} */
//}
}

/* $arg_attribute = 'color';
$arg_value = 'Byzantium Purple';

$attr_model = Mage::getModel('catalog/resource_eav_attribute');
$attr = $attr_model->loadByCode('catalog_product', $arg_attribute);
$attr_id = $attr->getAttributeId();

$option['attribute_id'] = $attr_id;
$option['value']['any_option_name'][0] = $arg_value;
$option['value']['any_option_name'][1] = $arg_value;

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$setup->addAttributeOption($option); */
?>