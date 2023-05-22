<?php

$obj_images = $DBAccess->getImages();
?>
<div class="container-flex">
    <!-- Sidenav -->
    <div class="search_sidenav">
        <div class="sidenav_item">
            <button>Filters</button>
        </div>
        <div class="sidenav_item">
            <div id="search_name">
                <input class="form-control" type="text" id="name_input" onkeyup="searchByName()" placeholder="Search image by name">
            </div>
        </div>
        <div class="sidenav_item">
            <div id="search_slider">
            <nav><label for="displayRange" class="form-label">Display ammount:&nbsp;</label><b id="displayRangeOutput"></b></nav>
                <input type="range" class="form-range" min="0" max="50" step="1" id="displayRange">
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
        
        ?>

        <!-- Image List -->
        <div class="search_images">
            <div class="row row-cols-1 row-cols-md-auto g-3">
            <?php
            if (count($obj_images) > 0) {
                for ($i = 0;$i < count($obj_images);$i++) {
                    ?>
                    <div class="col">
                    <div class="card text-center" style="width: 18rem;" data-count="<?php echo $i+1 ?>" data-name="<?php echo $obj_images[$i]->name ?>">
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
    const images = Array.from(imageCards);

    function searchByName() {
        //Get the search input
        var nameInput = document.getElementById("name_input").value.toLowerCase();
            //Search only the images showed on the page, by using current the range slider value
            for (i = 0; i < slider.value; i++) {
                //If the search value relates to the 'name' data value of the imageCard, keep it's style visible
                if (imageCards[i].getAttribute('data-name').toLowerCase().indexOf(nameInput) > -1) {
                    imageCards[i].style.display="";
                } else {
                    imageCards[i].style.display="none";
                }
            }
    }

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
</script>