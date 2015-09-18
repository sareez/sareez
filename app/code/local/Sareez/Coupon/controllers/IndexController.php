<?php
class Sareez_Coupon_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/coupon?id=15 
    	 *  or
    	 * http://site.com/coupon/id/15 	
    	 */
    	/* 
		$coupon_id = $this->getRequest()->getParam('id');

  		if($coupon_id != null && $coupon_id != '')	{
			$coupon = Mage::getModel('coupon/coupon')->load($coupon_id)->getData();
		} else {
			$coupon = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($coupon == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$couponTable = $resource->getTableName('coupon');
			
			$select = $read->select()
			   ->from($couponTable,array('coupon_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$coupon = $read->fetchRow($select);
		}
		Mage::register('coupon', $coupon);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
	
	
	public function editAction(){
		
		$coupon = $this->getRequest()->getParam('q');
		$coupon_id = $this->getRequest()->getParam('coupon_id');
		$write = Mage::getSingleton('core/resource')->getConnection('core_write');
		$query ="update generatedcoupon set coupon_code = '".$coupon."' where generatedcoupon_id = '".$coupon_id."'";
		$confirm = $write->query($query);
		if($confirm){ echo "Data inserted successfully!"; }
		
	}
	
	public function deleteAction(){
		
		$coupon = $this->getRequest()->getParam('q');
		$coupon_id = $this->getRequest()->getParam('coupon_id');
		$write = Mage::getSingleton('core/resource')->getConnection('core_write');
		$query ="delete from generatedcoupon where generatedcoupon_id = '".$coupon_id."'";
		$confirm = $write->query($query);
		if($confirm){ echo "Data deleted successfully!"; }
		
	}
	
	public function fetchallAction(){
		
		$coupon_cat = $this->getRequest()->getParam('coupon_cat');
		//$coupon_id = $this->getRequest()->getParam('coupon_id');
		$readresult = Mage::getSingleton('core/resource')->getConnection('core_write');
		$query ="select * from generatedcoupon where coupon_id='".$coupon_cat."' order by generatedcoupon_id desc"; //  
		?>
        <table class="data" width="100%" border="1" cellspacing="0" cellpadding="10">
  <tr class="even">
    <td class="a-center on-mouse"><strong>ID</strong></td>
    <td class="on-mouse"><strong>Coupon code</strong></td>
    <td class="a-center on-mouse"><strong>Status</strong></td>
    <td class="a-center on-mouse"><strong>Option</strong></td>
  </tr>
        <?php
		$i=1;
		$results = $readresult->fetchAll($query);
		foreach ($readresult->fetchAll($query) as $result) {
		?>
  <tr class="pointer">
    <td class="a-center on-mouse"><?php echo $i; ?></td>
    <td class="on-mouse"><?php echo $result['coupon_code']; ?></td>
    <td class="a-center on-mouse">Yes</td>
    <td class="a-center on-mouse">
    <a href="Javascript:void(0)" onclick="coupon_edit('<?php echo $i; ?>')">Edit</a> | 
    <a href="Javascript:void(0)"  onclick="deleteAction('<?php echo $i; ?>')" >Delete</a></td>
  </tr>
  <tr class="even" >
    <td colspan="5" class="a-center on-mouse">
    <div  style=" display:none;" id="form<?php echo $i; ?>" >
        <table width="100%" border="0" cellspacing="3" cellpadding="3">
          <tr>
            <td width="28%">&nbsp;</td>
            <td width="2%">&nbsp;</td>
            <td width="70%">&nbsp;</td>
          </tr>
          <tr>
            <td><strong>Coupon code</strong></td>
            <td>:</td>
            <td align="left">
              <input type="text" name="coupon_code<?php echo $i; ?>" id="coupon_code<?php echo $i; ?>" value="<?php echo $result['coupon_code']; ?>" />
             <input type="hidden" name="coupon_id<?php echo $i; ?>" id="coupon_id<?php echo $i; ?>" value="<?php echo $result['generatedcoupon_id']; ?>" />
   <input type="hidden" name="coupon_cat<?php echo $i; ?>" id="coupon_cat<?php echo $i; ?>" value="<?php //echo getUriSegment(6); ?>" />
                
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="left">
              <input type="button" name="button" id="button" value="Submit" onclick="editAction('<?php echo $i; ?>')" />
            </td>
          </tr>
        </table>
    </div>
    </td>
    </tr>
        <?php
		$i++;
			}
	?>
    </table>
    <script>
function coupon_edit(id){
	
	
	
	if(document.getElementById('form'+id).style.display=="block")
	{
	//	alert(id);
	 document.getElementById('form'+id).style.display="none";
	} else if(document.getElementById('form'+id).style.display=="none")
		{
			// alert(id);
		 document.getElementById('form'+id).style.display="block";
		}
	
}
</script>
    <?php
	//}
		
	}
        
        
        
        
        public function couponprocessAction(){
            
            // echo "Hello I am here!"; exit;
            
            ?>
<!-- COUPON CODE >> -->
<?php // if($this->getUrl('checkout/cart') == "http://www.sareees.com/checkout/cart/"){  ?>
<?php 
session_start();
require_once("app/Mage.php");
$app = Mage::app('');

// $_SESSION['coupon'] = $_REQUEST['coupon'];



Mage::getSingleton('core/session')->setCouponcatchMessage($_REQUEST['coupon']);
Mage::getSingleton('core/session')->getCouponcatchMessage();
							

	 
if($_REQUEST['notHere1']=="notHere1"){
?>
<script>
window.location="<?php echo Mage::getBaseUrl(); ?>checkout/cart/?notHere=notHere";
</script>
<?php
 }
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
	 if($_REQUEST['coupon']!=""){
			 
			 
			 $write = Mage::getSingleton('core/resource')->getConnection('core_write');

  $query = "SELECT 

			generatedcoupon.coupon_id, 
			generatedcoupon.coupon_code, 
			generatedcoupon.status as couponStatus, 
			
			coupon.status as ruleStatus,
			coupon.no_of_prd, 
			coupon.action,
			coupon.discount_amount,
			coupon.min_amnt,
			coupon.multiple_coupon,
			coupon.product_category,
			coupon.user,
			coupon.product_level,
			coupon.discount_level,
			coupon.special_price


FROM generatedcoupon inner join coupon on generatedcoupon.coupon_id = coupon.coupon_id and generatedcoupon.coupon_code ='".$_REQUEST['coupon']."'"; 

$readresult=$write->query($query);
			 
	while ($row = $readresult->fetch()) 
	{
		$status 			= $row['ruleStatus'];
		


	}	
	// echo $status; exit;
			if($status == "2"){
			
			//$this->_redirect(Mage::getBaseUrl().'checkout/cart/?notHere=notHere');
			//header('Location:'.$this->getUrl('checkout/cart'));
                        //header('Location:'.$this->getUrl('checkout/cart'));
						//echo "1111111111";
		 ?>
                 <script>
	// window.location="<?php echo Mage::getBaseUrl(); ?>coupon/index/couponprocess/?notHere=notHere";
                window.location="<?php  echo Mage::getBaseUrl(); ?>checkout/cart/?notHere=notHere";
		 </script>
		 <?php
		 exit;
			} 
			 
			 
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	 
			 
		 $write = Mage::getSingleton('core/resource')->getConnection('core_write');
		$couponQuery = "select count(coupon_code) from generatedcoupon where coupon_code = '".$_REQUEST['coupon']."'";
		 //count(coupon_code);
		// $couponCode = mysql_num_rows(mysql_query("select count(coupon_code) from generatedcoupon where coupon_code = '".$_REQUEST['coupon']."'"));
		 
		 $couponCode=$write->query($couponQuery);
		 while ($row = $couponCode->fetch()) 
		{
		 $rowCount = $row['count(coupon_code)'];
		}
		 
		 //echo $rowCount;
		 if($rowCount == "0")
		 {
	      // header('Location: '.Mage::getBaseUrl().'cart/?notHere=notHere');
		  // $this->_redirect('cart/?notHere=notHere');
		  if($_REQUEST['notHere']!="notHere"){
                    //  header('Location:'.$this->getUrl('checkout/cart').'?notHere=notHere');
                     // $url = 'http://www.sareees.com/checkout/cart/?notHere=notHere';
                   //   header('Location:'.$url);
		 ?>
                <script>
		  window.location="<?php echo Mage::getBaseUrl(); ?>coupon/index/couponprocess/?notHere1=notHere1";
		</script>
		 <?php
		  }
		 }
		 }

$sessionCustomer = Mage::getSingleton("customer/session");
$items = Mage::getSingleton('checkout/session')->getQuote()->getAllItems();
$totalQuantity = Mage::getModel('checkout/cart')->getQuote()->getItemsQty();
$userId = Mage::getSingleton('customer/session')->getId();


//////////////// COUPON FETCH >> 

$couponPiece = explode(",", $_REQUEST['coupon']);

if($couponPiece[0]!=""){
$couponInput = $couponPiece[0];
Mage::getSingleton('core/session')->setCouponMessage($couponInput);
$coupon = Mage::getSingleton('core/session')->getCouponMessage();
$coupon;
}

$write = Mage::getSingleton('core/resource')->getConnection('core_write');

 $query = "SELECT 

			generatedcoupon.coupon_id, 
			generatedcoupon.coupon_code, 
			generatedcoupon.status as couponStatus, 
			
			coupon.status as ruleStatus,
			coupon.no_of_prd, 
			coupon.action,
			coupon.discount_amount,
			coupon.min_amnt,
			coupon.multiple_coupon,
			coupon.product_category,
			coupon.user,
			coupon.product_level,
			coupon.discount_level,
			coupon.special_price


FROM generatedcoupon inner join coupon on generatedcoupon.coupon_id = coupon.coupon_id and generatedcoupon.coupon_code ='".$coupon."'"; 

$readresult=$write->query($query);



	$multyCup = array_unique(explode(",", $_REQUEST['coupon']));
	count($multyCup);


	while ($row = $readresult->fetch()) 
	{
		$coupon_id 			= $row['coupon_id'];
		$coupon_code 		= $row['coupon_code'];
		$couponStatus 		= $row['couponStatus'];	
		$ruleStatus 		= $row['ruleStatus'];
		$no_of_prd 			= $row['no_of_prd'];
		$action 			= $row['action'];
		$discount_amount 	= $row['discount_amount'];
	    $min_amnt 			= $row['min_amnt'];
		$multiple_coupon 	= $row['multiple_coupon'];
		$product_category 	= $row['product_category'];
		$user 				= $row['user'];
		$product_level      = $row['product_level'];
		$discount_level     = $row['discount_level'];
		$special_price      = $row['special_price'];
		
		
	}
	
	
//////////////////////// 	Second Coupon
$write = Mage::getSingleton('core/resource')->getConnection('core_write');

 $query = "SELECT 

			generatedcoupon.coupon_id, 
			generatedcoupon.coupon_code, 
			generatedcoupon.status as couponStatus, 
			
			coupon.status as ruleStatus,
			coupon.no_of_prd, 
			coupon.action,
			coupon.discount_amount,
			coupon.min_amnt,
			coupon.multiple_coupon,
			coupon.product_category,
			coupon.user,
			coupon.product_level,
			coupon.discount_level,
			coupon.special_price


FROM generatedcoupon inner join coupon on generatedcoupon.coupon_id = coupon.coupon_id and generatedcoupon.coupon_code ='".$couponPiece[1]."'"; // exit;

$readresult=$write->query($query);	
	while ($row2 = $readresult->fetch()) 
	{
		$coupon_id2 		= $row2['coupon_id'];
		$coupon_code2 		= $row2['coupon_code'];
		$couponStatus2 		= $row2['couponStatus'];	
		$ruleStatus2 		= $row2['ruleStatus'];
		$no_of_prd2 		= $row2['no_of_prd'];
		$action2 			= $row2['action'];
		$discount_amount2 	= $row2['discount_amount'];
		$min_amnt2 			= $row2['min_amnt'];
		$multiple_coupon2 	= $row2['multiple_coupon'];
		$product_category2 	= $row2['product_category'];
		$user2 				= $row2['user'];
		$product_level      = $row['product_level'];
		$discount_level     = $row['discount_level'];
		$special_price      = $row['special_price'];
	}

//////////////////////// 	Third Coupon
$write = Mage::getSingleton('core/resource')->getConnection('core_write');

 $query = "SELECT 

			generatedcoupon.coupon_id, 
			generatedcoupon.coupon_code, 
			generatedcoupon.status as couponStatus, 
			
			coupon.status as ruleStatus,
			coupon.no_of_prd, 
			coupon.action,
			coupon.discount_amount,
			coupon.min_amnt,
			coupon.multiple_coupon,
			coupon.product_category,
			coupon.user,
			coupon.product_level,
			coupon.discount_level,
			coupon.special_price


FROM generatedcoupon inner join coupon on generatedcoupon.coupon_id = coupon.coupon_id and generatedcoupon.coupon_code ='".$couponPiece[2]."'"; // exit;

$readresult=$write->query($query);	
	while ($row3 = $readresult->fetch()) 
	{
		$coupon_id3 		= $row3['coupon_id'];
		$coupon_code3 		= $row3['coupon_code'];
		$couponStatus3 		= $row3['couponStatus'];	
		$ruleStatus3 		= $row3['ruleStatus'];
		$no_of_prd3 		= $row3['no_of_prd'];
		$action3 			= $row3['action'];
		$discount_amount3 	= $row3['discount_amount'];
		$min_amnt3 			= $row3['min_amnt'];
		$multiple_coupon3 	= $row3['multiple_coupon'];
		$product_category3 	= $row3['product_category'];
		$user3 				= $row3['user'];
		$product_level      = $row['product_level'];
		$discount_level     = $row['discount_level'];
		$special_price      = $row['special_price'];
	}
	
	//////////////////////// 	Fourth Coupon
$write = Mage::getSingleton('core/resource')->getConnection('core_write');

 $query = "SELECT 

			generatedcoupon.coupon_id, 
			generatedcoupon.coupon_code, 
			generatedcoupon.status as couponStatus, 
			
			coupon.status as ruleStatus,
			coupon.no_of_prd, 
			coupon.action,
			coupon.discount_amount,
			coupon.min_amnt,
			coupon.multiple_coupon,
			coupon.product_category,
			coupon.user,
			coupon.product_level,
			coupon.discount_level,
			coupon.special_price


FROM generatedcoupon inner join coupon on generatedcoupon.coupon_id = coupon.coupon_id and generatedcoupon.coupon_code ='".$couponPiece[3]."'"; // exit;

$readresult=$write->query($query);	
	while ($row4 = $readresult->fetch()) 
	{
		$coupon_id4			= $row4['coupon_id'];
		$coupon_code4 		= $row4['coupon_code'];
		$couponStatus4 		= $row4['couponStatus'];	
		$ruleStatus4 		= $row4['ruleStatus'];
		$no_of_prd4 		= $row4['no_of_prd'];
		$action4 			= $row4['action'];
		$discount_amount4 	= $row4['discount_amount'];
		$min_amnt4 			= $row4['min_amnt'];
		$multiple_coupon4 	= $row4['multiple_coupon'];
		$product_category4 	= $row4['product_category'];
		$user4 				= $row4['user'];
		$product_level      = $row['product_level'];
		$discount_level     = $row['discount_level'];
		$special_price      = $row['special_price'];
	}

 
 
 	$categoryCheck = explode(",", $product_category);
	$categoryCount = count($categoryCheck);
	
foreach($items as $item) {
	
/*	
echo 'ID: '.$item->getProductId().'<br />';
echo 'Name: '.$item->getName().'<br />';
echo 'Sku: '.$item->getSku().'<br />';
echo 'Quantity: '.$item->getQty().'<br />';
echo 'Price: '.$item->getPrice().'<br />';
*/

	$productId = $item->getProductId();
	$_product = Mage::getModel('catalog/product')->load($productId);
	$_product->getPrice($_product, true);



