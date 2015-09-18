<?php

class Int_Dailydeals_Block_Adminhtml_Dailydeals_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('dailydeals_form', array('legend'=>Mage::helper('dailydeals')->__('Item information')));
	  
	 $id     = $this->getRequest()->getParam('id');
	  if($id){
	$model  = Mage::getModel('dailydeals/dailydeals')->load($id);
	$pro_id=$model['related_product'];
	$collection=Mage::getModel('catalog/product')->load($pro_id);
	$name=$collection['name'];
	$price=$collection['price'];
	//echo $url=$collection->getUrlPath();
	$url= Mage::helper("adminhtml")->getUrl("adminhtml/catalog_product/edit/",array("id"=>$pro_id));
	$stocklevel = (int)Mage::getModel('cataloginventory/stock_item')->loadByProduct($collection)->getQty();
 
	
	$qty1=$collection->getqty();
	//echo "<pre>";
	//print_r($collection);
	   $fieldset->addField('req_text', 'note', array(
	      'label'     => Mage::helper('dailydeals')->__('Product Name'),
           'text' => '<span id="prod_name">'.$name.'</span>'
       ));
	   
	    $fieldset->addField('req_text1', 'note', array(
	      'label'     => Mage::helper('dailydeals')->__('Product Price'),
           'text' => '<span id="prod_price">'.$price.'</span>'
       ));
	   
	    $fieldset->addField('req_text3', 'note', array(
	      'label'     => Mage::helper('dailydeals')->__('Product Quantity'),
           'text' => '<span id="prod_qty">'.$stocklevel.'</span>'
       ));
	     $fieldset->addField('req_text2', 'note', array(
	       'text' => '<script type="text/javascript"> function showdiv() { jQuery("#dailydeals_tabs_form_section1_content").show(); jQuery("#dailydeals_tabs_form_section_content").hide(); jQuery("#dailydeals_tabs_form_section1").addClass("active"); jQuery("#dailydeals_tabs_form_section").removeClass("active");  } </script><span><a onclick="showdiv();" href="javascript:void(0);">Change Product</a> || <a href="'.$url.'">Edit Product</a></span>'
       ));
	   }
     
	  $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('dailydeals')->__('Deal Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));
	 
      $fieldset->addField('deal_price', 'text', array(
          'label'     => Mage::helper('dailydeals')->__('Deal Price'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'deal_price',
      ));
	  
	     $fieldset->addField('deal_qty', 'text', array(
          'label'     => Mage::helper('dailydeals')->__('Deal Qty'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'deal_qty',
      ));
	  
	    
	 

	  $fieldset->addField('date_start', 'date', array(
		'label'     => Mage::helper('dailydeals')->__('Date/Time From'),		
		'tabindex' => 1,
		'image' => $this->getSkinUrl('images/grid-cal.gif'),
		'name'      => 'date_start',
		'time' => true,
		'input_format' => 'yyyy/M/d h:mm a',
		'format' => 'yyyy/M/d h:mm a' 
	));  
	   $fieldset->addField('date_end', 'date', array(
		'label'     => Mage::helper('dailydeals')->__('Date/Time To'),		
		'tabindex' => 1,
		'image' => $this->getSkinUrl('images/grid-cal.gif'),
		'name'      => 'date_end',
		'time' => true,
		'input_format' => 'yyyy/M/d h:mm a',
		'format' => 'yyyy/M/d h:mm a'
	));  
	
	
	
	/*
	if (!Mage::app()->isSingleStoreMode()) {
   $fieldset->addField('store_id', 'multiselect', array(
           'name'      => 'stores[]',
           'label'     => Mage::helper('dailydeals')->__('Run on Store'),
           'title'     => Mage::helper('dailydeals')->__('Run on Store'),
           'required'  => true,
           'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
   ));
  } else {
   $fieldset->addField('store_id', 'hidden', array(
           'name'      => 'stores[]',
           'value'     => Mage::app()->getStore(true)->getId(),
   ));
   $model->setStoreId(Mage::app()->getStore(true)->getId());
  }
	*/
	  
            $fieldset->addField('store_id', 'multiselect', array(
                'name'      => 'stores[]',
                'label'     => Mage::helper('cms')->__('Store View'),
                'title'     => Mage::helper('cms')->__('Store View'),
                'required'  => true,
                'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
            ));
     
	
	
	
	  
	        $fieldset->addField('product_disable', 'select', array(
				'label'     => Mage::helper('dailydeals')->__('Disable product after deal ends'),
				'name'      => 'product_disable',
				'values'    => array(
				array(
				'value'     => 1,
				'label'     => Mage::helper('dailydeals')->__('Yes'),
				),

				array(
				'value'     => 2,
				'label'     => Mage::helper('dailydeals')->__('No'),
				),
				),
			));
	  
	
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('dailydeals')->__('Deal Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('dailydeals')->__('Enabled'),
              ),

              array(
                  'value'     => 0,
                  'label'     => Mage::helper('dailydeals')->__('Disabled'),
              ),
          ),
      ));
     

     
      if ( Mage::getSingleton('adminhtml/session')->getDailydealsData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getDailydealsData());
          Mage::getSingleton('adminhtml/session')->setDailydealsData(null);
      } elseif ( Mage::registry('dailydeals_data') ) {
          $form->setValues(Mage::registry('dailydeals_data')->getData());
      }
      return parent::_prepareForm();
  }
}