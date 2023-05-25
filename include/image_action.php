<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}
if (isset($_SESSION['username'])) {
    $uploadedBy = $_SESSION['username'];
} else {
    ?>
    <script type="text/javascript">
        location = "index.php?page=home&error=Access Restricted"
    </script>
    <?php
}
$userId = $DBUsers->getUserId($uploadedBy); //Get the user id

//Check the desired action
switch ($action) {
    //If the action is for deleting an image
    case 'delete':
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
                location = "index.php?page=search&imagedelete=success"
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
        break;
    //Îf the action is for editing an image
    case 'edit':
        $name = $_POST['imgName'];
        $description = $_POST['imgDescription'];
        $imgCategory = $_POST['imgCategory'];
        $imgId = $_POST['imgId'];
        $update = $DBAccess->updateImage($imgId,$name,$description,$imgCategory);
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
        break;
    //If the action is for downloading an image
    case 'download':
        $obj_img = $DBAccess->getImageById($id);
        header('Content-Type: application/download');
        header('Content-Disposition: attachment; filename="'.$obj_img[0]->path.'"');
        header("Content-Length: " . filesize("".$obj_img[0]->path.""));
        $fp = fopen("".$obj_img[0]->path."", "r");
        fpassthru($fp);
        fclose($fp);
        ?>
        <script type="text/javascript">
            location = "index.php?page=viewimage&id=<?php echo $id ?>&error=<?php echo $error ?>"
        </script>
        <?php
        break;
    //If the action is for voting on an image
    case 'imagevote':
            $votetype = $_GET['type'];
            switch ($votetype) {
                case 'like':
                    $message = $DBAccess->addImageVote($id,'like');
                    break;
                case 'dislike':
                    $message = $DBAccess->addImageVote($id,'dislike');
                    break;
                case 'favourite':
                    $message = $DBAccess->addImageFavourite($id);
                    break;
            }
            ?>
            <script type="text/javascript">
                location = "index.php?page=viewimage&id=<?php echo $id ?>&message=<?php echo $message?>"
            </script>
            <?php
        break;
    default:
        ?>
        <script type="text/javascript">
            location = "index.php?page=search"
        </script>
        <?php
        break;
}
?>