$categoryIds = $item->getProduct()->getCategoryIds(); // returns category ids from product



		for($c=0; $c<=$categoryCount; $c++) // 
		{

		 $rightCategory = $categoryCheck[$c]; 
		 
			 if(in_array($rightCategory, $categoryIds))
			 {
				/* 
				$price = $_product->getPrice();
				$formatted = Mage::helper('core')->currency($price, true);
				$orginal_amount += $formatted * $item->getQty();
				 */
				
				 
				  $_basePrice = Mage::helper('core')->currency($_product->getPrice(),false,false);
				   $_discountPrice = Mage::helper('core')->currency($_product->getFinalPrice(),false,false);
				  
				  // if($_formattedActualPrice != $_formattedActualPrice){ }
				  
				 if($special_price == '2'){
					 $_formattedActualPrice = Mage::helper('core')->currency($_product->getFinalPrice(),false,false);
					 } else {
					  $_formattedActualPrice = Mage::helper('core')->currency($_product->getPrice(),false,false);
					 }
					 
					 
					 
				 
				  
				
				 	if($special_price == '1'){
					if($_basePrice == $_discountPrice){ 
				 	$orginal_amount += $_formattedActualPrice * $item->getQty();
				 	$apply_only_qnt += $item->getQty();
				 	}
				 }
				 
				 // if($_formattedActualPrice == $_formattedActualPrice){ 
				 	if($special_price == '2'){
				 	$orginal_amount += $_formattedActualPrice * $item->getQty();
				 	$apply_only_qnt += $item->getQty();
				 	}
				 //}
				 
				 
			  // $orginal_amount += $_product->getPrice($_product, true) * $item->getQty();
			  
			  

			  
			  break 1;
			  exit();
			 }

		}


}

	
	
	
	$userCheck = explode(",", $user);
	
	$userCount = count($userCheck);
	
		for($u=0; $u<=$userCount; $u++)
		{
			 if($userCheck[$u] == $userId)
			 { 
			  $rightUser = $userCheck[$u]; 
			 }
		}
	 
	
