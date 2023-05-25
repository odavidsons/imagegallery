<?php
//Block access to this page
if (!isset($_SESSION['username']) || $_SESSION['type'] == '0') {
    ?>
    <script type="text/javascript">
        location = "index.php?page=home&error=Access Restricted"
    </script>
    <?php
}

if (isset($_POST['category_name']) && $_POST['category_name'] != '') {
    $category_name = $_POST['category_name'];
}
if (isset($_POST['category_id']) && $_POST['category_id'] != '') {
    $category_id = $_POST['category_id'];
}
$type = $_GET['type'];

//Check what type of information is beeing changed by the 'type' parameter
switch($type) {
    case 'category':
        //Add new image category
        if (isset($_POST['insert'])) {
            $category_id = $DBAccess->insertCategory($category_name);
            if (isset($category_id)) {
                ?>
                <script type="text/javascript">
                    location = "index.php?page=adminPanel&section=filters&action=success"
                </script>
                <?php
            } else {
                ?>
                <script type="text/javascript">
                    location = "index.php?page=adminPanel&section=filters&action=failed"
                </script>
                <?php
            }
        }
        //Delete image category
        if (isset($_POST['delete'])) {
            $category_delete = $DBAccess->deleteCategory($category_id);
            if (isset($category_delete)) {
                ?>
                <script type="text/javascript">
                    location = "index.php?page=adminPanel&section=filters&action=success"
                </script>
                <?php
            } else {
                ?>
                <script type="text/javascript">
                    location = "index.php?page=adminPanel&section=filters&action=failed"
                </script>
                <?php
            }
        }
        break;
    default:
        exit;
        break;
}
?>