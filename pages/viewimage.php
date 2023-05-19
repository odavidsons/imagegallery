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
        <img src="<?php echo $obj_image[0]->path ?>" alt="image-<?php echo $obj_image[0]->name ?>">

        <div class="image_info">
            <div class="card">
            <div class="card-body">
                <?php
                //If the user is not the uploader of the image, block the action buttons
                if ($_SESSION['username'] == $obj_image[0]->uploaded_by) {
                    //Show options
                    echo "<a class='btn align-middle' id='btn-edit' href='index.php?page=viewimage&id=$img_id&action=edit'>Edit <span class='material-symbols-outlined align-middle'>border_color</span></a>";
                    echo "<a class='btn align-middle' id='btn-delete' href='index.php?page=imageAction&id=$img_id&action=delete'>Delete <span class='material-symbols-outlined align-middle'>delete_forever</span></a>";
                    if (isset($_GET['action']) && ($_GET['action'] == 'edit')) {
                        //Go back button
                        echo "<a class='btn align-middle' id='btn-edit' href='index.php?page=viewimage&id=$img_id'>Go back <span class='material-symbols-outlined align-middle'>undo</span></a>";
                    }
                } else {
                    echo "<button disabled class='btn align-middle' id='btn-edit'>Edit <span class='material-symbols-outlined align-middle'>border_color</span></button>";
                    echo "<button disabled class='btn align-middle' id='btn-delete'>Delete <span class='material-symbols-outlined align-middle'>delete_forever</span></button>";
                }

                //Image info area.
                //Check if user is the one who uploaded the image
                if (isset($_GET['action']) && ($_GET['action'] == 'edit')) {
                    //Check if 'Edit' button was clicked, and if so chow the options for changing the values and updating them
                    if (isset($_SESSION['username']) && ($_SESSION['username'] == $obj_image[0]->uploaded_by)) {
                        echo "<p></p>";
                        echo "<form action='index.php?page=imageAction&action=edit' method='POST'>";
                        echo "<label for='imgName' class='form-label'>Name:</label>";
                        echo "<input class='form-control' name='imgName' value='".$obj_image[0]->name."' id='imgName'></input>";
                        echo "<label for='imgDescription' class='form-label'>Description:</label>";
                        echo "<textarea class='form-control' name='imgDescription' id='imgDescription' rows='6'>".$obj_image[0]->description."</textarea>";
                        echo "<input type='hidden' name='imgId' value='".$obj_image[0]->id."'></input>";
                        echo "<div id='formError' style='color:red;' class='form-text'>".$error."</div>";
                        echo "<button type⁼'submit' class='btn btn-dark'>Submit changes</button>";
                        echo "</form>";
                    } else {
                        echo "<p style='color:red;'>Editing restricted. You are not the owner of this image.</p>";
                    }
                } else {
                    echo "<p class='card-text'><nav>Name: ".$obj_image[0]->name."</nav></p>";
                    echo "<p class='card-text'><nav>Description: ".$obj_image[0]->description."</nav></p>";
                    echo "<p class='card-text'><nav>Uploaded By: ".$obj_image[0]->uploaded_by."</nav></p>";
                    echo "<p class='card-text'><nav>Upload date: ".$obj_image[0]->upload_date."</nav></p>";
                }
                ?>
            </div>
            </div>
        </div>
    </div>
</div>