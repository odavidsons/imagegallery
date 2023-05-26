<?php 
$name = $_POST['name'];
$description = $_POST['description'];
$category = $_POST['category'];
$error = "";
if (isset($_SESSION['username'])) {
    $uploadedBy = $_SESSION['username'];
} else {
    //Error message if user gets to this page if not logged in
    $error = "Action not allowed";
}
$userId = $DBUsers->getUserId($uploadedBy); //Get the user id
$uploadOk = 1;

//Prevent actions if user is not logged in
if (isset($_SESSION['username'])) {
    if ($_FILES['imageFile']['tmp_name']!=''){
        $target_dir = $_site_path.'uploads/';
        $target_file = $target_dir . basename($_FILES["imageFile"]["name"]);
        $image_selected = true;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $imageSitePath = 'uploads/'.$_FILES["imageFile"]["name"];

        //Check if file is an image via mime type
        $check = mime_content_type($_FILES["imageFile"]["tmp_name"]);
        if($check == "image/png" || $check == "image/jpeg") {
            $uploadOk = 1;
        } else {
            $error = "File is not an image";
            $uploadOk = 0;
        }
        //Allow selected file types
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
            $error = "You must upload a file in one of these formats: png/jpeg/jpg.";
            $uploadOk = 0;
        }
        //Check if file already exists
        if (file_exists($target_file)) {
            $error = "There already is a file with that name uploaded";
            $uploadOk = 0;
        }
        //Check file size limit( 10MB )
        if ($_FILES["imageFile"]["size"] > 10000000) {
            $error = "File is too big";
            $uploadOk = 0;
        }
    } else {
        //No file selected
        $image_selected = false;
        $error = "No valid image selected!";
    }

    if ($image_selected == true && $uploadOk == 1) {
        move_uploaded_file($_FILES["imageFile"]["tmp_name"], $target_file);
        //Insert image entry into database table
        $imageId = $DBAccess->insertImage($name,$imageSitePath,$description,$uploadedBy,$category);
        $obj_userstats = $DBUsers->getStatsByUserId($userId);
        if (isset($obj_userstats)) {
            //Update the current user's stats
            $total = ($obj_userstats[0]->total_uploaded + 1);
            $active = ($obj_userstats[0]->active_uploaded + 1);
            $total_comments = ($obj_userstats[0]->total_comments);
            $DBUsers->updateUSerStats($userId,$total,$active,$total_comments);
        } else {
            $error = "There was an error uploading your image";
        }
        if (isset($imageId)) {
            //$result = pg_query($dbconnect->conn, "SELECT MAX(id) FROM images");
            header('index.php?page=upload&upload=success&id='.$imageId);
            ?>
            <script type="text/javascript">
                location = "index.php?page=upload&upload=success&id=<?php echo $imageId ?>"
            </script>
            <?php
        } else {
            $error = "There was an error uploading your image";
        }
    }
}
header('index.php?page=upload&upload=failed&error='.$error);
?>
<script type="text/javascript">
    location = "index.php?page=upload&upload=failed&error=<?php echo $error ?>"
</script>