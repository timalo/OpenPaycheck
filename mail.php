<?php

$perse = $_POST['email'];
echo "JEEE ";

echo implode(", ", $perse);
$from = "tonykfc@lkybast.com";
$to = "limpeh@lkybast.com";
$subject = "PHP Mail Test script";
$message = "This is a test to check the PHP Mail functionality";
$headers = "From:" . $from;

for ($i = 0; $i < count($perse); $i++) {
    mail($perse[$i],$subject,$message, $headers);
}

echo "Test email sent";

?>