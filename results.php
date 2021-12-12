<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="styles.css">
        <title>OpenPayCheck</title>
        <script src="jquery.js"></script>
    </head>
    <body>
        <h1><a href="index.html" class="frontPageLink">OpenPayCheck</a></h1>
        <div id="container">
            <div id="content">
                <?php
                    require('Scheme.php');
                    require('Share.php');
                    require('FiniteFieldLagrange.php');
                    //Shamir's Secret Sharing implementation
                    //https://github.com/lt/PHP-Shamirs

                    //Connect to database
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "test";

                    // (2**128)+51 - Smallest prime that covers all 128 bit secrets (i.e. AES keys)
                    const P128 = '0x100000000000000000000000000000033';
                    $prime = gmp_init(P128);

                    $conn = new mysqli($servername, $username, $password, $dbname);
                    if($conn ->connect_error) {
                        die("Connection failed: " .$conn->connect_error);
                    }
                    //-------------------------
                    
                    //check member number from link parameter
                    $memberNum = $_GET["num"];
                    $queriedMemNum = "SELECT linkKey FROM users WHERE linkKey=\"$memberNum\"";
                    $result = $conn->query($queriedMemNum);
                    if(mysqli_num_rows($result) == 0) {
                        header("Location: wrongKey.html");
                    }

                    $group = "SELECT groupID FROM users WHERE linkKey=\"$memberNum\"";
                    $result = $conn->query($group);
                    if(mysqli_num_rows($result) == 0) {
                       // echo "No group found in database!";
                    }
                    
                    if (mysqli_num_rows($result) > 0) {
                        // output data of each row
                        while($row = mysqli_fetch_assoc($result)) {
                          $groupID = $row["groupID"];
                        }
                      } else {
                       // echo "0 results";
                      }
                
                    // Get salarySum from db:
                    $salaryResult = 0;
                    $salarySum = 0;
                    $salarySumQuery = "SELECT salarySum FROM groups WHERE groupID=\"$groupID\"";
                    $result = $conn->query($salarySumQuery);
                    if(mysqli_num_rows($result) == 0) {
                      //  echo "No salarySum found in database for group average!";
                    }
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                          $salarySum += $row["salarySum"];
                        }
                      } else {
                       // echo "0 results for salarySum";
                      }


                    // Get groupSize from db:
                    $groupSize = 0;
                    $groupSizeQuery = "SELECT groupSize FROM groups WHERE groupID=\"$groupID\"";
                    $result = $conn->query($groupSizeQuery);
                    if(mysqli_num_rows($result) == 0) {
                       // echo "No groupSize found in database for group average!";
                    }
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                          $groupSize += $row["groupSize"];
                        }
                      } else {
                        // echo "0 results for groupSize";
                      }


                    // Get shares from db:
                    $shareValues = [];
                    $shareNumbers = [];
                    $shares = []; //The final list with share objects in it
                    $shareValueQuery = "SELECT personKeyPiece FROM shares WHERE groupID=\"$groupID\"";
                    $result = $conn->query($shareValueQuery);
                    if(mysqli_num_rows($result) == 0) {
                        // echo "No shareValues found in database for group average!";
                    }
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                          array_push($shareValues, $row["personKeyPiece"]);
                        }
                    } else {
                      // echo "0 results for shares";
                    }

                    $shareNumQuery = "SELECT userNum FROM shares WHERE groupID=\"$groupID\"";
                    $result = $conn->query($shareNumQuery);
                    if(mysqli_num_rows($result) == 0) {
                        // echo "No shareNums found in database for group average!";
                    }
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                          array_push($shareNumbers, $row["userNum"]);
                        }
                    } else {
                      // echo "0 results for shares";
                    }
                    
                    for($i = 0; $i < count($shareValues); $i++) {
                      $newShareValue = gmp_init($shareValues[$i]);
                      $newShareNum = ($shareNumbers[$i]);
                      $newShare = new \SSSS\Share($newShareNum, $newShareValue);
                      array_push($shares, $newShare);
                    }
                    

                    $scheme = new \SSSS\Scheme($prime);

                    $secret = $scheme->recoverSecret($shares);
                    $secretInt = gmp_intval($secret);


                    // Count average salary:
                    $salaryResult = 0;
                    $salaryResult = ($salarySum - $secretInt) / $groupSize;




                      echo "     <div id='content'>
                      <p>Here are the results:</p>
                      <div class='infoDiv'>
                         <p>Group average salary:</p> 
                         <div id='average' >$salaryResult <span style='color:green;'> €</span> / month</div>";

                    $conn->close();
                ?>
            </div>
       
        </div>
        <script src="salary.js"></script>
    </body>
</html>