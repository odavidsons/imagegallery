<?php
include('PHP/dbconnect.php');
include('PHP/DBAccess.php');
include('PHP/DBUsers.php');
$dbconnect = new dbconnect();
$DBAccess = new DBAccess($dbconnect->conn);
$DBUsers = new DBUsers($dbconnect->conn);

$page = $_GET['page'];
$site_path = '/var/www/html/imagegallery/';

session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="include/css/style.css">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <!-- Ícons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
    <!-- Icon style -->
    <style>
    .material-symbols-outlined {
    font-variation-settings:
    'FILL' 0,
    'wght' 400,
    'GRAD' 0,
    'opsz' 48
    }
    </style>
    <div class="header">
    <?php
    include('header.php');
    ?>
    </div>
    <div class="content">
        <?php
        //Display correct page according to url dynamically
        switch($page) {
            //Website pages
            case 'home':
                include('pages/home.php');
                break;
            case 'viewimage':
                include('pages/viewimage.php');
                break;
            case 'login':
                include('pages/login.php');
                break;
            case 'signup':
                include('pages/signup.php');
                break;
            case 'upload':
                include('pages/upload.php');
                break;
            case 'profile':
                include('pages/profile.php');
                break;
            //PHP actions
            case 'imageAction':
                include('include/image_action.php');
                break;
            case 'uploadAction':
                include('include/upload_image.php');
                break;
            case 'signupAction':
                include('include/register_user.php');
                break;
            case 'logout':
                include('include/logout.php');
                break;
            default:
                include('pages/home.php');
                break;
        }
        ?>
    </div>
    <div class="footer text-center">
        <?php 
        include('footer.php');
        ?>
    </div>
</body>
</html>