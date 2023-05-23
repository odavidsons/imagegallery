<?php
if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] != '1') {
    header('index.php?page=home&error=Access Restricted');
    ?>
    <script type="text/javascript">
        location = "index.php?page=home&error=Access Restricted"
    </script>
    <?php
}
$obj_categories = $DBAccess->getCategories();
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
    ?>

    <nav>
        <div class="nav nav-tabs" id="admin-tab" role="tablist">
            <button class="nav-link active" id="categories-tab" data-bs-toggle="tab" data-bs-target="#categories" type="button" role="tab" aria-controls="categories-tab" aria-selected="true">Categories</button>
        </div>
    </nav>
    <div class="card">
        <div class="tab-content" id="admin-tabContent">
            <div class="tab-pane fade show active" id="categories" role="tabpanel" aria-labelledby="categories" tabindex="0">
                <form action="index.php?page=adminAction&type=category" method="POST">
                    <table class="table" id="admin_categories_table">
                        <thead>
                            <tr class="text-center">
                                <th colspan="2">Manage image categories</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (count($obj_categories) > 0) {
                                for ($i = 0;$i < count($obj_categories);$i++) {
                                    echo "<tr>";
                                    echo "<td style='width:70%;'>".$obj_categories[$i]->name."</td>";
                                    echo "<td><input class='form-check-input' type='checkbox' name='category_id' value='".$obj_categories[$i]->id."' id='admin_categories_chkbox'></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td>There are no categories in the database.</td><tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <table id="admin_categories_buttons">
                        <tbody>
                            <tr>
                                <td style="display:flex;width:70%;">
                                    <input class="form-control" name="category_name" type="text">
                                    &nbsp;
                                    <button class="btn btn-dark" type="submit" name="insert">Add</button>
                                </td>
                                <td>
                                    <button class="btn btn-danger" type="submit" name="delete">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>