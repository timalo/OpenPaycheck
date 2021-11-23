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
            <div id="sidebar">
                <div id="menuItem1" class="menuItem">
                    Menuitem
                </div>
                <div id="menuItem2" class="menuItem">
                    Menuitem 2
                </div>
                <div id="menuItem2" class="menuItem">
                    Test menuitem 3
                </div>
            </div>
            <div id="content">
                <?php
                    //Connect to database
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "test";

                    $conn = new mysqli($servername, $username, $password, $dbname);
                    if($conn ->connect_error) {
                        die("Connection failed: " .$conn->connect_error);
                    }
                    //-------------------------
                    
                    //check member number from link parameter
                    $memberNum = $_GET["num"];
                    $queriedMemNum = "SELECT linkKey FROM groups WHERE linkKey=\"$memberNum\"";
                    $result = $conn->query($queriedMemNum);
                    if(mysqli_num_rows($result) == 0) {
                        header("Location: wrongKey.html");
                    }

                    $group = "SELECT userGroup FROM groups WHERE linkKey=\"$memberNum\"";
                    $result = $conn->query($group);
                    if(mysqli_num_rows($result) == 0) {
                        echo "No group found in database!";
                    }
                    
                    if (mysqli_num_rows($result) > 0) {
                        // output data of each row
                        while($row = mysqli_fetch_assoc($result)) {
                          $groupname = $row["userGroup"];
                        }
                      } else {
                        echo "0 results";
                      }
                
                    // Get salarySum from db:
                    $salaryResult = 0;
                    $salarySum = 0;
                    $salarySumQuery = "SELECT salarySum FROM users WHERE userGroup=\"$groupname\"";
                    $result = $conn->query($salarySumQuery);
                    if(mysqli_num_rows($result) == 0) {
                        echo "No salarySum found in database for group average!";
                    }
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                          $salarySum += $row["salarySum"];
                        }
                      } else {
                        echo "0 results for salarySum";
                      }



                    // Get groupSize from db:
                    $groupSize = 0;
                    $groupSizeQuery = "SELECT groupSize FROM users WHERE userGroup=\"$groupname\"";
                    $result = $conn->query($groupSizeQuery);
                    if(mysqli_num_rows($result) == 0) {
                        echo "No groupSize found in database for group average!";
                    }
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                          $groupSize += $row["groupSize"];
                        }
                      } else {
                        echo "0 results for groupSize";
                      }


                    // Get shares from db:
                    $shares = [];
                    $sharesQuery = "SELECT personKeyPiece FROM shares WHERE userGroup=\"$groupname\"";
                    $result = $conn->query($keySalaryQuery);
                    if(mysqli_num_rows($result) == 0) {
                        echo "No shares found in database for group average!";
                    }
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                          array_push($shares, $row["personKeyPiece"];
                        }
                      } else {
                        echo "0 results for shares";
                      }

                      $secret = $scheme->recoverSecret($shares);


                      // Count average salary:
                      $salaryResult = 0;
                      $salaryResult = ($salarySum - $secret) / $groupSize;


/*
                      // Your salary
                      $salary = 0;
                      $yourSalaryResult = 0;
                      $yourSalaryData = "SELECT salaryData FROM salary WHERE linkKey=\"$memberNum\"";
                      $result = $conn->query($yourSalaryData);
                      if(mysqli_num_rows($result) == 0) {
                        echo "No salaryData found in database for yourSalaryData!";
                    }
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                          $salary += $row["salaryData"];
                        }
                        $yourSalaryResult = $salary;
                      } else {
                        echo "0 results for yourSalaryData";
                      }


                      // Difference of group and your salary:
                        $difference = $yourSalaryResult - $salaryResult;
                        if ($difference > 0) {
                            $difference = "+". $difference;
                        }

*/


                      echo "     <div id='content'>
                      <p>Here are the results:</p>
                      <div class='infoDiv'>
                         <p>Group average salary:</p> 
                         <div id='average' >$salaryResult <span style='color:green;'> €</span> / month</div>
                         <p>Your salary:</p> 
                         <div id='salary' >yourSalaryResult <span style='color:green;'> €</span> / month</div>
                         <p>Difference of your and group average:</p> 
                         <div id='salary' >difference <span style='color:green;'> €</span> / month</div>
                      </div>
                        </div>";

                    $conn->close();
                ?>
            </div>
       
        </div>
        <script src="salary.js"></script>
    </body>
</html>