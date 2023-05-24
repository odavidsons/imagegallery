<?php

$obj_images = $DBAccess->getImages();
?>
<div class="container-flex">
    <!-- Sidenav -->
    <div class="search_sidenav">
        <div class="sidenav_item">
            <nav>Filters&nbsp;<span class="material-symbols-outlined align-middle">filter_list</span></nav>
        </div>
        <div class="sidenav_filter">
            <div id="search_name">
                <input class="form-control" type="text" id="name_input" onkeyup="searchByName()" placeholder="Search image by name">
            </div>
        </div>
        <div class="sidenav_filter">
            <div id="search_slider">
            <nav><label for="displayRange" class="form-label">Display ammount:&nbsp;</label><b id="displayRangeOutput"></b></nav>
                <input type="range" class="form-range" min="0" max="50" step="1" id="displayRange">
            </div>
        </div>
        <div class="sidenav_filter">
            <div id="search_category">
                
                <label for="categorySelect" class="form-label">Category:</label>
                <select onchange="getCategory()" class="form-select" name="categorySelect" id="categorySelect">
                <option selected value="">None</option>
                <?php
                $obj_categories = $DBAccess->getCategories();
                for ($i=0;$i < count($obj_categories);$i++) {
                    echo "<option value='".$obj_categories[$i]->name."'>".$obj_categories[$i]->name."</option>";
                }
                echo "</select>";
                ?>
            </div>
        </div>
    </div>

    <!-- Breadcrumbs -->
    <div class="search_content">
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php?page=home">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Search</li>
        </ol>
        </nav>
        
        <?php
        //Alert messages
        if (isset($_GET['imagedelete']) && $_GET['imagedelete'] == "success") {
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert' id='uploadAlert'>
            Your image was deleted successfully!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
        ?>

        <!-- Image List -->
        <div class="search_images">
            <div class="row row-cols-1 row-cols-md-auto g-3">
            <?php
            if (count($obj_images) > 0) {
                for ($i = 0;$i < count($obj_images);$i++) {
                    //Get the current image's stats
                    $obj_imagestats = $DBAccess->getImageStats($obj_images[$i]->id);
                    ?>
                    <div class="col">
                    <div class="card text-center" style="width: 18rem;" data-count="<?php echo $i+1 ?>" data-name="<?php echo $obj_images[$i]->name ?>" data-category="<?php echo $obj_images[$i]->category ?>">
                        <a href="index.php?page=viewimage&id=<?php echo $obj_images[$i]->id ?>">
                        <img src="<?php echo $obj_images[$i]->path ?>" class="card-img-top" alt="image-<?php echo $obj_images[$i]->name ?>">
                        <div class="card-img-overlay" id="img_view_button">
                            
                        </div>
                        </a>
                        <div class="card-footer text-body-secondary">
                            Name: <?php echo $obj_images[$i]->name ?>
                            <div class="container-flex" id="search_image_stats">
                                <nav><span class="material-symbols-outlined align-middle">thumb_up</span>&nbsp;<span class="align-middle"><?php echo $obj_imagestats[0]->likes ?></span></nav>
                                <nav><span class="material-symbols-outlined align-middle">thumb_down</span>&nbsp;<span class="align-middle"><?php echo $obj_imagestats[0]->dislikes ?></span></nav>
                                <nav><span class="material-symbols-outlined align-middle">star</span>&nbsp;<span class="align-middle"><?php echo $obj_imagestats[0]->favourites ?></span></nav>
                            </div>
                        </div>
                    </div>
                    </div>
                    <?php
                }
            } else {
                echo "There are no images uploaded to the website";
            }
            ?>
            </div>
        </div>
    </div>
</div>
<script>
    //Get the image card elements and store in an array
    imageCards = document.getElementsByClassName("card");
    var images = Array.from(imageCards);

    //Filter by image name
    function searchByName() {
        //Get the search input
        var nameInput = document.getElementById("name_input").value.toLowerCase();
            for (i = 0; i < slider.value; i++) {
                //If the search value relates to the 'name' data value of the imageCard, keep it's style visible
                if (imageCards[i].getAttribute('data-name').toLowerCase().indexOf(nameInput) > -1) {
                    imageCards[i].style.display="";
                } else {
                    imageCards[i].style.display="none";
                }
            }
            
    }

    //Change display ammount
    //Show range slider value
    var slider = document.getElementById("displayRange");
    var output = document.getElementById("displayRangeOutput");
    output.innerHTML = slider.value; // Display the default slider value

    // Update the display value when it is changed
    slider.oninput = function() {
        output.innerHTML = this.value;
        var maxImageCount = this.value;
        images.forEach((image) => {
            //If the 'count' data value is higher than the allowed ammount of images, hide the element
            if (image.getAttribute('data-count') > parseInt(maxImageCount)) {
                image.style.display="none";
            } else {
                image.style.display="";
            }
        });
    }

    //Filter by image category
    //Get selected option
    function getCategory() {
        selectedCategory = document.getElementById("categorySelect").value;
        images.forEach((image) => {
            if (selectedCategory != '') {
                //If an image has a differente category than the selected one, set it's display style to 'none'
                if (image.getAttribute('data-category') != selectedCategory) {
                    image.style.display="none";
                } else {
                    image.style.display=""; 
                }
            } else {
                image.style.display="";
            }
        });
    }

    
</script>