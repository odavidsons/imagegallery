<?php
if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] != '1') {
    header('index.php?page=home&error=Access Restricted');
    ?>
    <script type="text/javascript">
        location = "index.php?page=home&error=Access Restricted"
    </script>
    <?php
}
?>
<!-- BreadCrumbs -->
<nav aria-label="breadcrumb">
<ol class="breadcrumb">
    <li class="breadcrumb-item">Admin Panel</li>
    <li class="breadcrumb-item active" aria-current="page">Image filters</li>
</ol>
</nav>

<!-- Page content -->
<div class="admin_content">
    <nav>
        <div class="nav nav-tabs" id="admin-tab" role="tablist">
            <button class="nav-link active" id="categories-tab" data-bs-toggle="tab" data-bs-target="#categories" type="button" role="tab" aria-controls="categories-tab" aria-selected="true">Categories</button>
        </div>
    </nav>
    <div class="tab-content" id="admin-tabContent">
        <div class="tab-pane fade show active" id="categories" role="tabpanel" aria-labelledby="categories" tabindex="0">Add image categories

        </div>
    </div>
</div>