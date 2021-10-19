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
                    $queriedMemNum = "SELECT linkKey FROM users WHERE linkKey=\"$memberNum\"";
                    $result = $conn->query($queriedMemNum);
                    if(mysqli_num_rows($result) == 0) {
                        header("Location: wrongKey.html");
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
                    $memberNum = $_GET["num"];
                    $group = "SELECT userGroup FROM users WHERE linkKey=\"$memberNum\"";
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

                    $insert = mysqli_query($conn,"INSERT INTO `salary`(`salaryData`, `userGroup`) VALUES ('$salary','$groupname')");

                    if(!$insert)
                    {
                        echo "No records added!";
                    }
                    else
                    {
                        echo "Records added successfully.";
                    }
                




                    $email_to = "SELECT userEmail FROM users WHERE linkKey=\"$memberNum\"";
                    $result = $conn->query($email_to);
                    if(mysqli_num_rows($result) == 0) {
                        echo "No group found in database!";
                    }
                    
                    if (mysqli_num_rows($result) > 0) {
                        // output data of each row
                        while($row = mysqli_fetch_assoc($result)) {
                          $to = $row["userEmail"];
                        }
                      } else {
                        echo "0 results";
                      }
                    $from = "openpaycheck.send@gmail.com";
                    $headers = "From:" . $from;
                    $subject = "OpenPayCheck Results";
                    $message = "Results of salary comparison of a group: $groupname can be found at: http://localhost:8888/OpenPaycheck/results.html";
                    mail($to,$subject,$message, $headers);

                    $conn->close();

                    header("Location: http://localhost:8888/OpenPaycheck/results.html");
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