/*	}else{
	 $rightUser = "0";	
	}*/
	// echo 'aaa'.$userId;
	// echo 'bbb'.$rightUser;
	
	// Mage::getSingleton('core/session')->getCouponMessage();
	

////////////////////////////////////////////
$productLevel = explode("|", $product_level);
$discountLevel = explode("|", $discount_level);
// echo count($productLevel);

 $product_level;
 $prroductLevelCount = count($productLevel);
 $discountLevel[0]."|".$discountLevel[1]."|".$discountLevel[2];
// echo $prroductLevelCount;
$total_product_qnt = ceil($apply_only_qnt);
//////////////// << COUPON FETCH /////////////////////////////////////















	if($coupon)
	{
		
		if(ceil($totalQuantity) >= $no_of_prd) 	// Number Of Quantity
		{ 
		
			if($orginal_amount >= $min_amnt) 	// Minimum Amount 
			{ 
		
				if($sessionCustomer->isLoggedIn()) 
				{
			
  					if($rightUser == $userId || $user == "") 	// User Id 
					{ 
			
						if($action=="1")	// Percentage or Fixed Price
						{
							

							
						if($product_level != ""){
							
							if($total_product_qnt == "1"){
									$orginal_amount; // 'Total Orginal Amount : '
									$one_percent = $orginal_amount/100; // One Percent
									$amt = $one_percent * $discountLevel[0];
									$discountAmount = $amt;
									$discountInput = $discountAmount;
							} else if($total_product_qnt == "2"){
								$orginal_amount; // 'Total Orginal Amount : '
									$one_percent = $orginal_amount/100; // One Percent
									$amt = $one_percent * $discountLevel[1];
									$discountAmount = $amt;
									$discountInput = $discountAmount;
							} else if($total_product_qnt >= "3"){	
									$orginal_amount; // 'Total Orginal Amount : '
									$one_percent = $orginal_amount/100; // One Percent
									$amt = $one_percent * $discountLevel[2];
									$discountAmount = $amt;
									$discountInput = $discountAmount;
							}
								
							
								
						 } else if($product_level == ""){
							
							
							$orginal_amount; // 'Total Orginal Amount : '
							$one_percent = $orginal_amount/100; // One Percent
							$amt = $one_percent * $discount_amount;
							$discountAmount = $amt;
							// $discountInput = -$discountAmount;
							
							$after1st_discount = $orginal_amount - $discountAmount;
							$one_percent2 = $after1st_discount/100; // One Percent
							$amt2 = $one_percent2 * $discount_amount2;
							$discountAmount2 = $amt2+$amt;
							// $discountInput = -$discountAmount2;
							
							$after2nd_discount = $orginal_amount - $discountAmount2;
							$one_percent3 = $after2nd_discount/100; // One Percent
							$amt3 = $one_percent3 * $discount_amount3;
							$discountAmount3 = $amt3+$amt2+$amt;
							// $discountInput = -$discountAmount3;
							
							$after3nd_discount = $orginal_amount - $discountAmount3;
							$one_percent4 = $after3nd_discount/100; // One Percent
							$amt4 = $one_percent4 * $discount_amount4;
							$discountAmount4 = $amt4+$amt3+$amt2+$amt;
							// $discountInput = $discountAmount4;
							
							
							if(count($multyCup)==1)
							{
							 $discountInput = $discountAmount;
							} else if(count($multyCup)==2){
							 $discountInput = $discountAmount2;
							} else if(count($multyCup)==3){
							 $discountInput = $discountAmount3;
							} else if(count($multyCup)==4){
							 $discountInput = $discountAmount4;
							}

						}
							
							
							
							Mage::getSingleton('core/session')->setDiscountMessage(-$discountInput);
							$discount = Mage::getSingleton('core/session')->getDiscountMessage();
							
						} else if($action=="2"){
			
							
							
						  if(count($multyCup)==1)
							{
							 $discountAmount = $discount_amount;
							 $discountInput = $discountAmount;
							} else if(count($multyCup)==2){
							 $discountAmount2 = $discount_amount2+$discount_amount;
							 $discountInput = $discountAmount2;
							} else if(count($multyCup)==3){
							 $discountAmount3 = $discount_amount3+$discount_amount2+$discount_amount;
							 $discountInput = $discountAmount3;
							} else if(count($multyCup)==4){
							 $discountAmount4 = $discount_amount4+$discount_amount3+$discount_amount2+$discount_amount;
							 $discountInput = $discountAmount4;
							}
							
						// }
							
							Mage::getSingleton('core/session')->setDiscountMessage(-$discountInput);
							$discount = Mage::getSingleton('core/session')->getDiscountMessage();
							
						}
					}
				
				} else {
						
					  if($userCheck[0] == "0" || $userCheck[0] == "") 	// User Id 
					  { 
					
   						if($action=="1")	// Percentage or Fixed Price
						{
							
						
							
							if($product_level != ""){
							
							if($total_product_qnt == "1"){
								// if($productLevel[0]=="1"){
									$orginal_amount; // 'Total Orginal Amount : '
									$one_percent = $orginal_amount/100; // One Percent
									$amt = $one_percent * $discountLevel[0];
									$discountAmount = $amt;
									$discountInput = $discountAmount;
								//}
							} else if($total_product_qnt == "2"){
								$orginal_amount; // 'Total Orginal Amount : '
									$one_percent = $orginal_amount/100; // One Percent
									$amt = $one_percent * $discountLevel[1];
									$discountAmount = $amt;
									$discountInput = $discountAmount;
							} else if($total_product_qnt >= "3"){	
									$orginal_amount; // 'Total Orginal Amount : '
									$one_percent = $orginal_amount/100; // One Percent
									$amt = $one_percent * $discountLevel[2];
									$discountAmount = $amt;
									$discountInput = $discountAmount;
							}
								
						 } else if($product_level == ""){	
							
					
							
							$orginal_amount; // 'Total Orginal Amount : '
							$one_percent = $orginal_amount/100; // One Percent
							$amt = $one_percent * $discount_amount;
							$discountAmount = $amt;
							// $discountInput = -$discountAmount;
							
							$after1st_discount = $orginal_amount - $discountAmount;
							$one_percent2 = $after1st_discount/100; // One Percent
							$amt2 = $one_percent2 * $discount_amount2;
							$discountAmount2 = $amt2+$amt;
							// $discountInput = -$discountAmount2;
							
							$after2nd_discount = $orginal_amount - $discountAmount2;
							$one_percent3 = $after2nd_discount/100; // One Percent
							$amt3 = $one_percent3 * $discount_amount3;
							$discountAmount3 = $amt3+$amt2+$amt;
							// $discountInput = -$discountAmount3;
							
							$after3nd_discount = $orginal_amount - $discountAmount3;
							$one_percent4 = $after3nd_discount/100; // One Percent
							$amt4 = $one_percent4 * $discount_amount4;
							$discountAmount4 = $amt4+$amt3+$amt2+$amt;
							// $discountInput = $discountAmount4;
							

							
							
							if(count($multyCup)==1)
							{
							 $discountInput = $discountAmount;
							} else if(count($multyCup)==2){
							 $discountInput = $discountAmount2;
							} else if(count($multyCup)==3){
							 $discountInput = $discountAmount3;
							} else if(count($multyCup)==4){
							 $discountInput = $discountAmount4;
							}

							
						 }
							
							Mage::getSingleton('core/session')->setDiscountMessage(-$discountInput);
							$discount = Mage::getSingleton('core/session')->getDiscountMessage();
							
						} else if($action=="2"){
							

							if(count($multyCup)==1)
							{
							 $discountAmount = $discount_amount;
							 $discountInput = $discountAmount;
							} else if(count($multyCup)==2){
							 $discountAmount2 = $discount_amount2+$discount_amount;
							 $discountInput = $discountAmount2;
							} else if(count($multyCup)==3){
							 $discountAmount3 = $discount_amount3+$discount_amount2+$discount_amount;
							 $discountInput = $discountAmount3;
							} else if(count($multyCup)==4){
							 $discountAmount4 = $discount_amount4+$discount_amount3+$discount_amount2+$discount_amount;
							 $discountInput = $discountAmount4;
							}
							
							
							
							
							Mage::getSingleton('core/session')->setDiscountMessage(-$discountInput);
							$discount = Mage::getSingleton('core/session')->getDiscountMessage();
							
						}
					  }
				 }	
				 
				 
				 
				 
				 
		
			}
			
	    }
		
	} 
        
      
        
