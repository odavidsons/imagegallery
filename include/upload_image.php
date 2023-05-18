<?php 
$name = $_POST['name'];
$description = $_POST['description'];
if (isset($_SESSION['username'])) {
    $uploadedBy = $_SESSION['username'];
} else {
    $uploadedBy = 'Anonymous';
}

$error = "";
$uploadOk = 1;


if ($_FILES['imageFile']['tmp_name']!=''){
    $target_dir = $site_path.'uploads/';
    $target_file = $target_dir . basename($_FILES["imageFile"]["name"]);
    $image_selected = true;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $imageSitePath = 'uploads/'.$_FILES["imageFile"]["name"];

    //Check if file is an image via mime type
    $check = mime_content_type($_FILES["imageFile"]["tmp_name"]);
    if($check == "image/png" || $check == "image/jpeg") {
        $uploadOk = 1;
    } else {
        $error = "Ficheiro não é uma imagem";
        $uploadOk = 0;
    }
    //Allow selected file types
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
        $error = "Deve fazer upload de um ficheiro do tipo jpg,png ou jpeg.";
        $uploadOk = 0;
    }
    //Check if file already exists
    if (file_exists($target_file)) {
        $error = "Já existe um ficheiro com esse nome";
        $uploadOk = 0;
    }
    //Check file size limit( 10MB )
    if ($_FILES["imageFile"]["size"] > 10000000) {
        $error = "Ficheiro demasiado grande";
        $uploadOk = 0;
    }
} else {
    //No file selected
    $image_selected = false;
    $error = "No image selected!";
}

if ($image_selected == true && $uploadOk == 1) {
    move_uploaded_file($_FILES["imageFile"]["tmp_name"], $target_file);
    //Insert image entry into database table
    $query = "INSERT INTO images (name,path,description,uploaded_by) VALUES ('".$name."','".$imageSitePath."','".$description."','".$uploadedBy."')";
    $result = pg_query($dbconnect->conn, $query);
    if (isset($result)) {
        //$result = pg_query($dbconnect->conn, "SELECT MAX(id) FROM images");
        $result = pg_fetch_assoc(pg_query($dbconnect->conn, "SELECT MAX(id) FROM images"));
        $imageId = $result['id'];
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
header('index.php?page=upload&error='.$error);
?>
<script type="text/javascript">
    location = "index.php?page=upload&error=<?php echo $error ?>"
</script>