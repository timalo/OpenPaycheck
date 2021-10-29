<html><head><title>Setting up database</title></head><body>
<h3>Setting up...</h3>
<?php //Setup.php
	include_once 'functions.php';
	
	createTable($con, 'users',
				'salarySum INT(64),
				linkKey VARCHAR(128),
                userGroup VARCHAR(64),
                groupSize INT(64),
                returnedAmount INT(64)');
	
    createTable($con, 'key_salary',
				'keySalary INT(64),
                userGroup VARCHAR(64)');
?>
<br />...done.
</body></html>