<?php
if(isset($_GET['error'])) {
    $error = $_GET['error'];
}
if(isset($_GET['upload'])) {
    $uploadStatus = $_GET['upload'];
}
if(isset($_GET['id'])) {
    $imageId = $_GET['id'];
}
?>
<div class="upload_content">
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php?page=home">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Upload</li>
    </ol>
    </nav>

    <?php
    if ($uploadStatus == 'success') {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert' id='uploadAlert'>
        Image successfully uploaded!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    } elseif ($uploadStatus == 'failed') {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert' id='uploadAlert'>
        Image upload failed!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    }
    ?>

    <div class="card">
        <div class="container-flex">
            <div class="card-body" style="width:65%;">
                <h5 class="card-title">Upload an image</h5>
                <form action="index.php?page=uploadAction" method="POST" id="uploadForm" enctype="multipart/form-data">
                    <label for="uploadImage">Select your image:</label>
                    <input type="file" name="imageFile" class="form-control" id="uploadImage" required>
                    <label for="uploadName" class="form-label">Image name:</label>
                    <input type="text" name="name" class="form-control" id="uploadName" required>
                    <label for="uploadDescription">Description:</label>
                    <textarea class="form-control" name="description" placeholder="Write something about your image" id="uploadDescription" rows="6"></textarea>
                    <div id="formError" style="color:red;" class="form-text"><?php echo $error ?></div>
                    <?php
                        if (!isset($_SESSION['username'])) {
                            echo "<nav><button type='submit' class='btn btn-dark' disabled>Upload</button>&nbsp;<b>* Please login to be able to upload images.</b></nav>";
                        } else {
                            echo "<button type='submit' class='btn btn-dark'>Upload</button>";
                        }
                    ?>
                    
                </form>
            </div>
            <?php 
            if (isset($imageId)) {
                $obj_image = $DBAccess->getImageById($imageId);
                ?>
                <div class="card-body" style="width:35%;">
                <br>
                <p>Uploaded image:</p>
                <img src="<?php echo $obj_image[0]->path ?>" style="width:90%;" alt="">
                <p>Name: <?php echo $obj_image[0]->name ?></p>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>