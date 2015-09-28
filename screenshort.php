<?php
//echo "<pre>"; print_r($_REQUEST); die;
if(isset($_REQUEST['name'])){
//echo "<pre>"; print_r($_REQUEST); 
//echo "<pre>"; print_r($_FILES); die;
//$org_img_nm = "";
	$from_mail = $_REQUEST['email'];
	$from_name = $_REQUEST['name'];
	$img = $from_name."-".$from_mail."-";
	if(is_uploaded_file($_FILES['img_upload']['tmp_name'])){
		
//========================= Start Image For Thumbnel Converting ===============================================
		$prod_fullimage = $img.$_FILES['img_upload']['name'];
		
//========================== End Image For Thumbnel Converting ===============================================
		
		move_uploaded_file($_FILES['img_upload']['tmp_name'], "screenshort/$prod_fullimage")or die("Failed to upload");
			
	} else {
	
		$prod_fullimage = "";
	}
	
	$filename = $prod_fullimage;
	//$path = "../news_file/";
	//$path = "screenshort/";
	$path = "/home/25359-16360.cloudwaysapps.com/hbanfvqkdv/public_html/screenshort/";
	$from_mail = $_REQUEST['email'];
	$from_name = $_REQUEST['name'];
	$feedback = $_REQUEST['feedback'];
	$replyto = "anowar@babulall.com";
	$subject = "Customer Feedback";
	$bcc = "asgar@babulall.com";
	$mailto = "nabagopal@babulall.com";
	
	$body			= "Customer feedback details".'<br><br>';
	$body			.= "Name: ".$_REQUEST['name'].'<br>';
	$body			.= "E-mail: ".$_REQUEST['email'].'<br>';
	$body			.= "Feedback: ".$_REQUEST['feedback'].'<br><br><br>';
	$body			.= "Image URL: http://www.sareez.com/screenshort/".$prod_fullimage.'<br><br><br>';
	$body			.= 'Thank You';
	
	$message = $body;
	/* ================== Mail send to Members =====================*/
	
	/*$header = 'From: '.$from_mail. "\r\n";
	$header .= 'Bcc: '.$bcc. "\r\n";
	$header .= 'MIME-Version: 1.0' . "\r\n";
	$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
    if(@mail($mailto,$subject,$message,$header)){
        echo "mail send ... OK"; 
    } else {
        echo "mail send ... ERROR!";
    }
	
	echo "Nabagopal"; die;*/
	
	
	//@mail_attachment($file,$path,$to,$from,$from_name,$replyto,$subject,$message);
	@mail_attachment($filename, $path, $mailto, $from_mail, $from_name, $replyto, $subject, $message,$cc="",$bcc);
	/* ================== Mail send to Members =====================*/

   $flag=2;
}	


function mail_attachment($filename, $path, $mailto, $from_mail, $from_name, $replyto, $subject, $message,$cc="",$bcc="") 
{
	//echo "HHHHHHHH".$from_name."<br/>";
    //echo $bcc; die();

    /*$file = $path.$filename;
    $file_size = filesize($file);
	//echo $file."HHH".$file_size; die;
    $handle = fopen($file, "r");
    $content = fread($handle, $file_size);
    fclose($handle);
    $content = chunk_split(base64_encode($content));
    $uid = md5(uniqid(time()));
    $name = basename($file);
    $header = "From: ".$from_name." <".$from_mail.">\r\n";
    $header .= "Reply-To: ".$replyto."\r\n";
    $header .= "Cc: ".$cc."\r\n";
    $header .= "Bcc: ".$bcc."\r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
    $header .= "This is a multi-part message in MIME format.\r\n";
    $header .= "--".$uid."\r\n";
    $header .= "Content-type:text/html; charset=iso-8859-1\r\n";
    $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $header .= $message."\r\n\r\n";
    $header .= "--".$uid."\r\n";
    $header .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"; // use diff. tyoes here
    $header .= "Content-Transfer-Encoding: base64\r\n";
    $header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
    $header .= $content."\r\n\r\n";
    $header .= "--".$uid."--";*/
	//echo $header."KK".$name; die;
	
	$header = 'From: '.$from_mail. "\r\n";
	$header .= 'Bcc: '.$bcc. "\r\n";
	$header .= 'MIME-Version: 1.0' . "\r\n";
	$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
    if(@mail($mailto,$subject,$message,$header)){
        echo "mail send ... OK"; 
    } else {
        echo "mail send ... ERROR!";
    }
	//die;
	
   /*if (mail($mailto,$subject,"",$header)) {
        echo "mail send ... OK"; 
    } else {
        echo "mail send ... ERROR!";
    }*/
	
	//die;
}

header("location:http://www.sareez.com/index.php");
?>