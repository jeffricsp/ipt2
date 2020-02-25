<?php
//check if session is started or not, start it if not
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//if session userid is empty or was not set then user has not logged in, go to login page
if(!isset($_SESSION['userid']) && empty($_SESSION['userid'])) {
    header("location: login.php");
}
