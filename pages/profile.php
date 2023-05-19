<?php
$userId = $DBUsers->getUserId($_SESSION['username']);
$obj_userstats = $DBUsers->getStatsById($userId);
?>
<div class="profile_content">
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a>Home</a></li>
        <li class="breadcrumb-item"><a href="index.php?page=home">Search</a></li>
        <li class="breadcrumb-item active" aria-current="page">Profile</li>
    </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Welcome <?php echo $_SESSION['username'] ?></h5>
            <br>
            <p>Total images uploaded: <?php echo $obj_userstats[0]->total_uploaded ?></p>
            <p>Active images uploaded: <?php echo $obj_userstats[0]->active_uploaded ?></p>
        </div>
    </div>
</div>