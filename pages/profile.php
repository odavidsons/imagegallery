<?php
if (!isset($_SESSION['username'])) {
    ?>
    <script type="text/javascript">
        location = "index.php?page=home&error=Please register an account to access your profile"
    </script>
    <?php
}

$username = $_SESSION['username'];
$userId = $DBUsers->getUserId($username);
$obj_userstats = $DBUsers->getStatsByUserId($userId);
$obj_images = $DBAccess->getImagesByUser($username);
$obj_favourites = $DBAccess->getUserFavouriteImages($username); //FIX THE QUERY IN THIS FUNCTION 25-05-23
?>
<div class="profile_content">
    <!-- Action confirmation modal -->
    <div class="modal" id="confirmationBox" tabindex="-1" aria-labelledby="confirmationBox" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <nav>Do you really wish to delete your profile?</nav>
                <br>
                <form action="index.php?page=profileAction" method="POST" id="deleteProfileForm">
                <input type="hidden" id="profileId" name="id" value="<?php echo $userId ?>">
                <input type="hidden" id="profileAction" name="action" value="delete">
                <button class="btn btn-success" type="button" id="btnNo" data-bs-dismiss="modal">No</button>
                <button class="btn btn-danger" type="submit" id="btnYes">Yes</button>
                </form>
            </div>
        </div>
    </div>
    </div>

    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a>Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Profile</li>
    </ol>
    </nav>

    <?php
    //Alert messages
    if (isset($_GET['error']) && $_GET['error'] != "") {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert' id='uploadAlert'>
        ".$_GET['error']."
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    }
    ?>
    
    <!-- Display user stats -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Welcome <?php echo $_SESSION['username'] ?></h5>
            <br>
            <p>Total images uploaded: <?php echo $obj_userstats[0]->total_uploaded ?></p>
            <p>Active images: <?php echo $obj_userstats[0]->active_uploaded ?></p>
            <p>Total comments posted: <?php echo $obj_userstats[0]->total_comments ?></p>
        </div>
    </div>
    
    <!-- Display user uploaded images -->
    <div class="card uploaded_images">
        <div class="card-body">
            <h5 class="card-title">Your images</h5>
            <?php
            if (isset($obj_images) && count((array)$obj_images) > 0) {
                echo "<div class='row row-cols-1 row-cols-md-auto g-4'>";
                for ($i = 0;$i < count((array)$obj_images);$i++) {
                    //Get the current image's stats
                    $obj_imagestats = $DBAccess->getImageStats($obj_images[$i]->id);
                    //Set the current image's caregory, based on if it's empty or not
                    if ($obj_images[$i]->category == '') {
                        $img_category = "None";
                    } else {
                        $img_category = $obj_images[$i]->category;
                    }
                    ?>
                    <!-- Display user images -->
                    <div class="col">
                    <div class="card text-center" style="width: 12rem;">
                        <a href="index.php?page=viewimage&id=<?php echo $obj_images[$i]->id ?>">
                        <img src="<?php echo $obj_images[$i]->path ?>" class="card-img-top" alt="image-<?php echo $obj_images[$i]->name ?>">
                        </a>
                        <div class="card-footer text-body-secondary">
                            <?php echo $obj_images[$i]->name ?>
                            <nav><?php echo $img_category ?></nav>
                            <div class="container-flex" id="search_image_stats">
                                <span><span class="material-symbols-outlined align-middle">thumb_up</span>&nbsp;<?php echo $obj_imagestats[0]->likes ?></span>
                                <span><span class="material-symbols-outlined align-middle">thumb_down</span>&nbsp;<?php echo $obj_imagestats[0]->dislikes ?></span>
                                <span><span class="material-symbols-outlined align-middle">star</span>&nbsp;<?php echo $obj_imagestats[0]->favourites ?></span>
                            </div>
                        </div>
                    </div>
                    </div>
                    <?php
                }
                echo "</div>";
            } else {
                echo "<p>You have no uploaded images.</p>";
            }
            ?>
        </div>
    </div>

    <!-- Display user favouroutired images -->
    <div class="card uploaded_images">
        <div class="card-body">
            <h5 class="card-title">Favourites</h5>
            <?php
            if (count($obj_favourites) > 0) {
                echo "<div class='row row-cols-1 row-cols-md-auto g-4'>";
                for ($i = 0;$i < count((array)$obj_favourites);$i++) {
                    //Get the current image's stats
                    $obj_imagestats = $DBAccess->getImageStats($obj_favourites[$i]->id);
                    //Set the current image's caregory, based on if it's empty or not
                    if ($obj_favourites[$i]->category == '') {
                        $img_category = "None";
                    } else {
                        $img_category = $obj_favourites[$i]->category;
                    }
                    ?>
                    <!-- Display user images -->
                    <div class="col">
                    <div class="card text-center" style="width: 12rem;">
                        <a href="index.php?page=viewimage&id=<?php echo $obj_favourites[$i]->id ?>">
                        <img src="<?php echo $obj_favourites[$i]->path ?>" class="card-img-top" alt="image-<?php echo $obj_favourites[$i]->name ?>">
                        </a>
                        <div class="card-footer text-body-secondary">
                            <?php echo $obj_favourites[$i]->name ?>
                            <nav><?php echo $img_category ?></nav>
                            <div class="container-flex" id="search_image_stats">
                                <span><span class="material-symbols-outlined align-middle">thumb_up</span>&nbsp;<?php echo $obj_imagestats[0]->likes ?></span>
                                <span><span class="material-symbols-outlined align-middle">thumb_down</span>&nbsp;<?php echo $obj_imagestats[0]->dislikes ?></span>
                                <span><span class="material-symbols-outlined align-middle">star</span>&nbsp;<?php echo $obj_imagestats[0]->favourites ?></span>
                            </div>
                        </div>
                    </div>
                    </div>
                    <?php
                }
                echo "</div>";
            } else {
                echo "<p>You have no favourite images.</p>";
            }
            ?>
        </div>
    </div>

    <!-- Profile actions -->
    <div class="card profile_actions">
        <div class="card-body">
            <h5 class="card-title">Profile Actions</h5>
            <br>
            <form action="index.php?page=profileAction" method="POST" id="deleteProfileForm">
                <input type="hidden" id="profileId" name="id" value="<?php echo $userId ?>">
                <input type="hidden" id="profileAction" name="action" value="delete">
                <nav><a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmationBox">Delete account</a>&nbsp;<i class="align-middle">Note: All of your uploaded images will also be deleted</i></nav>
            </form>
        </div>
    </div>
</div>