$discountCoupon = Mage::getSingleton('core/session')->getDiscountMessage();
//echo "<br />";
//$discountCoupon1 = Mage::helper('core')->currency($discountCoupon,false,false);
//echo "|";
//$_SESSION['discountCoupon'] = Mage::helper('core')->currency($discountCoupon,false,false);
$GLOBALS['discountCoupon'] = $discountCoupon;
// header('Location:http://www.sareees.com/checkout/cart/');




$currencyModel = Mage::getModel('directory/currency');
$currencies = $currencyModel->getConfigAllowCurrencies();
$baseCurrencyCode = Mage::app()->getStore()->getBaseCurrencyCode();
$defaultCurrencies = $currencyModel->getConfigBaseCurrencies();
$rates=$currencyModel->getCurrencyRates($defaultCurrencies, $currencies);
$currentCurrency = Mage::app()->getStore()->getCurrentCurrencyCode();
//echo "<br />";
$convertionrate = Mage::helper('directory')->currencyConvert('1', 'USD', $currentCurrency);
//echo "<br />";

$_SESSION['discountCoupon'] = $discountCoupon; 
$baseDiscountCoupon = $discountCoupon / $convertionrate;
$_SESSION['baseDiscountCoupon'] = $baseDiscountCoupon;



Mage::getSingleton('core/session')->setBasediscountcouponMessage($baseDiscountCoupon);
Mage::getSingleton('core/session')->getBasediscountcouponMessage();


