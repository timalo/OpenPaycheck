<?php

$to = $_POST['email'];
echo "JEEE ";

echo implode(", ", $to);

$from = "tonykfc@lkybast.com";

$subject = "PHP Mail Test script";
$group = $_POST['group_name'];
echo $group;
$message = "You have been invited to compare salary information in a group: $group  Follow this link to give your information: http://localhost:8888/OpenPaycheck/salary.html";

$headers = "From:" . $from;

for ($i = 0; $i < count($to); $i++) {
    mail($to[$i],$subject,$message, $headers);
}

echo "Test email sent";

?>