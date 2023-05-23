<?php
//Log entry example:
//id | type | name | user | date
//1  | upload | uploads/image.png | John | 2023-05-05
$obj_Logs = $DBAccess->getLogs();
?>
<!-- BreadCrumbs -->
<nav aria-label="breadcrumb">
<ol class="breadcrumb">
    <li class="breadcrumb-item">Admin Panel</li>
    <li class="breadcrumb-item active" aria-current="page">Logs</li>
</ol>
</nav>

<div class="card">
    <div class="table-responsive" id="logs_table">
    <nav class="text-center fw-bold">View Logs</nav>
    <hr>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Type</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i=0;$i < count($obj_Logs);$i++) {
                    echo "<tr>";
                    echo "<td>".($i+1)."</td>";
                    echo "<td>".$obj_Logs[$i]->type."</td>";
                    echo "<td>".$obj_Logs[$i]->name."</td>";
                    echo "<td>".$obj_Logs[$i]->username."</td>";
                    echo "<td>".$obj_Logs[$i]->date."</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>