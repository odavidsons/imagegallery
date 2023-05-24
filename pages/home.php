<?php

$obj_images = $DBAccess->getImages();
?>
<div class="container-flex">
    <div class="home_content">
        <!-- Breadcrumbs -->
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a>Home</a></li>
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
        if (isset($_GET['accessrestricted']) && $_GET['accessrestricted'] == 'true') {
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert' id='accessAlert'>
            Access to this page is restricted!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
        ?>

        <!-- Homepage Content -->
        <div class="home_content">
            <div class="container-centered">
                <div class="card text-center" id="home_welcome_card">
                    <div class="card-body">
                        <h5 class="card-title">Welcome</h5>
                        <br>
                        <p class="card-text">This is your personal image gallery. Feel free to make changes for it to fit your likings</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>