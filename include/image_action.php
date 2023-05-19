<?php
$id = $_GET['id'];
$action = $_GET['action'];

if (isset($_SESSION['username'])) {
    $uploadedBy = $_SESSION['username'];
} else {
    $uploadedBy = 'Guest user';
}
$userId = $DBUsers->getUserId($uploadedBy); //Get the user id

if ($action == 'delete') {
    $delete = $DBAccess->deleteImage($id);
    //Update the user's stats
    $obj_userstats = $DBUsers->getStatsByUserId($userId);
    if (isset($obj_userstats)) {
        $total = ($obj_userstats[0]->total_uploaded);
        $active = ($obj_userstats[0]->active_uploaded - 1);
        $DBUsers->updateUSerStats($userId,$total,$active);
    }
    if ($delete == true) {
        header('index.php?page=home');
        ?>
        <script type="text/javascript">
            location = "index.php?page=home"
        </script>
        <?php
    } else {
        $error = "There was an error deleting your image";
        header('index.php?page=viewimage&id='.$id.'&error='.$error);
        ?>
        <script type="text/javascript">
            location = "index.php?page=viewimage&id=<?php echo $id ?>&error=<?php echo $error ?>"
        </script>
        <?php
    }
}
//Edit image information
if ($action == 'edit') {
    $name = $_POST['imgName'];
    $description = $_POST['imgDescription'];
    $imgId = $_POST['imgId'];
    $update = $DBAccess->updateImage($imgId,$name,$description);
    if ($update == true) {
        header('index.php?page=viewimage&id='.$imgId);
        ?>
        <script type="text/javascript">
            location = "index.php?page=viewimage&id=<?php echo $imgId ?>"
        </script>
        <?php
    } else {
        $error = "There was an error editing your image";
        header('index.php?page=viewimage&id='.$imgId.'&error='.$error);
        ?>
        <script type="text/javascript">
            location = "index.php?page=viewimage&id=<?php echo $imgId ?>&error=<?php echo $error ?>"
        </script>
        <?php
    }
}
?>