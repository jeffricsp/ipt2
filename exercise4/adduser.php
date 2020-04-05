<?php
//uncomment the line below if you have already added a new user
require_once 'auth.php';
require_once 'User.php';

if(isset($_POST['userid'])) {
    $user = new User();
    $userid = $user->clean($_POST['userid']);
    $uname = $user->clean($_POST['uname']);
    $upass = $_POST['password'];
    $upass2 = $_POST['password2'];
    $role = $user->clean($_POST['role']);
    $fname = $user->clean($_POST['fname']);
    $mi = $user->clean($_POST['mi']);
    $lname = $user->clean($_POST['lname']);
    $n_ext = $user->clean($_POST['n_ext']);
    
    if($upass===$upass2) {
        $result = $user->addNewAccount($userid, $uname, $upass, $role);
        if($result==1) {
            $result = $user->addNewUser($userid, $fname, $mi, $lname, $n_ext);
            if($result==0) {
                $user->deleteAccount($userid);
            }
        }
    } else {
        $result = 0;
    }
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
     if(isset($result)) {
         $msg = $result==1?"Saved!":"Not Saved!";
         
         echo "<h5 style='color: blue;'>$msg</h5>";
     }
?>  
            <h3>Add New User</h3>
            <a href="home.php">Home</a><br><br>
            <form action="adduser.php" method="post">
                <input type="text" name="userid" placeholder="User ID" required><br>

                <input type="text" name="uname" placeholder="Username" required><br>
                <input type="password" name="password" placeholder="Password" required><br>
                <input type="password" name="password2" placeholder="Retype Password" required><br>
                <select name="role" style="width: 173px;">
                    <option value="User">User</option>
                    <option value="Admin">Admin</option>
                </select><br>
                <input type="text" name="fname" placeholder="Firstname" required><br>
                <input type="text" name="mi" placeholder="Middle Initial"><br>
                <input type="text" name="lname" placeholder="Lastname" required><br>
                <input type="text" name="n_ext" placeholder="Name Extension"><br><br>
                <input type="submit" name="submit" value="Add">
            </form>
        </div>
    </body>
</html>
