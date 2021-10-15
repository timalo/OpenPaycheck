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
                <p>Please enter your salary information.</p>
                <div class="infoDiv">
                    <div id="infoContent">
                        Enter your salary as hourly, monthly, or yearly wage.<br>
                        <div id="salaryInputDiv">
                            <input type="number" id="salaryInput" min=0 step=50> <span style="color:green;"> €</span> / 
                            <select name="salaryTime" id="salaryTime" onchange="toggleHours()">
                                <option value="hour">Hour</option>
                                <option selected value="month">Month</option>
                                <option value="year">Year</option>
                            </select> </br>
                            <div id="hoursPerWeek" style="font-size: 22">
                                How many hours per month do you work?<br>
                                <input type="number" min=1 style="width:15%; margin-top: 10px"> h
                            </div>
                            <button onclick="handleSalary()" id="submitSalaryBtn">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="salary.js"></script>
    </body>
</html>