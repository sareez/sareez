<?php
$admin_email = "Admin"." <nabacse2005@gmail.com>";
$bcc = "nabagopal@babulall.com";

$to = 'nabacse2005@gmail.com';
$subject ="STANFORD RULES";

$body = "Hi!".'<br><br>';
$body .= "Name: Nabagopal Guria".'<br>';
$body .= "Profile Link: /info/113787".'<br>';
$body .= "Email: nabacse2005@gmail.com".'<br>';
$body .= 'Thank You';


$headers = 'From: '.$admin_email. "\r\n";
$headers .= 'Bcc: '.$bcc. "\r\n";
$headers .= 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

if(@mail($to,$subject,$body,$headers)){
    echo "Mail Send!!";
} else {
    echo "Mail Not Send!!";
}

?>