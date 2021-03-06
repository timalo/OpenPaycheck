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
                    $queriedMemNum = "SELECT linkKey FROM users WHERE linkKey=\"$memberNum\"";
                    $result = $conn->query($queriedMemNum);
                    if(mysqli_num_rows($result) == 0) {
                        header("Location: wrongKey.html");
                    }

                    //check if user has already returned
                    $memberNum = $_GET["num"];
                    $queriedMemReturned = "SELECT hasReturned FROM users WHERE linkKey=\"$memberNum\"";
                    $result = $conn->query($queriedMemReturned);
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            $hasReturned = $row["hasReturned"];
                        }
                        if ($hasReturned == 1) {
                            header("Location: returned.html");
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

                    //check if user has already returned
                    $memberNum = $_GET["num"];
                    $queriedMemReturned = "SELECT hasReturned FROM users WHERE linkKey=\"$memberNum\"";
                    $result = $conn->query($queriedMemReturned);
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            $hasReturned = $row["hasReturned"];
                        }
                        if ($hasReturned != 0) {
                            header("Location: wrongKey.html");
                        }
                        else{
                            // Get userGroup ID from db
                            $memberNum = $_GET["num"];
                            //echo $memberNum;
                            $userGroupQuery = "SELECT groupID FROM users WHERE linkKey=\"$memberNum\"";
                            $result = $conn->query($userGroupQuery);
                            if(mysqli_num_rows($result) == 0) {
                              //  echo "No userGroup found in database!\n";
                            }
                            
                            if (mysqli_num_rows($result) > 0) {
                                // output data of each row
                                while($row = mysqli_fetch_assoc($result)) {
                                    $userGroupID = $row["groupID"];
                                }
                            }
                            else {
                             //   echo "0 results userGroup\n";
                            }


                            // Get salarySum from db
                            $salarySum = 0;
                            $salarySumQuery = "SELECT salarySum FROM groups WHERE groupID=\"$userGroupID\"";
                            $result = $conn->query($salarySumQuery);
                            if(mysqli_num_rows($result) == 0) {
                              //  echo "No salarySum found in database!\n";
                            }
                            if (mysqli_num_rows($result) > 0) {
                                // output data of each row
                                while($row = mysqli_fetch_assoc($result)) {
                                    $salarySum = $row["salarySum"];
                                }
                            } else {
                               // echo "0 results for salarySum\n";
                            }

                            //Add salary to salarySum and to db
                            $userKeySalary = $_GET["x"];
                            $salarySum += ($salary + $userKeySalary);

                            $updateSumQuery = mysqli_query($conn, "UPDATE groups SET salarySum=$salarySum WHERE groupID=\"$userGroupID\" ");

                            if(!$updateSumQuery)
                            {
                               // echo "No records added!\n";
                            }
                            else
                            {
                              //  echo "Records for salarySum added successfully.\n";
                            }


                            //Update to db that user has returned
                            $memberNum = $_GET["num"];
                            $updateHasReturned = mysqli_query($conn, "UPDATE users SET hasReturned=1 WHERE linkKey=\"$memberNum\" ");
                            
                            if(!$updateHasReturned)
                                {
                               // echo "No records added!\n";
                                }
                                else
                                {
                               // echo "Records for hasReturned added successfully.\n";
                                }


                            // Get groupSize from db
                            $groupSize = 0;
                            $groupSizeQuery = "SELECT groupSize FROM groups WHERE groupID=\"$userGroupID\"";
                            $result = $conn->query($groupSizeQuery);
                            if(mysqli_num_rows($result) == 0) {
                               // echo "No groupSize found in database!\n";
                            }
                            if (mysqli_num_rows($result) > 0) {
                                // output data of each row
                                while($row = mysqli_fetch_assoc($result)) {
                                $groupSize = $row["groupSize"];
                                }
                            } else {
                              //  echo "0 results groupSize\n";
                            }

                            // get groupName from db
                            $groupNameQuery = "SELECT userGroup FROM groups WHERE groupID=\"$userGroupID\"";
                            $result = $conn->query($groupNameQuery);
                            if(mysqli_num_rows($result) == 0) {
                              //  echo "No userGroup found in database!\n";
                            }
                            if (mysqli_num_rows($result) > 0) {
                                // output data of each row
                                while($row = mysqli_fetch_assoc($result)) {
                                $groupName = $row["userGroup"];
                                }
                            } else {
                               // echo "0 results groupSize\n";
                            }

                            // Get returnedAmount from db
                            $returnedAmount = 0;
                            $returnedAmountQuery = "SELECT returnedAmount FROM groups WHERE groupID=\"$userGroupID\"";
                            $result = $conn->query($returnedAmountQuery);
                            if(mysqli_num_rows($result) == 0) {
                               // echo "No returnedAmount found in database!\n";
                            }
                            
                            if (mysqli_num_rows($result) > 0) {
                                // output data of each row
                                while($row = mysqli_fetch_assoc($result)) {
                                    $returnedAmount = $row["returnedAmount"];
                                }
                            } else {
                               // echo "0 results returnedAmount\n";
                            }

                            //Add person to returnedAmount and to db
                            $returnedAmount += 1;

                            $updateReturnedAmount = mysqli_query($conn, "UPDATE groups SET returnedAmount=$returnedAmount WHERE groupID=\"$userGroupID\" ");

                                if(!$updateReturnedAmount)
                                {
                                  //  echo "No records added!\n";
                                }
                                else
                                {
                                  //  echo "Records for returnedAmount added successfully.\n";
                                }


                                // Add personKeyPieceValue to shares
                                $userNum = $_GET["z"];
                                $personKeyPiece = $_GET["y"];
                                $saveSharesQuery = "UPDATE shares SET personKeyPiece=$personKeyPiece WHERE groupID=\"$userGroupID\" AND userNum=$userNum";
                                $conn->query($saveSharesQuery);


                                // See if everyone has returned
                                if ($returnedAmount == $groupSize) 
                                {
                                    $from = "openpaycheck.send@gmail.com";
                                    $headers = "From:" . $from;
                                    $subject = "OpenPayCheck Results";
                                    $message = "Hi! \n\nThe results of salary comparison in group: $groupName can be found at: \n\nhttp://localhost/OpenPaycheck/results.php?num=$memberNum  \n\nBest Regards,\nOpenPayCheck";
                                    // Get emails from db 
                                    $email_to = "SELECT userEmail FROM users WHERE groupID=\"$userGroupID\"";
                                    $result = $conn->query($email_to);
                                    if(mysqli_num_rows($result) == 0) {
                                       // echo "No userEmail found in database!\n";
                                    }
                                    
                                    if (mysqli_num_rows($result) > 0) {
                                        // output data of each row
                                        while($row = mysqli_fetch_assoc($result)) {
                                            $to = $row["userEmail"];
                                            mail($to,$subject,$message, $headers);
                                        }
                                    } else {
                                       // echo "0 results for userEmail\n";
                                    }

                                   // echo "Everyone has returned!";   
                                    header("Location: http://localhost/OpenPaycheck/results.php?num=$memberNum");
                                    
                                    
                                } else {
                                    header("Location: returned.html");
                                    //echo "Everyone needs to give value before results.";
                                    }

                            $conn->close();

                        }
                    }
                }
                        
                    ?>

                <p>Please enter your salary information.</p>
                <div class="infoDiv">
                    <div id="infoContent">
                        Enter your monthly salary rounded to nearest integer number.<br>
                        <form method="POST" id="salaryInputDiv">
                            <input type="number" id="salaryInput" name="salary" min=0 step=1> <span style="color:green;"> ??? / month</span> </br>
                            <input type="submit" name="submit" value="Submit">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="salary.js"></script>
    </body>
</html>