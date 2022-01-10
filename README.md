# OpenPaycheck

This is a project which allows users to enter their salary information and get statistics of other salaries entered by others within a specified group.

The application is used as a web app. The user is able to enter their salary via the web page and view the results.

None of the salary data is stored on the server itself, as the computation is done using Multi-party Computation (MPC). This allows a group to compare data without a central trusted party.

##MPC

Multi-party computation is performed using Shamir's Secret Sharing algorithm. On group creation, each user of a group gets a key, which is later used to calculate the average salary.
All keys are needed in order to complete the calculation.