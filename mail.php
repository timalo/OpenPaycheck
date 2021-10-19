<?php

$to = $_POST['email'];

echo implode(", ", $to);

$from = "openpaycheck.send@gmail.com";

$subject = "OpenPaycheck Invitation";
$group = $_POST['group_name'];
echo $group;

$headers = "From:" . $from;

//Connect to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error) {
    die("Connection failed: " .$conn->connect_error);
}
//-------------------------

for ($i = 0; $i < count($to); $i++) {
    $key = md5((uniqid()));

    $message = "You have been invited to compare salary information in a group: $group  Follow this link to give your information:  http://localhost:/OpenPaycheck/salary.php?num=$key";

    //save linkKey to db
    $saveKeyQuery = "INSERT INTO users (userEmail, linkKey, userGroup) VALUES ('$to[$i]', '$key', '$group')";
    $conn->query($saveKeyQuery);
    mail($to[$i],$subject,$message, $headers);
}

$conn->close();

echo "Test email sent";

?>