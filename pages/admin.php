<?php
if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] != '1') {
    header('index.php?page=home&error=Access Restricted');
    ?>
    <script type="text/javascript">
        location = "index.php?page=home&error=Access Restricted"
    </script>
    <?php
}
$section = $_GET['section'];
?>

<div class="container-flex">
    <!-- Sidenav -->
    <div class="admin_sidenav">
        <div class="sidenav_item">
            <nav>Admin Tools&nbsp;<span class="material-symbols-outlined align-middle">settings</span></nav>
        </div>
        <div class="sidenav_item">
            <a href="index.php?page=adminPanel&section=filters">Manage Filters</a>
        </div>
        <div class="sidenav_item">
            <a href="index.php?page=adminPanel&section=logs">View Logs</a>
        </div>
    </div>

    <!-- Page content -->
    <div class="admin_content">

        <?php
        //Alert messages
        if (isset($_GET['action']) && $_GET['action'] == "success") {
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert' id='uploadAlert'>
            Operation successfull!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
        if (isset($_GET['action']) && $_GET['action'] == 'failed') {
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert' id='accessAlert'>
            Operation failed!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }

        //Page content according to the selected admin section
        switch($section) {
            case 'filters':
                include('admin/filters.php');
                break;
            case 'logs':
                include('admin/logs.php');
                break;
            default:
                include('admin/filters.php');
                break;
        }
        ?>
    </div>
</div>