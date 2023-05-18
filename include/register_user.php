<?php
//If form is submitted, create user account
$username = $_POST['username'];
$password = $_POST['password'];
$error = "";
if (isset($username) && isset($password)) {
    $query = "INSERT INTO userinfo (username,password) VALUES ('".$username."','".$password."')";
    $result = pg_query($dbconnect->conn, $query);
    if (!isset($result)) {
        $error = "There was an error creating your account";
        echo "<script type='text/javascript'>
        location = 'index.php?page=signup&error=".$error."'
        </script>";
    } else {
        echo "<script type='text/javascript'>
        location = 'index.php?page=login&signup=success'
        </script>";
    }
}
?>