<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


require_once 'User.php';

if(isset($_POST['uname'])) {
    $user = new User();
    $uname = $user->clean($_POST['uname']);
    $upass = $_POST['password'];

    $result = $user->login($uname, $upass);
    
    echo $result;
}



?>

<!DOCTYPE html>
<html>
    <head>
        <title>Exercise 3</title>
    </head>
    <body>
    <div style="width: 20%; margin:auto; border: solid 1px; text-align: center; padding: 10px;">    
<?php
     if(isset($_GET['logout'])) {
        session_destroy();
        echo "<h5 style='color: red;'>You have been successfully logged out!</h5>";
     }
        
     if(isset($result)) {
         $msg = $result==1?header("location: home.php"):"Invalid username/password!";
         
         echo "<h5 style='color: blue;'>$msg</h5>";
     }
?>
        
        
            <h3>Security Check</h3>
            <form action="login.php" method="post">
                <input type="text" name="uname" placeholder="Username"><br><br>
                <input type="password" name="password" placeholder="Password"><br><br>
                <input type="submit" name="submit" value="Login">
            </form>
        </div>
    </body>
</html>
