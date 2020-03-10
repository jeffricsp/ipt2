<?php
//uncomment the line below if you have already added a new user
//require_once 'auth.php';

require_once 'User.php';

function getUserInfo($userid) {
    $user = new User();
    $fetch_result = $user->getUser($userid);
    return $fetch_result;
}

if(isset($_GET['userid'])) {
    $userid = $_GET['userid'];
    $fetch_result = getUserInfo($userid); 
}

if(isset($_POST['userid'])) {
    $user = new User();
    $userid = $user->clean($_POST['userid']);
    $prev_uname = $user->clean($_POST['prev_uname']);
    $new_uname = $user->clean($_POST['new_uname']);
    $upass = $_POST['password_new'];
    $role = $user->clean($_POST['role']);
    $fname = $user->clean($_POST['fname']);
    $mi = $user->clean($_POST['mi']);
    $lname = $user->clean($_POST['lname']);
    $n_ext = $user->clean($_POST['n_ext']);
 
    
    
    $result_acc = $user->updateAccount($userid, $prev_uname, $new_uname, $role);
    
    
    
    $result_user = $user->UpdateUser($userid, $fname, $mi, $lname, $n_ext);
    
    if(!empty($upass_new)) {
        $result_pass = $user->updatePassword($userid, $upass);
    } else {
        $result_pass=1;
    }
    
    if($result_acc==0 || $result_user==0 || $result_pass==0) {
        $result = 0;
        
    }else {
        
        $result = 1;
    }
    //$fetch_result=getUserInfo($userid); 
    
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
            <h3>Update User</h3>
            <a href="home.php">Home</a><br><br>
            <form action="edituser.php" method="post">
                <input type="hidden" name="userid"
                       value="<?php echo $fetch_result['userid']; ?>"><br>
                <input type="hidden" name="prev_uname" 
                       value="<?php echo $fetch_result['username']; ?>">
                Username<br>
                <input type="text" name="new_uname" placeholder="Username"
                       value="<?php echo $fetch_result['username']; ?>"><br>
                Role<br>
                <select name="role" style="width: 173px;">
                    <option value="<?php echo $fetch_result['role']; ?>" selected><?php echo $fetch_result['role']; ?></option>
                    <option value="User">User</option>
                    <option value="Admin">Admin</option>
                </select><br>
                Firstname<br>
                <input type="text" name="fname" placeholder="Firstname"
                       value="<?php echo $fetch_result['fname']; ?>"
                       required><br>
                Middle Initial<br>
                <input type="text" name="mi" placeholder="Middle Initial"
                       value="<?php echo $fetch_result['mi']; ?>"><br>
                Lastname<br>
                <input type="text" name="lname" placeholder="Lastname" required
                       value="<?php echo $fetch_result['lname']; ?>"><br>
                Name Extension<br>
                <input type="text" name="n_ext" placeholder="Name Extension"
                       value="<?php echo $fetch_result['n_ext']; ?>"><br>
                If you want to change your password, input your new password here otherwise leave it blank:<br>

                <input type="password" name="password_new" placeholder="Password"><br>
                <br>
                <input type="submit" name="submit" value="Update">
            </form>
        </div>
    </body>
</html>