//exit;
// "<br />";
 if($_REQUEST['coupon_code']=="Apply Coupon"){
?>
        <script>
	  window.location="<?php echo Mage::getBaseUrl(); ?>checkout/cart/?coupon=<?php echo $_REQUEST['coupon']; ?>&coupon_code=<?php echo $_REQUEST['coupon_code']; ?>";
	</script>
<?php
 }
?>


<!--COUPON CODE <<-->


<?php 
/* if($_REQUEST['notHere']=="notHere")
 {
	       ?>
        
        <script>
	  window.location="<?php echo Mage::getBaseUrl(); ?>checkout/cart/?notHere=notHere";
	</script>
        
        

      <?php 
	 
 }*/

?>



<?php ///////// For Cart Page
if($_REQUEST['coupon']=='destroy'){
//if($_REQUEST['delete_code']!=''){


	  Mage::getSingleton('core/session')->unsDiscountMessage();
      Mage::getSingleton('core/session')->unsCouponMessage();
      
      

      ?>
        
        <script>
	  window.location="<?php echo Mage::getBaseUrl(); ?>checkout/cart/";
	</script>
        
        

      <?php 
	}
	


?>


        
        <?php //} 
        
        
//        	 $cartUpdate  = Mage::getSingleton('core/session')->getCartupdateMessage();
//	 $oldQuantity = Mage::getModel('checkout/cart')->getQuote()->getItemsQty();
//	 $cart_qty = (int) Mage::getModel('checkout/cart')->getQuote()->getItemsQty();

//if($cart_qty) {
//	
//	if($cartUpdate != $oldQuantity)
//	{
//	  Mage::getSingleton('core/session')->unsDiscountMessage();
//          Mage::getSingleton('core/session')->unsCouponMessage();
//	  Mage::getSingleton('core/session')->unsCartupdateMessage();
//	  $cartUpdate = Mage::getSingleton('core/session')->getCartupdateMessage();
//	  echo $cart_qty = (int) Mage::getModel('checkout/cart')->getQuote()->getItemsQty();
//
//if($cart_qty) {
//    //exit(); 
//?>

<?php
//} 
//
//
//	}
//	
//}
        
        
        ?>



<?php
            
        }
	

 
	
		
}