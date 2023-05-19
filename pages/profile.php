<?php
$username = $_SESSION['username'];
$userId = $DBUsers->getUserId($username);
$obj_userstats = $DBUsers->getStatsByUserId($userId);
$obj_images = $DBAccess->getImagesByUser($username);

?>
<div class="profile_content">
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a>Home</a></li>
        <li class="breadcrumb-item"><a href="index.php?page=home">Search</a></li>
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
    
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Welcome <?php echo $_SESSION['username'] ?></h5>
            <br>
            <p>Total images uploaded: <?php echo $obj_userstats[0]->total_uploaded ?></p>
            <p>Active images: <?php echo $obj_userstats[0]->active_uploaded ?></p>
        </div>
    </div>
    <div class="card uploaded_images">
        <div class="card-body">
            <h5 class="card-title">Your images</h5>
            <?php
            if (isset($obj_images) && count($obj_images) > 0) {
                echo "<div class='row row-cols-1 row-cols-md-auto g-4'>";
                for ($i = 0;$i < count($obj_images);$i++) {
                    ?>
                    <div class="col">
                    <div class="card h-100 text-center" style="width: 12rem;">
                        <a href="index.php?page=viewimage&id=<?php echo $obj_images[$i]->id ?>">
                        <img src="<?php echo $obj_images[$i]->path ?>" class="card-img-top" alt="image-<?php echo $obj_images[$i]->name ?>">
                        </a>
                        <div class="card-footer text-body-secondary">
                            Name: <?php echo $obj_images[$i]->name ?>
                        </div>
                    </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>You have no uploaded images.</p>";
            }
            ?>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Profile Actions</h5>
            <br>
            <form action="index.php?page=profileAction" method="POST">
                <input type="hidden" id="profileId" name="id" value="<?php echo $userId ?>">
                <input type="hidden" id="profileAction" name="action" value="delete">
                <button class="btn btn-danger">Delete account</button>
            </form>
        </div>
    </div>
</div>