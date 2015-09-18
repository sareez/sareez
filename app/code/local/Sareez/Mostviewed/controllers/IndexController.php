<?php
class Sareez_Mostviewed_IndexController extends Mage_Core_Controller_Front_action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/mostviewed?id=15 
    	 *  or
    	 * http://site.com/mostviewed/id/15 	
    	 */
    	/* 
		$mostviewed_id = $this->getRequest()->getParam('id');

  		if($mostviewed_id != null && $mostviewed_id != '')	{
			$mostviewed = Mage::getModel('mostviewed/mostviewed')->load($mostviewed_id)->getData();
		} else {
			$mostviewed = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($mostviewed == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$mostviewedTable = $resource->getTableName('mostviewed');
			
			$select = $read->select()
			   ->from($mostviewedTable,array('mostviewed_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$mostviewed = $read->fetchRow($select);
		}
		Mage::register('mostviewed', $mostviewed);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
	
		/////////// Most Viewed Last Seven Days <<
	public function mostviewedlastsevendaysAction()
    {
		
		
	//	 echo "Most Viewed Last Seven Days";
		
	// Most Viewd Last 7 days >>
	$productCount = 12;
	// store ID
	$storeId    = Mage::app()->getStore()->getId();
	// get today and last 30 days time
	$today = time();
	$last = $today - (60*60*24*7);
	
	
	$from = date("Y-m-d", $last);
	$to = date("Y-m-d", $today);
	// get most viewed products for last 30 days
	$products_most_viewed7 = Mage::getResourceModel('reports/product_collection')
		->addAttributeToSelect('*')	
		->setStoreId($storeId)
		->addStoreFilter($storeId)
		->addViewsCount()
		->addViewsCount($from, $to)
		->addAttributeToSort("entity_id","desc")
		->setPageSize($productCount);
		Mage::getSingleton('catalog/product_status')
		->addVisibleFilterToCollection($products_most_viewed7);
		Mage::getSingleton('catalog/product_visibility')
		->addVisibleInCatalogFilterToCollection($products_most_viewed7);
	//	return $products_most_viewed7;
                
               // print_r($products_most_viewed7);                exit();
	
		
		
		
//	$products_most_viewed7 = $this->getMostViewedSeven();    
	$mvp = 1;
        

        
    foreach($products_most_viewed7 as $mostViewed){
		/*
		echo 	$child= Mage::getSingleton('catalog/layer')->getCurrentCategory()->getId();
		$imageSrc = Mage::getModel('catalog/category')->load($child)->getThumbnail();
		$ThumbnailUrl = Mage::getBaseUrl('media').'catalog/category/'.$imageSrc;
		echo "<img src='{$ThumbnailUrl}' />";
		// $product_id = $this->getRequest()->getParam('id');
		echo $_products=Mage::getModel('catalog/product')->load($mostViewed->getId());
		*/
    ?>
