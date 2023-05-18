<?php
$img_id = "";
$img_id = $_GET['id'];
$obj_image = $DBAccess->getImageById($img_id);
?>
<div class="viewimage_content">
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a>Home</a></li>
        <li class="breadcrumb-item"><a href="index.php?page=home">Search</a></li>
        <li class="breadcrumb-item active" aria-current="page">View</li>
    </ol>
    </nav>

    <div class="container-flex">
        <img src="<?php echo $obj_image[0]->path ?>" alt="image-<?php echo $obj_images[0]->name ?>">

        <div class="image_info">
            <div class="card">
            <div class="card-body">
                <p class="card-text"><nav>Name: <?php echo $obj_image[0]->path ?></nav></p>
                <p class="card-text"><nav>Description: <?php echo $obj_image[0]->description ?></nav></p>
                <p class="card-text"><nav>Author: <?php echo $obj_image[0]->uploaded_by ?></nav></p>
                <p class="card-text"><nav>Upload date: <?php echo $obj_image[0]->upload_date ?></nav></p>
            </div>
            </div>
        </div>
    </div>
</div>