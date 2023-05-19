<?php
$img_id = "";
$img_id = $_GET['id'];
$obj_image = $DBAccess->getImageById($img_id);
//If the user is not the uploader of the image, block the action buttons
if ($_SESSION['username'] == $obj_image[0]->author) {
    
} else {
    
}
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
        <img src="<?php echo $obj_image[0]->path ?>" alt="image-<?php echo $obj_image[0]->name ?>">

        <div class="image_info">
            <div class="card">
            <div class="card-body">
                <?php
                if ($_SESSION['username'] == $obj_image[0]->uploaded_by) {
                    echo "<a class='btn align-middle' id='btn-edit' href='index.php?page=imageAction&id=$img_id&action=edit'>Edit <span class='material-symbols-outlined align-middle'>border_color</span></a>";
                    echo "<a class='btn align-middle' id='btn-delete' href='index.php?page=imageAction&id=$img_id&action=delete'>Delete <span class='material-symbols-outlined align-middle'>delete_forever</span></a>";
                } else {
                    echo "<button disabled class='btn align-middle' id='btn-edit'>Edit <span class='material-symbols-outlined align-middle'>border_color</span></button>";
                    echo "<button disabled class='btn align-middle' id='btn-delete'>Delete <span class='material-symbols-outlined align-middle'>delete_forever</span></button>";
                }
                ?>
                
                <p class="card-text"><nav>Name: <?php echo $obj_image[0]->name ?></nav></p>
                <p class="card-text"><nav>Description: <?php echo $obj_image[0]->description ?></nav></p>
                <p class="card-text"><nav>Author: <?php echo $obj_image[0]->uploaded_by ?></nav></p>
                <p class="card-text"><nav>Upload date: <?php echo $obj_image[0]->upload_date ?></nav></p>
            </div>
            </div>
        </div>
    </div>
</div>