<?php


  

$from = "tonykfc@lkybast.com";
$to = "ville.lahdenp@hotmail.fi";
$subject = "PHP Mail Test script";
$message = "This is a test to check the PHP Mail functionality";
$headers = "From:" . $from;
mail($to,$subject,$message, $headers);
echo "Test email sent";



?>