<?php
//uncomment the line below if you have already added a new user
//require_once 'auth.php';

require_once 'User.php';

if(isset($_GET['userid'])) {
    $user = new User(); //instantiate user class
    $userid = $user->clean($_GET['userid']); //clean and transfer userid from GET superglobal to a local var
    $fetch_result = $user->getUser($userid); //call getUser function of user class and store result to a local variable
}

if(isset($_POST['userid'])) {
    $user = new User();
    $userid = $user->clean($_POST['userid']);
   
    $user->deleteAccount($userid); //call deleteAccount function of user class to delete the account
    $user->deleteUser($userid); //call deleteUser function of user class to delete the user
    
    header("location: showusers.php"); //go back to showusers.php
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Update User</title>
    </head>
    <body>
        <div style="width: 20%; margin:auto; border: solid 1px; text-align: center; padding: 10px;">
<?php
     if(isset($result)) {
         $msg = $result==1?"Account Updated!":"Failed to Update Account!";
         
         echo "<h5 style='color: blue;'>$msg</h5>";
     }
?>  
            <h3>Are you sure you want to delete the following record?</h3>
            <h5><?php 
                echo "$fetch_result[userid] - $fetch_result[lname], $fetch_result[fname] $fetch_result[mi] $fetch_result[n_ext]"; 
                
                
                ?></h5>
            
            
            <form action="deleteuser.php" method="post">
                <input type="hidden" name="userid"
                       value="<?php echo $fetch_result['userid']; ?>">
                
                <input type="submit" name="submit" value="Yes, DELETE">
            </form>
            <br><br>
            <button onclick="location.href='showusers.php'">No, Cancel</button>
        </div>
    </body>
</html>
