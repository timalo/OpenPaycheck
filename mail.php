<?php

require('Scheme.php');
require('Share.php');
require('FiniteFieldLagrange.php');

$to = $_POST['email'];
$from = "openpaycheck.send@gmail.com";
$subject = "OpenPayCheck Invitation";
$group = $_POST['group_name'];

// (2**128)+51 - Smallest prime that covers all 128 bit secrets (i.e. AES keys)
const P128 = '0x100000000000000000000000000000033';
$prime = gmp_init(P128);

$keySalary = 0;
$salarySum = 0;
$group_size = 0;
$returnedAmount = 0;
$personkeySalaries = [];
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

    array_push($personkeySalaries, $personKeySalary);

    $keySalary += $personKeySalary;
    $group_size += 1;
}

$secret = gmp_init($keySalary);
$requiredShares = $group_size; // k
$initialShares = $group_size;  // n

$scheme = new \SSSS\Scheme($prime);
$shares = $scheme->initialShares($secret, $requiredShares, $initialShares);

for ($i = 0; $i < count($to); $i++) {
    //generate unique user key
    $key = md5((uniqid()));
    $personKeyValue = ($shares[$i+1])->value(); //use share class value function in order to assign the secret value
    $personKeyNumber = ($shares[$i+1])->number(); //same for number
    $personKeySalary = $personkeySalaries[$i];

    //save emails and group to db
    $saveEmailsQuery = "INSERT INTO groups (userEmail, userGroup, linkKey) VALUES ('$to[$i]', '$group', '$key')";
    $conn->query($saveEmailsQuery);

    //save userNum and group to db
    $j = $i + 1; //start userNums from 1, since share class starts user numbers from 1
    $saveSharesQuery = "INSERT INTO shares (userNum, userGroup) VALUES ('$j', '$group')"; //save userNum and group to database, no userKeyValue yet, since we get that later in the salary submit
    $conn->query($saveSharesQuery);

    //send email
    $message = "Hi! \n\nYou have been invited to compare salary information in a group: $group  \nFollow this link to give your information:\n\nhttp://localhost/OpenPaycheck/salary.php?num=$key&x=$personKeySalary&y=$personKeyValue&z=$personKeyNumber  \n\nBest Regards,\nOpenPayCheck";
    mail($to[$i],$subject,$message, $headers);
}


//save linkKey and salary to db
$saveKeyQuery = "INSERT INTO users (salarySum, userGroup, groupSize, returnedAmount) VALUES ('$salarySum', '$group', '$group_size', '$returnedAmount')";
$conn->query($saveKeyQuery);

$conn->close();

header("Location: http://localhost/OpenPaycheck/emailConfirmation.html");

?>