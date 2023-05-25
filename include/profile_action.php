<?php
$userId = $_POST['id'];
$action = $_POST['action'];
$error = "";
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    ?>
    <script type="text/javascript">
        location = "index.php?page=home&error=Access Restricted"
    </script>
    <?php
}

//Delete user
if ($action == 'delete') {
    $delete_user = $DBUsers->deleteUser($userId);
    $obj_images = $DBAccess->getImagesByUser($username);
    //Delete all the images uploaded by the user
    if (isset($obj_images) && (count((array)$obj_images) > 0)) {
        for ($i = 0;$i < count((array)$obj_images);$i++) {
            $delete_image = $DBAccess->deleteImage($obj_images[$i]->id);
        }
    }
    //If operations were successful
    if (isset($delete_user)) {
        echo "<script type='text/javascript'>
            location = 'index.php?page=logout&accountdelete=success'
        </script>";
    } else {
        $error = "There was an error while deleting your account";
    }
}
?>
<script type="text/javascript">
    location = "index.php?page=profile&error=<?php echo $error ?>"
</script>