<?php
    include "../db_connection.php";
?>
<!DOCTYPE html>

<html>

<head>
    <title>NGCBDC</title>
    <link rel="icon" type="image/png" href="Images/NGCB_logo.png">
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" href="../bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="../bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
</head>

<body>
    <input class="form-control site-materials-search" type="text" placeholder="Search" aria-label="Search">
    <table class="table site-materials-table table-striped table-bordered">
        <thead>
            <tr>
                <th class="align-middle">Particulars</th>
                <th class="align-middle">Category</th>
                <th class="align-middle">Previous Material Stock</th>
                <th class="align-middle">Unit</th>
                <th class="align-middle">Delivered Material as of</th>
                <th class="align-middle">Material Pulled Out as of</th>
                <th class="align-middle">Accumulated Materials Delivered</th>
                <th class="align-middle">Material on Site as of</th>
                <th class="align-middle">Unit</th>
                <th class="align-middle">Project</th>
            </tr>
        </thead>
    
        <tbody>
            <?php
                $sql = "SELECT
                            materials.mat_name,
                            categories.categories_name, 
                            matinfo.matinfo_prevStock,
                            unit.unit_name,
                            deliveredin.deliveredin_date,
                            ";
            ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php

            ?>
        </tbody>
    </table>
</body>

</html>