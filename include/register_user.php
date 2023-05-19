<?php
//If form is submitted, create user account
$username = $_POST['username'];
$password = $_POST['password'];
$error = "";
if (isset($username) && isset($password)) {
    $register_user = $DBUsers->insertUser($username,$password);
    if (!isset($register_user)) {
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