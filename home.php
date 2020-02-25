<?php
require_once 'auth.php';

$fname = $_SESSION['fname'];
$mi = $_SESSION['mi'];
$lname = $_SESSION['lname'];
$role = $_SESSION['role'];

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Exercise 3</title>
    </head>
    <body>
     
        <div style="width: 20%; margin:auto; border: solid 1px; text-align: center; padding: 10px;">
            <h3>Welcome!</h3>
            
            <h5>Personal Details</h5>
            
                Name: <?php echo "$lname, $fname $mi"; ?><br>
                Role: <?php echo $role; ?>
            <br><br>
            Note: You cannot open this page without a login account!<br><br>
            <a href="adduser.php">Add New User</a> | <a href="login.php?logout=true">Logout</a>
        </div>
    </body>
</html>