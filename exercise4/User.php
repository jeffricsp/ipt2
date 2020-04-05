<?php
class User {
    function connect() {
        require_once 'config.php';
        $mysqli = new mysqli(HOST, USER, PW, DB);
        return $mysqli;
    }
    
    function addNewAccount($userid, $uname, $password, $role) {
        $conn = $this->connect();
        //lets hash our password using password_hash method
        $password = password_hash($password, PASSWORD_DEFAULT);
        
        //Added to check if username exist or not
        $ucount = $this->checkUsername($uname);
        //if $ucount is > 0 then username already exist, do not insert
        
        if($ucount==0) {
            //this will add new account in tbl_account
            $sql = "INSERT INTO tbl_account VALUES(?,?,?,?)";
            $qry = $conn->prepare($sql);
            $qry->bind_param("ssss", $userid, $uname, $password, $role);
            if($qry->execute()) {
                $result = 1;
            } else {
                $result = 0;
            }
        } else {
            $result = 0;
        }
        return $result;
    }
    
    function addNewUser($userid, $fname, $mi, $lname, $n_ext) {
        $conn = $this->connect();
        //this will add new user in tbl_user
        $sql = "INSERT INTO tbl_user VALUES(?,?,?,?,?)";
        $qry = $conn->prepare($sql);
        $qry->bind_param("sssss", $userid, $fname, $mi, $lname, $n_ext);
        if($qry->execute()) {
            $result = 1;
        } else {
            $result = 0;
        }
        return $result;
    }
    
    function deleteUser($userid) {
        $conn = $this->connect();
        //this will delete the user in tbl_user
        $sql = "DELETE FROM tbl_user WHERE userid=?";
        $qry = $conn->prepare($sql);
        $qry->bind_param("s", $userid);
        
        if($qry->execute()) {
            $result = 1;
        } else {
            $result = 0;
        }
        return $result;
    }
    
    function deleteAccount($userid) {
        $conn = $this->connect();
        //this will delete the account in tbl_account
        $sql = "DELETE FROM tbl_account WHERE userid=?";
        $qry = $conn->prepare($sql);
        $qry->bind_param("s", $userid);
        
        if($qry->execute()) {
            $result = 1;
        } else {
            $result = 0;
        }
        return $result;
    }
    
    function checkUsername($username) {
        $conn = $this->connect();
        $result = 0;
        //we will use this method to check if username already exist or not, we wont allow same username in our table (though you can do this in making your field unique in your table)
        $sql = "SELECT count(username) FROM tbl_account WHERE username=?";
        $qry = $conn->prepare($sql);
        $qry->bind_param("s", $username);
        $qry->bind_result($result);
        if($qry->execute()) {
            $qry->fetch();
        }
        return $result;
    }
    
    function login($uname, $upass) {
        $conn = $this->connect();
        //the SQL statement below joins 2 tables together
        $sql = "SELECT tbl_user.userid, username, password, role, fname, mi, lname, n_ext FROM tbl_account, tbl_user WHERE username=? and tbl_user.userid=tbl_account.userid";
        $qry = $conn->prepare($sql);
        $qry->bind_param("s", $uname);
        $qry->bind_result($userid, $uname, $hpass, $role, $fname, $mi, $lname, $n_ext);
        if($qry->execute()) {
            $qry->fetch();
            if(isset($hpass)) {
                //password_verify will compare the password and the stored hashed password, will return true if they match
                if(password_verify($upass, $hpass)) {
                    //if password is correct!
                    //we will be using session super global array to know whether the user is logged in or not
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }
                    $_SESSION['userid'] = $userid;
                    $_SESSION['role'] = $role;
                    $_SESSION['fname'] = $fname;
                    $_SESSION['mi'] = $mi;
                    $_SESSION['lname'] = $lname;
                    $_SESSION['n_ext'] = $n_ext;
                    $result = 1;
                } else {
                    //if password is incorrect
                    $result = $qry->error;
                }
            } else {
                //if username does not exist
                $result = 0;
            }
        } else {
            //if query cannot be executed
            $result = 0;
        }
        return $result;
    }
    
    function getUsers() {
        $conn = $this->connect();
        $sql = "SELECT tbl_user.userid, fname, mi, lname, n_ext, username, role FROM tbl_user, tbl_account WHERE tbl_user.userid=tbl_account.userid";
        $result = $conn->query($sql);
        return $result;
    }
    
    function updateAccount($userid, $prev_uname, $new_uname, $role) {   
        $conn = $this->connect();
        
        //Added to check if username exist or not
        if($prev_uname!==$new_uname) {
            $ucount = $this->checkUsername($uname);
            //if $ucount is > 0 then username already exist, do not insert
        } else {
            $ucount=0;
        }

        if($ucount==0) {
                //this will add new account in tbl_account
            $sql = "UPDATE tbl_account SET username=?, role=? WHERE userid=?";
            $qry = $conn->prepare($sql);
            $qry->bind_param("sss", $new_uname, $role, $userid);
            if($qry->execute()) {
                $result = 1;
            } else {
                $result = 0;
            }
        } else {
            $result = 0;
        }
        return $result;
        
    }
    
    function updatePassword($userid, $password) {   
        $conn = $this->connect();
        $password = password_hash($password, PASSWORD_DEFAULT);
        
                //this will add new account in tbl_account
        $sql = "UPDATE tbl_account SET password=? WHERE userid=?";
        $qry = $conn->prepare($sql);
        $qry->bind_param("ss", $password, $userid);
        if($qry->execute()) {
            $result = 1;
        } else {
            $result = 0;
        }
    
        return $result;
        
    }
    
    function UpdateUser($userid, $fname, $mi, $lname, $n_ext) {
        $conn = $this->connect();
        //this will add new user in tbl_user
        $sql = "UPDATE tbl_user SET fname=?, mi=?, lname=?, n_ext=? WHERE userid=?";
        $qry = $conn->prepare($sql);
        $qry->bind_param("sssss", $fname, $mi, $lname, $n_ext, $userid);
        if($qry->execute()) {
            $result = 1;
        } else {
            $result = 0;
        }
        return $result;
    }
    
    function getUser($userid) {
        $conn = $this->connect();
        $sql = "SELECT tbl_user.userid, fname, mi, lname, n_ext, username, role FROM tbl_user, tbl_account WHERE tbl_user.userid=tbl_account.userid AND tbl_account.userid=?";
        
        $qry = $conn->prepare($sql);
        $qry->bind_param("s", $userid);
        
        $qry->bind_result($userid, $fname, $mi, $lname, $n_ext, $username, $role);
        $qry->execute();
        $qry->fetch();
        
        $result['userid']=$userid;
        $result['fname']=$fname;
        $result['mi']=$mi;
        $result['lname']=$lname;
        $result['n_ext']=$n_ext;
        $result['username']=$username;
        $result['role']=$role;
        
        return $result; 
    }
    
    function clean($data) {
        $conn = $this->connect();
        //lets do a basic cleanup of input
        return mysqli_real_escape_string($conn, $data);
    }
}
