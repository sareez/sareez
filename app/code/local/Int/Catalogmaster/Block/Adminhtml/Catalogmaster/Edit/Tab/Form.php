<?php

class Int_Catalogmaster_Block_Adminhtml_Catalogmaster_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{


    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
    }
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('catalogmaster_form', array('legend'=>Mage::helper('catalogmaster')->__('Catalog Information')));
      
      
      
      /* manufacturer list */
     	$manufacturercollection = Mage::getModel('manufacturers/manufacturers')->getCollection()
								->addFieldToSelect('manufacturers_id')
								->addFieldToSelect('manufacturers_name')  							
								//->addFieldToFilter('status', 1)
								->setOrder('manufacturers_name','ASC')
								->getData();			
								
	$manufacturer_array = array();
	$count =1;
	  	foreach($manufacturercollection as $manufacturer)
		{
		$manufacturer_array[$count]['value']= $manufacturer['manufacturers_id'];
		$manufacturer_array[$count]['label']= $manufacturer['manufacturers_name'];
		$count++;
		}	
		
	$fieldset->addField('manufacturer_id', 'select', array(
	     'label'     => Mage::helper('catalogmaster')->__('Manufacturer'),
	     'required'  => true,	  
	     'name'      => 'manufacturer_id',
	     'values'    => $manufacturer_array,
	 ));
	
	 /* manufacturer list */ 
      
	$fieldset->addField('catalog_name', 'text', array(
	    'label'     => Mage::helper('catalogmaster')->__('Catalog Name'),
	    'class'     => 'required-entry',
	    'required'  => true,
	    'name'      => 'catalog_name',
	    ));
	  
	$fieldset->addField('no_of_products', 'text', array(
	    'label'     => Mage::helper('catalogmaster')->__('No Of Products'),
	    'class'     => 'required-entry',
	    'required'  => true,
	    'name'      => 'no_of_products',
	));
	
	
	 $fieldset->addField('catalog_description', 'textarea', array(
            'name'      => 'catalog_description',
            'label'     => Mage::helper('cms')->__('Catalog Description'),
            'title'     => Mage::helper('cms')->__('Catalog Description'),
            'style'     => 'height:16em',
            'required'  => true,
            'config'    => Mage::getSingleton('cms/wysiwyg_config')->getConfig()
        ));
	  
	/* producttype list */
     	$producttypecollection = Mage::getModel('catalogmaster/producttype')->getCollection()
								->addFieldToSelect('abbreviation')
								->addFieldToSelect('type')								
								//->addFieldToFilter('status', 1)
								->getData();			
								
	$producttype_array = array();
	$count =1;
	  	foreach($producttypecollection as $producttype)
		{
		$producttype_array[$count]['value']= $producttype['abbreviation'];
		$producttype_array[$count]['label']= $producttype['type'];
		$count++;
		}	
		
	$fieldset->addField('products_type', 'select', array(
	     'label'     => Mage::helper('catalogmaster')->__('Producttype'),
	      'required'  => true,	  
	     'name'      => 'products_type',
	     'values'    => $producttype_array,
	 ));
	
	 /* producttype list */ 
	
	
	
	    $fieldset->addField('price', 'select', array(
	    'label'     => Mage::helper('catalogmaster')->__('Price'),
	    'name'      => 'price',
	    'values'    => array(
		array(
		    'value'     => 1,
		    'label'     => Mage::helper('catalogmaster')->__('Yes'),
		),	    
		array(
		    'value'     => 0,
		    'label'     => Mage::helper('catalogmaster')->__('No'),
		),
	    ),
	    ));
	 
	  $fieldset->addField('fabric', 'select', array(
          'label'     => Mage::helper('catalogmaster')->__('Fabric'),
          'name'      => 'fabric',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('catalogmaster')->__('Yes'),
              ),

              array(
                  'value'     => 0,
                  'label'     => Mage::helper('catalogmaster')->__('No'),
              ),
          ),
      ));     
	  
	
		
/*      $fieldset->addField('catalog_cutt_off_time', 'text', array(
	    'label'     => Mage::helper('catalogmaster')->__('Cutt off time'),	  
	    'name'      => 'catalog_cutt_off_time',
	));*/
	
	

$fieldset->addField('catalog_cutt_off_time', 'date', array(
    'name'               => 'catalog_cutt_off_time',
    'label'              => Mage::helper('catalogmaster')->__('Cutt off time'),
    'image'              => $this->getSkinUrl('images/grid-cal.gif'),
    'format'             => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT) ,
	'required'  => true,
));


      
      
      $fieldset->addField('process_status', 'select', array(
          'label'     => Mage::helper('catalogmaster')->__('Status'),
          'name'      => 'process_status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('catalogmaster')->__('Enabled'),
              ),

              array(
                  'value'     => 0,
                  'label'     => Mage::helper('catalogmaster')->__('Disabled'),
              ),
          ),
      ));     
	  
      
      
      
      
    /*  
    $renderer = Mage::getBlockSingleton('adminhtml/widget_form_renderer_fieldset')->setTemplate('catalogmaster/product.phtml'); 	
    $fieldset = $form->addFieldset('quoteproduct_form1', array('legend'=>Mage::helper('catalogmaster')->__('Items informations')))->setRenderer($renderer);
    */
          
     
    
     
      if ( Mage::getSingleton('adminhtml/session')->getCatalogmasterData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getCatalogmasterData());
          Mage::getSingleton('adminhtml/session')->setCatalogmasterData(null);
      } elseif ( Mage::registry('catalogmaster_data') ) {
          $form->setValues(Mage::registry('catalogmaster_data')->getData());
      }
      return parent::_prepareForm();
  }
}