<?php
//If form is submitted, create user account
$username = $_POST['username'];
$password = $_POST['password'];
$retypepassword = $_POST['retypepassword'];
$error = "";
if (isset($username) && isset($password)) {
    //Check if a user with the same username already exists
    $check_exists = $DBUsers->getUserId($username);
    if (!isset($check_exists)) {
        if ($password == $retypepassword) {
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
        } else {
            $error = "The passwords do not match.";
            echo "<script type='text/javascript'>
            location = 'index.php?page=signup&error=".$error."'
            </script>";
        }
    } else {
        $error = "This username is unavailable. Please choose another one.";
        echo "<script type='text/javascript'>
        location = 'index.php?page=signup&error=".$error."'
        </script>";
    }
}
?>