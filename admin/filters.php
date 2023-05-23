<?php
$obj_categories = $DBAccess->getCategories();
?>
<!-- BreadCrumbs -->
<nav aria-label="breadcrumb">
<ol class="breadcrumb">
    <li class="breadcrumb-item">Admin Panel</li>
    <li class="breadcrumb-item active" aria-current="page">Image filters</li>
</ol>
</nav>

<nav>
    <div class="nav nav-tabs" id="admin-tab" role="tablist">
        <button class="nav-link active" id="categories-tab" data-bs-toggle="tab" data-bs-target="#categories" type="button" role="tab" aria-controls="categories-tab" aria-selected="true">Categories</button>
    </div>
</nav>

<div class="card">
    <div class="tab-content" id="admin-tabContent">
        <div class="tab-pane fade show active" id="categories" role="tabpanel" aria-labelledby="categories" tabindex="0">
            <div class="table-responsive" id="admin_categories_table">
                <nav class="text-center fw-bold">Manage image categories</nav>
                <hr>
                <form action="index.php?page=adminAction&type=category" method="POST">
                    <table class="table" >
                        <thead>
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