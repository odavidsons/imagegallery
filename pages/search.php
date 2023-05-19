<?php

$obj_images = $DBAccess->getImages();
?>
<div class="container-flex">
    <!-- Sidenav -->
    <div class="home_sidenav">
        <div class="sidenav_item">
            <nav>Filters</nav>
        </div>
        <div class="sidenav_item">
            <button>Link</button>
        </div>
    </div>

    <!-- Breadcrumbs -->
    <div class="home_content">
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php?page=home">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Search</li>
        </ol>
        </nav>
        
        <?php
        //Alert messages
        if (isset($_GET['accountdelete']) && $_GET['accountdelete'] == "success") {
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert' id='uploadAlert'>
            Account deleted successfully!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
        ?>

        <!-- Image List -->
        <div class="home_images">
            <div class="row row-cols-1 row-cols-md-auto g-3">
            <?php
            if (count($obj_images) > 0) {
                for ($i = 0;$i < count($obj_images);$i++) {
                    ?>
                    <div class="col">
                    <div class="card h-100 text-center" style="width: 18rem;">
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
                echo "There are no images uplaoded to the website";
            }
            ?>
            </div>
        </div>
    </div>
</div>