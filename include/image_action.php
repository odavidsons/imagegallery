<?php
$id = $_GET['id'];
$action = $_GET['action'];

if ($action == 'delete') {
    $delete = $DBAccess->deleteImage($id);
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

?>