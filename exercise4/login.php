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

include 'header.php';
?>

<div class="login-box">
  <div class="login-logo">
    <a href="login.php"><b>Exercise</b>4</a>
    <div style="width: 20%; margin:auto; text-align: center; padding: 10px;">    
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
    </div>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="login.php" method="post">
        <div class="input-group mb-3">
          <input type="text" name="uname" class="form-control" placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" name="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mb-1">
        <a href="#">I forgot my password</a>
      </p>

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
<?php    
    include 'footer.php';
?>