<?php
include('PHP/DBComments.php');
$DBComments = new DBComments($dbconnect->conn);
if (isset($_GET['error'])) {
    $error = $_GET['error'];
} else {
    $error = "";
}
$img_id = "";
$img_id = $_GET['id'];
$obj_image = $DBAccess->getImageById($img_id);
//Set the current image's caregory, based on if it's empty or not
if ($obj_image[0]->category == '') {
    $img_category = "None";
} else {
    $img_category = $obj_image[0]->category;
}
?>
<div class="viewimage_content">
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php?page=home">Home</a></li>
        <li class="breadcrumb-item"><a href="index.php?page=search">Search</a></li>
        <li class="breadcrumb-item"><a href="index.php?page=search&category=<?php echo $img_category ?>"><?php echo $img_category ?></a></li>
        <li class="breadcrumb-item active" aria-current="page">View</li>
    </ol>
    </nav>

    <div class="container-flex">
        <!-- Action confirmation modal -->
        <div class="modal" id="confirmationBox" tabindex="-1" aria-labelledby="confirmationBox" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <nav>Delete this image?</nav>
                    <br>
                    <form action="index.php?page=imageAction&id=<?php echo $img_id ?>&action=delete" method="POST" id="deleteProfileForm">
                    <button class="btn btn-success" type="button" id="btnNo" data-bs-dismiss="modal">No</button>
                    <button class="btn btn-danger" type="submit" id="btnYes">Yes</button>
                    </form>
                </div>
            </div>
        </div>
        </div>

        <div class="image_showImage">
            <img src="<?php echo $obj_image[0]->path ?>" alt="image-<?php echo $obj_image[0]->name ?>">
        </div>

        <!-- Image info panel on the right -->
        <div class="image_info">
            <div class="card">
            <div class="card-body">
                <?php
                echo "<div class='container-flex'>";
                //If the user is not the uploader of the image, block the action buttons
                if (isset($_SESSION['username']) && $_SESSION['username'] == $obj_image[0]->uploaded_by) {
                    //Show options
                    echo "<a class='btn align-middle' id='btn-edit' href='index.php?page=viewimage&id=$img_id&action=edit'>Edit <span class='material-symbols-outlined align-middle'>border_color</span></a>";
                    echo "<button class='btn align-middle' id='btn-delete' data-bs-toggle='modal' data-bs-target='#confirmationBox'>Delete <span class='material-symbols-outlined align-middle'>delete_forever</span></button>";
                    echo "<a class='btn align-middle' id='btn-edit' href='index.php?page=imageAction&id=$img_id&action=download'>Download <span class='material-symbols-outlined align-middle'>download</span></a>";
                    if (isset($_GET['action']) && ($_GET['action'] == 'edit')) {
                        //Go back button
                        echo "<a class='btn align-middle' style='margin-left: auto;' id='btn-edit' href='index.php?page=viewimage&id=$img_id'>Go back <span class='material-symbols-outlined align-middle'>undo</span></a>";
                    }
                } else {
                    echo "<button disabled class='btn align-middle' id='btn-edit'>Edit <span class='material-symbols-outlined align-middle'>border_color</span></button>";
                    echo "<button disabled class='btn align-middle' id='btn-delete'>Delete <span class='material-symbols-outlined align-middle'>delete_forever</span></button>";
                    echo "<a class='btn align-middle' id='btn-edit' href='index.php?page=imageAction&id=$img_id&action=download'>Download <span class='material-symbols-outlined align-middle'>download</span></a>";
                }
                echo "</div>";
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
                        echo "<label for='imgCategory' class='form-label'>Category:</label>";
                        echo "<select class='form-select' name='imgCategory' id='upload_content_select'>
                        <option selected value='".$img_category."'>".$img_category."</option>";
                        echo "<option value=''>None</option>";
                        $obj_categories = $DBAccess->getCategories();
                        if (isset($obj_categories)) {
                            for ($i = 0; $i < count((array)$obj_categories);$i++) {
                                if ($obj_categories[$i]->name != $img_category) {
                                    echo "<option value='".$obj_categories[$i]->name."'>".$obj_categories[$i]->name."</option>";
                                }
                            }
                        }
                        echo "</select>";
                        echo "<input type='hidden' name='imgId' value='".$obj_image[0]->id."'></input>";
                        echo "<div id='formError' style='color:red;' class='form-text'>".$error."</div>";
                        echo "<button type⁼'submit' class='btn btn-dark'>Submit changes</button>";
                        echo "</form>";
                    } else {
                        echo "<p style='color:red;'>Editing restricted. You are not the owner of this image.</p>";
                    }
                } else {
                    //If the user is not the owner of the image, only show the data
                    echo "<p class='card-text'><nav>Name: ".$obj_image[0]->name."</nav></p>";
                    echo "<p class='card-text'><nav>Description: ".$obj_image[0]->description."</nav></p>";
                    echo "<p class='card-text'><nav>Uploaded By: ".$obj_image[0]->uploaded_by."</nav></p>";
                    echo "<p class='card-text'><nav>Upload date: ".$obj_image[0]->upload_date."</nav></p>";
                    echo "<p class='card-text'><nav>Category: ".$img_category."</nav></p>";
                }
                if (isset($_SESSION['username']) && $_SESSION['username'] != '') {
                    //Get the stats of the image to display
                    $obj_imagestats = $DBAccess->getImageStats($obj_image[0]->id);
                    //Get the vote of the current user
                    $obj_userimagevote = $DBAccess->getUserImageVote($obj_image[0]->id);
                    if (count($obj_userimagevote) > 0) {
                        $uservote = $obj_userimagevote[0]->type;
                    }  else {
                        $uservote = "";
                    }
                    //Get image favourite vote by the user
                    $obj_userimagevote = $DBAccess->getUserImageFavourite($obj_image[0]->id);
                    if (count($obj_userimagevote) > 0) {
                        $userfavourite = 1;
                    }  else {
                        $userfavourite = 0;
                    }
                    ?>
                    <div class='container-flex' id="viewimage_image_stats">
                        <nav><a href="index.php?page=imageAction&action=imagevote&type=like&id=<?php echo $img_id ?>" id="like_btn" class="material-symbols-outlined align-middle">thumb_up</a>&nbsp;<span class="align-middle"><?php echo $obj_imagestats[0]->likes ?></span></nav>
                        <nav><a href="index.php?page=imageAction&action=imagevote&type=dislike&id=<?php echo $img_id ?>" id="dislike_btn" class="material-symbols-outlined align-middle">thumb_down</a>&nbsp;<span class="align-middle"><?php echo $obj_imagestats[0]->dislikes ?></span></nav>
                        <nav><a href="index.php?page=imageAction&action=imagevote&type=favourite&id=<?php echo $img_id ?>" id="favourite_btn" class="material-symbols-outlined align-middle">star</a>&nbsp;<span class="align-middle"><?php echo $obj_imagestats[0]->favourites ?></span></nav>
                    </div>
                    <?php
                    if (isset($_GET['message']) && $_GET['message'] != '') {
                        echo "<i>".$_GET['message']."</i>";
                    }
                } else {
                    //If image is beeing viewed in guest access
                    $uservote = "";
                    $userfavourite = 0;
                    //Get the stats of the image to display
                    $obj_imagestats = $DBAccess->getImageStats($obj_image[0]->id);
                    echo "<div class='container-flex' id='viewimage_image_stats'>";
                    echo "<nav><a id='like_btn' class='material-symbols-outlined align-middle'>thumb_up</a>&nbsp;<span class='align-middle'>".$obj_imagestats[0]->likes."</span></nav>";
                    echo "<nav><a id='dislike_btn' class='material-symbols-outlined align-middle'>thumb_down</a>&nbsp;<span class='align-middle'>".$obj_imagestats[0]->dislikes."</span></nav>";
                    echo "<nav><a id='favourite_btn' class='material-symbols-outlined align-middle'>star</a>&nbsp;<span class='align-middle'>".$obj_imagestats[0]->favourites."</span></nav>";
                    echo "</div>";
                }
                ?>
            </div>
            </div>
        </div>
    </div>

    <!-- Comment section -->
    <div class="image_comment_section">
        <div class="card">
            <div class="card-body">
            <?php
                $obj_comments = $DBComments->getImageComments($obj_image[0]->id);
                echo"<nav class='card-title'><span class='material-symbols-outlined align-middle'>comment</span>&nbsp;<span>".$obj_imagestats[0]->comments."</span>&nbsp;Comments</nav>";
                if (isset($obj_comments)) {
                    for ($i = 0;$i < count($obj_comments);$i++) {
                        echo "<div class='image_comment' id='image_comment".$obj_comments[$i]->id."'>";
                        echo "<span class='image_comment_user'><span class='material-symbols-outlined align-middle'>account_circle</span>".$obj_comments[$i]->username."</span>";
                        if ($obj_comments[$i]->username == $_SESSION['username']) {
                            //Comment options menu
                            echo "<div class='comment_delete_btn dropdown'>";
                            echo "<a href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false' title='Options'><span class='material-symbols-outlined align-middle'>list</span></a>";
                            echo "<ul class='dropdown-menu'>";
                            echo "<a href='index.php?page=imageAction&id=".$obj_image[0]->id."&comment=".$obj_comments[$i]->id."&action=deleteImageComment'>Delete</a>";
                            echo "</ul>";
                            echo "</div>";
                        } 
                        echo "<nav class='image_comment_text'>".$obj_comments[$i]->text."</nav>";
                        echo "<nav class='image_comment_date'>".$obj_comments[$i]->date."</nav>";
                        echo "</div>";
                    }
                } else {
                    echo "<nav>There are no comments yet. Be the first!</nav>";
                }
                ?>
            </div>
            <div class="card-footer">
                <?php
                if (isset($_SESSION['username']) && $_SESSION['username'] != '') {
                    echo"<form action='index.php?page=imageAction&action=addImageComment' method='POST'>";
                    echo"<label for='commentText' class='form-label'>Write a comment:</label>";
                    echo"<textarea class='form-control' name='comment_text' id='commentText' cols='30' rows='4'></textarea>";
                    echo"<input type='hidden' name='imgId' value='".$obj_image[0]->id."'>";
                    echo"<button class='btn btn-dark' type='submit'>Post</button>";
                    echo"</form>";
                } else {
                    echo"<label for='commentText' class='form-label'>Write a comment:</label>";
                    echo"<textarea disabled class='form-control' name='comment_text' id='commentText' cols='30' rows='4'></textarea>";
                    echo"<button disabled class='btn btn-dark'>Post</button>";
                    echo "<nav class='text-danger'>Please login to post a comment.</nav>";
                }
                
                ?>
            </div>
        </div>
    </div>
</div>
<script>
    window.onload = checkImageFavourite(),checkImageVote();
    function checkImageVote() {
        var current_vote = "<?php echo $uservote; ?>";
        if (current_vote == "like") {
            like_btn = document.getElementById("like_btn");
            like_btn.style.color = "rgb(82, 127, 179)";
        }
        if (current_vote == "dislike") {
            dislike_btn = document.getElementById("dislike_btn");
            dislike_btn.style.color = "rgb(185, 34, 29)";
        }
    }

    function checkImageFavourite() {
        var current_favourite = "<?php echo $userfavourite; ?>";
        if (current_favourite == 1) {
            favourite_btn = document.getElementById("favourite_btn");
            favourite_btn.style.color = "rgb(226, 206, 21)";
        }
    }
</script>