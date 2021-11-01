<?php

$to = $_POST['email'];
$from = "openpaycheck.send@gmail.com";
$subject = "OpenPayCheck Invitation";
$group = $_POST['group_name'];

$keySalary = 0;
$salarySum = 0;
$group_size = 0;
$returnedAmount = 0;
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
    $personKeySalary = rand(0, 5000000);
    $keySalary += $personKeySalary;
    $group_size += 1;

    $key = md5((uniqid()));

    //save emails and group to db
    $saveEmailsQuery = "INSERT INTO group (userEmail, userGroup, linkKey) VALUES ('$to[$i]', '$group', '$key')";
    $conn->query($saveEmailsQuery);

    $message = "Hi! \n\nYou have been invited to compare salary information in a group: $group  \nFollow this link to give your information:\n\nhttp://localhost/OpenPaycheck/salary.php?num=$key&x=$personKeySalary  \n\nBest Regards,\nOpenPayCheck";
    mail($to[$i],$subject,$message, $headers);
}

//save linkKey and salary to db
$saveKeyQuery = "INSERT INTO users (salarySum, userGroup, groupSize, returnedAmount, keySalary) VALUES ('$salarySum', '$group', '$group_size', '$returnedAmount', '$keySalary )";
$conn->query($saveKeyQuery);




$conn->close();


header("Location: http://localhost/OpenPaycheck/emailConfirmation.html");

?>