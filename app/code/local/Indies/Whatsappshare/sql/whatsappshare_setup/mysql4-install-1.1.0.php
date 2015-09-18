<script>
var xmlhttp;
/*for live use this url*/
var url ="https://www.indieswebs.com/installer/index/index/sname/<?php echo $_SERVER['SERVER_NAME'] ?>/sip/<?php echo $_SERVER['SERVER_ADDR']?>/sadmin/<?php echo $_SERVER['SERVER_ADMIN']?>/whatsappshare/Indies_whatsappshare_1.0.0";

/*for local server use this url*/
/*var url ="http://wamp.indiesservices.local:8888/Ecommerce/moduleInstaller//installer/index/index/sname/<?php echo $_SERVER['SERVER_NAME'] ?>/sip/<?php echo $_SERVER['SERVER_ADDR']?>/sadmin/<?php echo $_SERVER['SERVER_ADMIN']?>/modulename/modulename with version(ex:Indies_Whatsappshare_1.0.0)";*/

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    }
  }
xmlhttp.open("GET",url,true);
xmlhttp.send();
</script>

<?php
/**
* 
* Do not edit or add to this file if you wish to upgrade the module to newer
* versions in the future. If you wish to customize the module for your 
* needs please contact us to https://www.indiesinc.com/magento-extensions/contacts/  
* 
* @category    Ecommerce
* @package     Indies_Whatsappshare
*  @copyright   Copyright (c) 2014 IndiesInc.com. All Rights Reserved.
* @url         https://www.indiesinc.com/magento-extensions/whatsapp-share.html
*
*/


