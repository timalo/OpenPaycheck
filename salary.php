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

                    //check if user has already returned
                    $memberNum = $_GET["num"];
                    $queriedMemReturned = "SELECT hasReturned FROM groups WHERE linkKey=\"$memberNum\"";
                    $result = $conn->query($queriedMemReturned);
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            $hasReturned = $row["hasReturned"];
                        }
                        if ($hasReturned == 1) {
                            header("Location: wrongKey.html");
                        }              
                    }

                    $conn->close();
                ?>

                <?php

                if(isset($_POST['submit']))
                {		
                    $salary = $_POST['salary'];
                    //Connect to database
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "test";

                    $conn = new mysqli($servername, $username, $password, $dbname);
                    if($conn ->connect_error) {
                        die("Connection failed: " .$conn->connect_error);
                    }


                    // Get userGroup from db
                    $memberNum = $_GET["num"];
                    echo $memberNum;
                    $userGroupQuery = "SELECT userGroup FROM groups WHERE linkKey=\"$memberNum\"";
                    $result = $conn->query($userGroupQuery);
                    if(mysqli_num_rows($result) == 0) {
                        echo "No userGroup found in database!\n";
                    }
                    
                    if (mysqli_num_rows($result) > 0) {
                        // output data of each row
                        while($row = mysqli_fetch_assoc($result)) {
                            $userGroup = $row["userGroup"];
                        }
                    }
                    else {
                        echo "0 results userGroup\n";
                    }


                    // Get salarySum from db
                    $salarySum = 0;
                    $salarySumQuery = "SELECT salarySum FROM users WHERE userGroup=\"$userGroup\"";
                    $result = $conn->query($salarySumQuery);
                    if(mysqli_num_rows($result) == 0) {
                        echo "No salarySum found in database!\n";
                    }
                    if (mysqli_num_rows($result) > 0) {
                        // output data of each row
                        while($row = mysqli_fetch_assoc($result)) {
                          $salarySum = $row["salarySum"];
                        }
                      } else {
                        echo "0 results for salarySum\n";
                      }

                    //Add salary to salarySum and to db
                    $userKeySalary = $_GET["x"];
                    $salarySum += ($salary + $userKeySalary);

                    $updateSumQuery = mysqli_query($conn, "UPDATE users SET salarySum=$salarySum WHERE userGroup=\"$userGroup\" ");

                    if(!$updateSumQuery)
                    {
                        echo "No records added!\n";
                    }
                    else
                    {
                        echo "Records for salarySum added successfully.\n";
                    }


                    //Update to db that user has returned
                    $memberNum = $_GET["num"];
                    $updateHasReturned = mysqli_query($conn, "UPDATE groups SET hasReturned=1 WHERE linkKey=\"$memberNum\" ");
                    
                    if(!$updateHasReturned)
                        {
                           echo "No records added!\n";
                        }
                        else
                        {
                        echo "Records for hasReturned added successfully.\n";
                        }


                    // Get groupSize from db
                    $groupSize = 0;
                    $groupSizeQuery = "SELECT groupSize FROM users WHERE userGroup=\"$userGroup\"";
                    $result = $conn->query($groupSizeQuery);
                    if(mysqli_num_rows($result) == 0) {
                        echo "No groupSize found in database!\n";
                    }
                    if (mysqli_num_rows($result) > 0) {
                        // output data of each row
                        while($row = mysqli_fetch_assoc($result)) {
                          $groupSize = $row["groupSize"];
                        }
                      } else {
                        echo "0 results groupSize\n";
                      }


                    // Get returnedAmount from db
                    $returnedAmount = 0;
                    $returnedAmountQuery = "SELECT returnedAmount FROM users WHERE userGroup=\"$userGroup\"";
                    $result = $conn->query($returnedAmountQuery);
                    if(mysqli_num_rows($result) == 0) {
                        echo "No returnedAmount found in database!\n";
                    }
                    
                    if (mysqli_num_rows($result) > 0) {
                        // output data of each row
                        while($row = mysqli_fetch_assoc($result)) {
                          $returnedAmount = $row["returnedAmount"];
                        }
                      } else {
                        echo "0 results returnedAmount\n";
                      }

                      //Add person to returnedAmount and to db
                      $returnedAmount += 1;

                      $updateReturnedAmount = mysqli_query($conn, "UPDATE users SET returnedAmount=$returnedAmount WHERE userGroup=\"$userGroup\" ");

                        if(!$updateReturnedAmount)
                        {
                            echo "No records added!\n";
                        }
                        else
                        {
                            echo "Records for returnedAmount added successfully.\n";
                        }


                        // Add personKeyPieceValue to shares
                        $userNum = $_GET["z"];
                        $personKeyPiece = $_GET["y"];
                        $saveSharesQuery = "UPDATE shares SET personKeyPiece=$personKeyPiece WHERE userGroup=\"$userGroup\" AND userNum=$userNum";
                        $conn->query($saveSharesQuery);


                        // See if everyone has returned
                        if ($returnedAmount == $groupSize) 
                        {

                            // Get emails from db 
                            $email_to = "SELECT userEmail FROM groups WHERE userGroup=\"$userGroup\"";
                            $result = $conn->query($email_to);
                            if(mysqli_num_rows($result) == 0) {
                                echo "No userEmail found in database!\n";
                            }
                            
                            if (mysqli_num_rows($result) > 0) {
                                // output data of each row
                                while($row = mysqli_fetch_assoc($result)) {
                                $to = $row["userEmail"];
                                }
                            } else {
                                echo "0 results for userEmail\n";
                            }
                            $from = "openpaycheck.send@gmail.com";
                            $headers = "From:" . $from;
                            $subject = "OpenPayCheck Results";
                            $message = "Hi! \n\nThe results of salary comparison in group: $userGroup can be found at: \n\nhttp://localhost/OpenPaycheck/results.php?num=$memberNum  \n\nBest Regards,\nOpenPayCheck";
                            mail($to,$subject,$message, $headers);
                            echo "Everyone has returned!";   
                            header("Location: http://localhost/OpenPaycheck/results.php?num=$memberNum");
                            
                            
                        } else {
                            echo "Everyone needs to give value before results.";
                            }

                    $conn->close();

                    
                }

                
                ?>

                <p>Please enter your salary information.</p>
                <div class="infoDiv">
                    <div id="infoContent">
                        Enter your salary as hourly, monthly, or yearly wage.<br>
                        <form method="POST" id="salaryInputDiv">
                            <input type="number" id="salaryInput" name="salary" min=0 step=50> <span style="color:green;"> €</span> / 
                            <select name="salaryTime" id="salaryTime" onchange="toggleHours()">
                                <option value="hour">Hour</option>
                                <option selected value="month">Month</option>
                                <option value="year">Year</option>
                            </select> </br>
                            <div id="hoursPerWeek" style="font-size: 22">
                                How many hours per month do you work?<br>
                                <input type="number" min=1 style="width:15%; margin-top: 10px"> h
                            </div> 
                            <input type="submit" name="submit" value="Submit">
                            <!-- <button onclick="handleSalary()" id="submitSalaryBtn">Submit</button> -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="salary.js"></script>
    </body>
</html>