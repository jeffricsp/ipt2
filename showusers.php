<?php
//require_once 'auth.php';
require_once 'User.php';

$user = new User();

$result = $user->getUsers();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Registered Users</title>
    </head>
    <body>
        <h3>Registered Users</h3>
        <table border="1">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
              foreach($result as $r) {
                echo "<tr>
                        <td>$r[userid]</td>
                        <td>$r[lname], $r[fname] $r[mi] $r[n_ext]</td>
                        <td>$r[username]</td>
                        <td>$r[role]</td>
                        <td>
                            <a href='edituser.php?userid=$r[userid]'>Edit</a> |
                            <a href='deleteuser.php?userid=$r[userid]'>Delete</a>
                        </td>
                       </tr>";
                  
              }  
            ?>    
            </tbody>
        </table>
    </body>
</html>
