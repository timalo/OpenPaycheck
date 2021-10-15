<?php

$to = $_POST['email'];
echo "JEEE ";

echo implode(", ", $to);

$from = "tonykfc@lkybast.com";

$subject = "PHP Mail Test script";
$group = $_POST['group_name'];
echo $group;

$headers = "From:" . $from;

for ($i = 0; $i < count($to); $i++) {
    $key = md5((uniqid()));
    $message = "You have been invited to compare salary information in a group: $group  Follow this link to give your information:  http://localhost/OpenPaycheck/salary.php?num=$key";

    mail($to[$i],$subject,$message, $headers);
}

echo "Test email sent";

?>