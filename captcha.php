<?php
//session_start();


function generateCaptcha(){
$RandomStr = md5(microtime());// md5 to generate the random string

$ResultStr = substr($RandomStr,0,5);//trim 5 digit 

$NewImage =imagecreatefromjpeg("img.jpg");//image create by existing image and as back ground 

$LineColor = imagecolorallocate($NewImage,233,239,239);//line color 
$TextColor = imagecolorallocate($NewImage, 255, 255, 255);//text color-white

imageline($NewImage,1,1,40,40,$LineColor);//create line 1 on image 
imageline($NewImage,1,100,60,0,$LineColor);//create line 2 on image 

imagestring($NewImage, 5, 20, 10, $ResultStr, $TextColor);// Draw a random string horizontally 

//$_SESSION['captcha'] = $ResultStr;// carry the data through session

//header("Content-type: image/jpeg");// out out the image 

//imagejpeg($NewImage);//Output image to browser 

return '<input disabled="disabled" size="5" type="text" name="label_captcha" value="'.$ResultStr.'" /><input type="hidden" name="hid_captcha" value="'.$ResultStr.'" />';

}

?>