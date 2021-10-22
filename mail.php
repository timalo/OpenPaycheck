<?php

$to = $_POST['email'];
$from = "openpaycheck.send@gmail.com";
$subject = "OpenPayCheck Invitation";
$group = $_POST['group_name'];

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

    $message = "Hi! \n\nYou have been invited to compare salary information in a group: $group  \nFollow this link to give your information:\n\nhttp://localhost/OpenPaycheck/salary.php?num=$key  \n\nBest Regards,\nOpenPayCheck";

    //save linkKey to db
    $saveKeyQuery = "INSERT INTO users (userEmail, linkKey, userGroup) VALUES ('$to[$i]', '$key', '$group')";
    $conn->query($saveKeyQuery);
    mail($to[$i],$subject,$message, $headers);
}

$conn->close();


header("Location: http://localhost/OpenPaycheck/emailConfirmation.html");

?>