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

                    $salaryData = "SELECT salaryData FROM salary WHERE userGroup=\"$groupname\"";
                    $result = $conn->query($salaryData);
                    if(mysqli_num_rows($result) == 0) {
                        echo "No salaryData found in database!";
                    }
                    
                    if (mysqli_num_rows($result) > 0) {
                        // output data of each row
                        while($row = mysqli_fetch_assoc($result)) {
                          $salary += $row["salaryData"];
                          $i += 1;
                        }
                        $salaryResult = $salary / $i;
                      } else {
                        echo "0 results for salaryData";
                      }

                      echo "     <div id='content'>
                      <p>Here are the results:</p>
                      <div class='infoDiv'>
                         <p>Group average salary:</p> 
                          <div id='average' >$salaryResult</div>
                         <p>Your salary:</p> 
                         <div id='salary' >salary</div>
                      </div>
                        </div>";

                    $conn->close();
                ?>
            </div>
       
        </div>
        <script src="salary.js"></script>
    </body>
</html>