<?php if($mvp==1){ ?>
<div class="bottom-slider-01" style="margin-left: 70.3421px; ">
<?php } ?>
<?php if($mvp==5){ ?>
<div class="bottom-slider-02" style="margin-left: 766px; ">
  <?php } ?>
  <?php if($mvp==9){ ?>
  <div class="bottom-slider-03" style="margin-left: -695.658px; ">
    <?php } ?>
    <div class="bottom-slide-image img123"> <a href="<?php echo $mostViewed->getProductUrl(); ?>"> 
    <img src="<?php echo Mage::helper('catalog/image')->init($mostViewed , 'thumbnail')->resize(190, 264); ?>" width="195" alt="<?php echo $mostViewed->getName(); ?>"> </a>
      <div>
        <p class="bottom-slide-price"><?php echo $_formattedActualPrice = Mage::helper('core')->currency($mostViewed->getPrice(),true,false); ?> </p>
        <a href="<?php echo $mostViewed->getProductUrl(); ?>">
        <p class="bottom-slide-shopnow">SHOP NOW </p>
        </a> </div>
    </div>
    <?php if($mvp==4 || $mvp==8 || $mvp==12){ ?>
  </div>
  <?php } ?>
  <?php
	$mvp++;
    }
	
		

	
    }
	
	/////////// Most Viewed Fourteen Days <<
	public function mostviewedlastfourteendaysAction()
    {
    
	 
		
	///////////////////////////// Most Viewd Last 14 days >>
	// ->addAttributeToSort('news_from_date', 'asc')
	$productCount14 = 12;
	// store ID
	$storeId14    = Mage::app()->getStore()->getId();
	// get today and last 30 days time
	//  - (6 * 24 * 60 * 60)
	$today14 = time();
	$last14 = $today14 - (60*60*24*14);
	
	$from14 = date("Y-m-d", $last14);
	$to14 = date("Y-m-d", $today14);
	// get most viewed products for last 30 days
	$products_most_viewed14 = Mage::getResourceModel('reports/product_collection')
		->addAttributeToSelect('*')	
		->setStoreId($storeId14)
		->addStoreFilter($storeId14)
		->addViewsCount()
		->addViewsCount($from14, $to14)
		->addAttributeToSort("entity_id","desc")
		->setPageSize($productCount14);
		Mage::getSingleton('catalog/product_status')
		->addVisibleFilterToCollection($products_most_viewed14);
		Mage::getSingleton('catalog/product_visibility')
		->addVisibleInCatalogFilterToCollection($products_most_viewed14); 
	
	//return $products_most_viewed14;
	
	 
	 //	$products_most_viewed14 = $this->getMostViewedFourteen();   
	$mvp14 = 1;
    foreach($products_most_viewed14 as $mostViewed14){
    ?>
<?php if($mvp14==1){ ?>
<div class="bottom-slider-01" style="margin-left: 70.3421px;">
<?php } ?>
<?php if($mvp14==5){ ?>
<div class="bottom-slider-02" style="margin-left: 766px;">
  <?php } ?>
  <?php if($mvp14==9){ ?>
  <div class="bottom-slider-03" style="margin-left: -695.658px;">
    <?php } ?>
    <div class="bottom-slide-image img123"> <a href="<?php echo $mostViewed14->getProductUrl(); ?>">
    <img src="<?php echo Mage::helper('catalog/image')->init($mostViewed14 , 'thumbnail')->resize(190, 264); ?>" width="195" alt="<?php echo $mostViewed14->getName(); ?>">
     <!--<img src="<?php //echo $this->helper('catalog/image')->init($mostViewed14, 'small_image')->resize(190, 264); ?>" width="190">--> </a>
      <div>
        <p class="bottom-slide-price"><?php echo $_formattedActualPrice = Mage::helper('core')->currency($mostViewed14->getPrice(),true,false); ?> </p>
        <a href="<?php echo $mostViewed14->getProductUrl(); ?>">
        <p class="bottom-slide-shopnow">SHOP NOW </p>
        </a> </div>
    </div>
    <?php if($mvp14==4 || $mvp14==8 || $mvp14==12){ ?>
  </div>
  <?php } ?>
  <?php
	$mvp14++;
    }
	 

    }
	
	
	/////////// Most Viewed Thirtee Days <<
	public function mostviewedlastthirteedaysAction()
    {
     //echo "Most Viewed Last Seven Days";
	// ->addAttributeToSort('news_from_date', 'desc')
	///////////////////////////// Most Viewd Last 30 days >>
	$productCount = 12;
	// store ID
	$storeId    = Mage::app()->getStore()->getId();
	// get today and last 30 days time
	// - (3 * 24 * 60 * 60)
	$today = time();
	$last = $today - (60*60*24*30);
	
	$from = date("Y-m-d", $last);
	$to = date("Y-m-d", $today);
	// get most viewed products for last 30 days
	$products_most_viewed30 = Mage::getResourceModel('reports/product_collection')
	->addAttributeToSelect('*')	
	->setStoreId($storeId)
	->addStoreFilter($storeId)
	->addViewsCount()
	->addViewsCount($from, $to)
	
	
	->addAttributeToSort("entity_id","desc")
	->setPageSize($productCount);
	
	
	
	Mage::getSingleton('catalog/product_status')
	->addVisibleFilterToCollection($products_most_viewed30);
	Mage::getSingleton('catalog/product_visibility')
	->addVisibleInCatalogFilterToCollection($products_most_viewed30);
	
	//return $products_most_viewed30;
	
	
		//$products_most_viewed30 = $this->getMostViewedThirty();   
	$mvp = 1;
    foreach($products_most_viewed30 as $mostViewed){
    ?>
<?php if($mvp==1){ ?>
<div class="bottom-slider-01" style="margin-left: 70.3421px;">
<?php } ?>
<?php if($mvp==5){ ?>
<div class="bottom-slider-02" style="margin-left: 766px;">
  <?php } ?>
  <?php if($mvp==9){ ?>
  <div class="bottom-slider-03" style="margin-left: -695.658px;">
    <?php } ?>
    <div class="bottom-slide-image img123"> <a href="<?php echo $mostViewed->getProductUrl(); ?>"> 
    <!--<img src="<?php //echo $this->helper('catalog/image')->init($mostViewed, 'small_image')->resize(190, 264); ?>" width="190">--> 
    <img src="<?php echo Mage::helper('catalog/image')->init($mostViewed , 'thumbnail')->resize(190, 264); ?>" width="195"  alt="<?php echo $mostViewed->getName(); ?>">
    </a>
      <div>
        <p class="bottom-slide-price"><?php echo $_formattedActualPrice = Mage::helper('core')->currency($mostViewed->getPrice(),true,false); ?> </p>
        <a href="<?php echo $mostViewed->getProductUrl(); ?>">
        <p class="bottom-slide-shopnow">SHOP NOW </p>
        </a> </div>
    </div>
    <?php if($mvp==4 || $mvp==8 || $mvp==12){ ?>
  </div>
  <?php } ?>
  <?php
	$mvp++;
    }
    }
	
	/////////// MOST PURCHASED Seven Days <<
	public function mostpurchasedlastsevendaysAction()
    {
     //echo "Most Viewed Last Seven Days";
	 	$productCount_bs7 = 12;
	// store ID
	$storeId_bs7 = Mage::app()->getStore()->getId();
	
	// get today and last 30 days time
	$today_bs7 = time();
	$last_bs7 = $today_bs7 - (60*60*24*7);
	
	$from_bs7 = date("Y-m-d", $last_bs7);
	$to_bs7 = date("Y-m-d", $today_bs7);
	// get most viewed products for current category
	$products_bs7 = Mage::getResourceModel('reports/product_collection')
		->addAttributeToSelect('*')	
		->addOrderedQty($from_bs7, $to_bs7)
		->setStoreId($storeId_bs7)
		->addStoreFilter($storeId_bs7)	
		->setOrder('ordered_qty', 'desc')
		->setPageSize($productCount_bs7);
		Mage::getSingleton('catalog/product_status')
		->addVisibleFilterToCollection($products_bs7);
		Mage::getSingleton('catalog/product_visibility')
		->addVisibleInCatalogFilterToCollection($products_bs7);
	
	//return $products_bs7;
	 
	$mpp = 1;           
    foreach($products_bs7 as $product_bs7){
	?>
<?php if($mpp==1){ ?>
<div class="bottom-slider-01" style="margin-left: 70.3421px;">
<?php } ?>
<?php if($mpp==5){ ?>
<div class="bottom-slider-02" style="margin-left: 766px;">
  <?php } ?>
  <?php if($mpp==9){ ?>
  <div class="bottom-slider-03" style="margin-left: -695.658px;">
    <?php } ?>
    <div class="bottom-slide-image img123"> <a href="<?php echo $product_bs7->getProductUrl(); ?>">
    <img src="<?php echo Mage::helper('catalog/image')->init($product_bs7 , 'thumbnail')->resize(190, 264); ?>" width="195" alt="<?php echo $product_bs7->getName(); ?>">
    <!--<img src="<?php //echo $this->helper('catalog/image')->init($product_bs7, 'small_image')->resize(190, 264); ?>" width="190">-->
    </a>
      <div>
        <p class="bottom-slide-price"><?php echo $_formattedActualPrice = Mage::helper('core')->currency($product_bs7->getPrice(),true,false); ?> </p>
        <a href="<?php echo $product_bs7->getProductUrl(); ?>">
        <p class="bottom-slide-shopnow">SHOP NOW</p>
        </a> </div>
    </div>
    <?php if($mpp==4 || $mpp==8 || $mpp==12){ ?>
  </div>
  <?php } ?>
  <?php
	$mpp++;
    }	
	
    }
	
	/////////// MOST PURCHASED Fourteen Days <<
	public function mostpurchasedlastfourteendaysAction()
    {
     //echo "Most Viewed Last Seven Days";
	 
	 	$productCount_bs14 = 12;
	// store ID
	$storeId_bs14 = Mage::app()->getStore()->getId();
	
	// get today and last 30 days time
	//  - (6 * 24 * 60 * 60)
	$today_bs14 = time();
	$last_bs14 = $today_bs14 - (60*60*24*14);
	
	$from_bs14 = date("Y-m-d", $last_bs14);
	$to_bs14 = date("Y-m-d", $today_bs14);
	// get most viewed products for current category
	$products_bs14 = Mage::getResourceModel('reports/product_collection')
		->addAttributeToSelect('*')	
		->addOrderedQty($from_bs14, $to_bs14)
		->setStoreId($storeId_bs14)
		->addStoreFilter($storeId_bs14)	
		->setOrder('ordered_qty', 'desc')
		->setPageSize($productCount_bs14);
		Mage::getSingleton('catalog/product_status')
		->addVisibleFilterToCollection($products_bs14);
		Mage::getSingleton('catalog/product_visibility')
		->addVisibleInCatalogFilterToCollection($products_bs14);

	 // return $products_bs14;
	 
	 
	$mpp = 1;           
    foreach($products_bs14 as $product_bs14){
	?>
<?php if($mpp==1){ ?>
<div class="bottom-slider-01" style="margin-left: 70.3421px;">
<?php } ?>
<?php if($mpp==5){ ?>
<div class="bottom-slider-02" style="margin-left: 766px;">
  <?php } ?>
  <?php if($mpp==9){ ?>
  <div class="bottom-slider-03" style="margin-left: -695.658px;">
    <?php } ?>
    <div class="bottom-slide-image img123"> <a href="<?php echo $product_bs14->getProductUrl(); ?>">
    <img src="<?php echo Mage::helper('catalog/image')->init($product_bs14 , 'thumbnail')->resize(190, 264); ?>" width="195" alt="<?php echo $product_bs14->getName(); ?>">
    <!--<img src="<?php //echo $this->helper('catalog/image')->init($product_bs14, 'small_image')->resize(190, 264); ?>" width="190">-->
    </a>
      <div>
        <p class="bottom-slide-price"><?php echo $_formattedActualPrice = Mage::helper('core')->currency($product_bs14->getPrice(),true,false); ?> </p>
        <a href="<?php echo $product_bs14->getProductUrl(); ?>">
        <p class="bottom-slide-shopnow">SHOP NOW</p>
        </a> </div>
    </div>
    <?php if($mpp==4 || $mpp==8 || $mpp==12){ ?>
  </div>
  <?php } ?>
  <?php
	$mpp++;
    }
    }
	
	/////////// MOST PURCHASED Thirtee Days <<
	public function mostpurchasedlastthirteedaysAction()
    {
     //echo "Most Viewed Last Seven Days";
	 	$productCount_bs30 = 12;
	// store ID
	$storeId_bs30 = Mage::app()->getStore()->getId();
	 
	// get today and last 30 days time
	// $today_bs30 = time() - (12 * 24 * 60 * 60);
	//  - (3 * 24 * 60 * 60)
	 $today_bs30 = time();
	$last_bs30 = $today_bs30 - (60*60*24*30);
	 
	$from_bs30 = date("Y-m-d", $last_bs30);
	$to_bs30 = date("Y-m-d", $today_bs30);
	// get most viewed products for current category
	$products_bs30 = Mage::getResourceModel('reports/product_collection')
		->addAttributeToSelect('*')	
		->addOrderedQty($from_bs30, $to_bs30)
		->setStoreId($storeId_bs30)
		->addStoreFilter($storeId_bs30)	
		->setOrder('ordered_qty', 'desc')
		->setPageSize($productCount_bs30);
		Mage::getSingleton('catalog/product_status')
		->addVisibleFilterToCollection($products_bs30);
		Mage::getSingleton('catalog/product_visibility')
		->addVisibleInCatalogFilterToCollection($products_bs30);
	 
	$mpp = 1;           
    foreach($products_bs30 as $product_bs30){
	?>
  <?php if($mpp==1){ ?>
  <div class="bottom-slider-01" style="margin-left: 70.3421px;">
    <?php } ?>
    <?php if($mpp==5){ ?>
    <div class="bottom-slider-02" style="margin-left: 766px;">
      <?php } ?>
      <?php if($mpp==9){ ?>
      <div class="bottom-slider-03" style="margin-left: -695.658px;">
        <?php } ?>
        <div class="bottom-slide-image img123"> <a href="<?php echo $product_bs30->getProductUrl(); ?>">
        <img src="<?php echo Mage::helper('catalog/image')->init($product_bs30 , 'thumbnail')->resize(190, 264); ?>" width="195" alt="<?php echo $product_bs30->getName(); ?>">
       <!-- <img src="<?php //echo $this->helper('catalog/image')->init($product_bs30, 'small_image')->resize(190, 264); ?>" width="195">-->
        </a>
          <div>
            <p class="bottom-slide-price"><?php echo $_formattedActualPrice = Mage::helper('core')->currency($product_bs30->getPrice(),true,false); ?></p>
            <a href="<?php echo $product_bs30->getProductUrl(); ?>">
            <p class="bottom-slide-shopnow">SHOP NOW</p>
            </a> </div>
        </div>
        <?php if($mpp==4 || $mpp==8 || $mpp==12){ ?>
      </div>
      <?php } ?>
      <?php
	$mpp++;
    }
    }
	
	
	
	/////////// Latest Trending Designs Part One <<
	public function latesttrendingdesignsoneAction()
    {
	$resource = Mage::getSingleton('core/resource');
	$readConnection = $resource->getConnection('core_read');

    $query = "SELECT * FROM ordercsv where sku like '%SA%' order by order_id desc limit 0,9";
    $_sareeCollection = $readConnection->fetchAll($query);
    
	$ltdsk = 1;
    foreach($_sareeCollection as $_sareeCollections){
    ?>

	<?php if($ltdsk==1){ ?>
    <div class="new-product-slider-01" style="margin-left: -456px;" >
    <?php } ?>
    
    <?php if($ltdsk==4){ ?>
    <div class="new-product-slider-02" style="margin-left: 0px; ">
    <?php } ?>
    
    <?php if($ltdsk==7){ ?>
    <div class="new-product-slider-03" style="margin-left: 456px;">
    <?php } ?>
         <div class="img">
             
             <?php 

             
        $productid = $_sareeCollections['productid']; 
        $obj = Mage::getModel('catalog/product');
        $_product = $obj->load($productid); 

		 ?> 
             
            <a href="<?php echo $_product->getProductUrl(); ?>">
            <img src="<?php echo Mage::helper('catalog/image')->init($_product , 'thumbnail')->resize(142, 213); ?>" alt="<?php echo $_product->getName(); ?>">
			</a>
            <p align="center" class="price"> <?php echo $_formattedActualPrice = Mage::helper('core')->currency($_product->getPrice(),true,false); ?> </p>
            <a href="<?php echo $_product->getProductUrl(); ?>"><p align="center" class="shop-button">SHOP NOW</p></a>
            </div>
    
	<?php if($ltdsk==3 || $ltdsk==6 || $ltdsk==9){ ?></div><?php } ?>
    
    <?php
	$ltdsk++;
    }
    
	}
	
	
	
	
	
	
	
	/////////// Latest Trending Designs Part Two <<
	public function latesttrendingdesignstwoAction()
    {
		
		
	$resource = Mage::getSingleton('core/resource');
	$readConnection = $resource->getConnection('core_read');
	
	$query = "SELECT * FROM ordercsv where sku like '%SL%' order by order_id desc limit 0,9";
    $_lehengaCollection = $readConnection->fetchAll($query);
    
	$ltd = 1;
    foreach($_lehengaCollection as $_lehengaCollections){
        
        $productid = $_lehengaCollections['productid']; 
        $obj = Mage::getModel('catalog/product');
        $_product = $obj->load($productid); 
        
    ?>

	<?php if($ltd==1){ ?>
     <div class="new-product-slider-01" style="display: block; margin-left: -456px;">
    <?php } ?>
    
    <?php if($ltd==4){ ?>
    <div class="new-product-slider-02" style="margin-left: 0px; display: block;">
    <?php } ?>
    
    <?php if($ltd==7){ ?>
    <div class="new-product-slider-03" style="margin-left: 456px; display: block;">
    <?php } ?>
         <div class="img">
            <a href="<?php echo $_product->getProductUrl(); ?>">
            
            <img src="<?php echo Mage::helper('catalog/image')->init($_product, 'small_image')->resize(142, 213); ?>" alt="<?php echo $_product->getName(); ?>">
            </a>
            <p align="center" class="price"> <?php echo $_formattedActualPrice = Mage::helper('core')->currency($_product->getPrice(),true,false); ?></p>
            <a href="<?php echo $_product->getProductUrl(); ?>"><p align="center" class="shop-button">SHOP NOW</p></a>
            </div>
    
	<?php if($ltd==3 || $ltd==6 || $ltd==9){ ?></div><?php } ?>
    
    <?php
	$ltd++;
    }
	
	}
	
	
	
	
	
		
	/////////// Latest Trending Designs Part Three <<
	public function latesttrendingdesignsthreeAction()
    {
	$resource = Mage::getSingleton('core/resource');
	$readConnection = $resource->getConnection('core_read');
		
		$query = "SELECT * FROM ordercsv where sku like '%LL%' order by order_id desc limit 0,9";
		$_lehengaCollection = $readConnection->fetchAll($query);
    
	$ltd = 1;
    foreach($_lehengaCollection as $_lehengaCollections){
        
        $productid = $_lehengaCollections['productid']; 
        $obj = Mage::getModel('catalog/product');
        $_product = $obj->load($productid); 
        
    	?>

             
	<?php if($ltd==1){ ?>
     <div class="new-product-slider-01" style="display: block; margin-left: -456px;">
    <?php } ?>
    
    <?php if($ltd==4){ ?>
    <div class="new-product-slider-02" style="margin-left: 0px; display: block;">
    <?php } ?>
    
    <?php if($ltd==7){ ?>
    <div class="new-product-slider-03" style="margin-left: 456px; display: block;">
    <?php } ?>
         <div class="img">
            <a href="<?php echo $_product->getProductUrl(); ?>">
            <img src="<?php echo Mage::helper('catalog/image')->init($_product, 'small_image')->resize(142, 213); ?>" alt="<?php echo $_product->getName(); ?>">
            </a>
            <p align="center" class="price"> <?php echo $_formattedActualPrice = Mage::helper('core')->currency($_product->getPrice(),true,false); ?></p>
            <a href="<?php echo $_product->getProductUrl(); ?>"><p align="center" class="shop-button">SHOP NOW</p></a>
            </div>
    
	<?php if($ltd==3 || $ltd==6 || $ltd==9){ ?></div><?php } ?>
    
    <?php
	$ltd++;
    }
	}
	
	
	
}