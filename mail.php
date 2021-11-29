<?php

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

$secret = gmp_import($keySalary);
$requiredShares = $group_size; // k
$initialShares = $group_size;  // n

$scheme = new \SSSS\Scheme($prime);
$shares = $scheme->initialShares($secret, $requiredShares, $initialShares);

for ($i = 0; $i < count($to); $i++) {

    $key = md5((uniqid()));
    $personKeyPiece = $shares[$i];
    $personKeySalary = $personkeySalaries[$i];

    //save emails and group to db
    $saveEmailsQuery = "INSERT INTO groups (userEmail, userGroup, linkKey) VALUES ('$to[$i]', '$group', '$key')";
    $conn->query($saveEmailsQuery);

    //save userNum and group to db
    $saveSharesQuery = "INSERT INTO shares (userNum, userGroup) VALUES ('$i', '$group')";
    $conn->query($saveSharesQuery);


    $message = "Hi! \n\nYou have been invited to compare salary information in a group: $group  \nFollow this link to give your information:\n\nhttp://localhost/OpenPaycheck/salary.php?num=$key&x=$personKeySalary&y=$personkeyPiece&z=$i  \n\nBest Regards,\nOpenPayCheck";
    mail($to[$i],$subject,$message, $headers);
}


//save linkKey and salary to db
$saveKeyQuery = "INSERT INTO users (salarySum, userGroup, groupSize, returnedAmount, keySalary) VALUES ('$salarySum', '$group', '$group_size', '$returnedAmount', '$keySalary' )";
$conn->query($saveKeyQuery);






$conn->close();


header("Location: http://localhost/OpenPaycheck/emailConfirmation.html");

?>