<?php
$to      = 'anik@babulall.com';
$subject = 'Test New Mail';
$message = 'This is a test Mail';
$headers = 'From: query@sareez.com' . "\r\n" .
    'Reply-To: query@sareez.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
?>