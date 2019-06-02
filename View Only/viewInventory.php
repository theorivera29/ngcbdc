<?php
    include "../db_connection.php";
    session_start();

    $accounts_id = $_SESSION['account_id'];
?>

<!DOCTYPE html>

<html>

<head>
    <title>NGCBDC</title>
    <link rel="icon" type="image/png" href="../Images/login2.png">
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" href="../bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
        integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <script src="../js/jquery/jquery-3.4.1.min.js"></script>
    <script src="../js/popper/popper.min.js"></script>
    <script src="../bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
</head>

<body>
    <div id="content">
        <span class="slide">
            <a href="#" class="open" id="sideNav-a" onclick="window.location.href='projects.php'">
                <i class="fas fa-arrow-circle-left"></i>
            </a>
            <h4 class="title">NEW GOLDEN CITY BUILDERS AND DEVELOPMENT CORPORATION</h4>
            <div class="account-container">
                <?php 
                        $sql = "SELECT * FROM accounts WHERE accounts_id = '$accounts_id'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_row($result);
            ?>
                <h5 class="active-user">
                    <?php echo $row[1]." ".$row[2]; ?>
                </h5>
                <div class="btn-group dropdown-account">
                    <button type="button" class="btn dropdown-toggle dropdown-settings" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="">Logout</a>
                    </div>
                </div>
            </div>
        </span>

    </div>

    <section id="tabs">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 project-tabs">
                    <nav>
                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                                role="tab" aria-controls="nav-home" aria-selected="true">SITE MATERIALS</a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                                role="tab" aria-controls="nav-profile" aria-selected="false">CATEGORY</a>
                        </div>
                    </nav>
                </div>
                <div class="view-inventory-tabs-content">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active view-inventory-tabs-container" id="nav-home"
                            role="tabpanel" aria-labelledby="nav-home-tab">
                            <table class="table view-inventory-tabs-table table-striped table-bordered"
                                id="mydatatable">
                                <thead>
                                    <tr>
                                        <th>Particulars</th>
                                        <th>Category</th>
                                        <th>Previous Material Stock</th>
                                        <th>Unit</th>
                                        <th>Delivered Material as of May 2019</th>
                                        <th>Material pulled out as of May 2019</th>
                                        <th>Unit</th>
                                        <th>Accumulated Materials Delivered</th>
                                        <th>Material on site as of May 2019</th>
                                        <th>Unit</th>
                                        <th>Project</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT 
                                                materials.mat_name,
                                                categories.categories_name,
                                                matinfo.matinfo_prevStock,
                                                unit.unit_name,
                                                deliveredin.deliveredin_quantity,
                                                usagein.usagein_quantity,
                                                (matinfo.matinfo_prevStock + deliveredin.deliveredin_quantity),
                                                (matinfo.matinfo_prevStock + deliveredin.deliveredin_quantity - usagein.usagein_quantity)
                                            FROM
                                                materials
                                            INNER JOIN 
                                                categories ON materials.mat_categ = categories.categories_id
                                            INNER JOIN 
                                                unit ON materials.mat_unit = unit.unit_id
                                            INNER JOIN
                                                deliveredin ON materials.mat_id = deliveredin.deliveredin_matname
                                            INNER JOIN
                                                usagein ON materials.mat_id = usagein.usagein_matname
                                            INNER JOIN
                                                matinfo ON materials.mat_id = matinfo.matinfo_matname;";
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
                                        <td></td>
                                    </tr>
                                    <?php

                                ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <div class="card ">
                                <h5 class="card-header">Category Name</h5>
                                <div class="card-body">
                                    <button type="button" class="btn btn-info" id="open-category-btn" type="button"
                                        onclick="window.location.href='materialCategories.php'">View</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>
    
<script type="text/javascript">
    $(document).ready(function () {
        $('#mydatatable').DataTable();

        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });
    
        $('#example').DataTable({
            columnDefs: [{
                orderable: false,
                className: 'select-checkbox',
                targets: 0
            }],
            select: {
                style: 'os',
                selector: 'td:first-child'
            },
            order: [
                [1, 'asc']
            ]
        });
    });

    function openSlideMenu() {
        document.getElementById('menu').style.width = '15%';
    }

    function closeSlideMenu() {
        document.getElementById('menu').style.width = '0';
        document.getElementById('content').style.marginLeft = '0';
    }

</script>


</html>