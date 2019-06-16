<?php
    include "../session.php";
    if (isset($_SESSION['projects_id'])) {
        $projects_id = $_SESSION['projects_id'];
        unset($_SESSION['categories_id']);
    } else {
        header("Location:http://127.0.0.1/NGCBDC/View%Only/projects.php");  
    }
    $sql_name = "SELECT 
                    projects_name
                FROM
                    projects
                WHERE
                    projects_id = $projects_id;";
    $result_name = mysqli_query($conn, $sql_name);
    $row_name = mysqli_fetch_row($result_name);
    $projects_name = $row_name[0];
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
                        <a class="dropdown-item" href="account.php">Account Settings</a>
                        <a class="dropdown-item" href="../logout.php">Logout</a>
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
                                        <th>Delivered Material as of <?php echo date("F Y"); ?></th>
                                        <th>Material pulled out as of <?php echo date("F Y"); ?></th>
                                        <th>Unit</th>
                                        <th>Accumulated Materials Delivered</th>
                                        <th>Material on site as of <?php echo date("F Y"); ?></th>
                                        <th>Unit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql_categ = "SELECT DISTINCT
                                                    categories_name
                                                FROM
                                                    materials
                                                INNER JOIN
                                                    categories ON categories.categories_id = materials.mat_categ
                                                INNER JOIN
                                                    matinfo ON materials.mat_id = matinfo.matinfo_matname;";
                                    $result = mysqli_query($conn, $sql_categ);
                                    $categories = array();
                                    while($row_categ = mysqli_fetch_assoc($result)){
                                        $categories[] = $row_categ;
                                    }

                                    foreach($categories as $data) {
                                        $categ = $data['categories_name'];                                        
                                        $sql = "SELECT 
                                                    materials.mat_id,
                                                    materials.mat_name,
                                                    categories.categories_name,
                                                    matinfo.matinfo_prevStock,
                                                    unit.unit_name,
                                                    matinfo.matinfo_id,
                                                    matinfo.currentQuantity,
                                                    matinfo.matinfo_id
                                                FROM
                                                    materials
                                                INNER JOIN 
                                                    categories ON materials.mat_categ = categories.categories_id
                                                INNER JOIN 
                                                    unit ON materials.mat_unit = unit.unit_id
                                                INNER JOIN
                                                    matinfo ON materials.mat_id = matinfo.matinfo_matname
                                                WHERE 
                                                    categories.categories_name = '$categ' 
                                                AND 
                                                matinfo.matinfo_project = '$projects_id'
                                                ORDER BY 1;";
                                        $result = mysqli_query($conn, $sql);
                                        while($row = mysqli_fetch_row($result)){
                                            $matinfo_id = $row[7];
                                            $sql1 = "SELECT 
                                                        SUM(deliveredmat.deliveredmat_qty) 
                                                    FROM 
                                                        deliveredmat
                                                    WHERE 
                                                        deliveredmat.deliveredmat_materials = '$row[0]';";
                                            $result1 = mysqli_query($conn, $sql1);
                                            $row1 = mysqli_fetch_row($result1);
                                            $sql_mat = "SELECT
                                                            unit.unit_name,
                                                            materials.mat_id
                                                        FROM
                                                            materials
                                                        INNER JOIN
                                                            unit ON unit.unit_id = materials.mat_unit
                                                        INNER JOIN
                                                            matinfo ON matinfo.matinfo_matname = materials.mat_id";
                                            $result_mat = mysqli_query($conn, $sql_mat);
                                            $mat_count_use = 0;
                                            while ($row_mat = mysqli_fetch_row($result_mat)) {
                                                $sql_use = "SELECT
                                                                requisition.requisition_date,
                                                                reqmaterial.reqmaterial_qty,
                                                                requisition.requisition_reqBy,
                                                                reqmaterial.reqmaterial_areaOfUsage,
                                                                requisition.requisition_remarks
                                                            FROM
                                                                requisition
                                                            INNER JOIN
                                                                reqmaterial ON reqmaterial.reqmaterial_requisition = requisition.requisition_id
                                                            WHERE
                                                                reqmaterial.reqmaterial_material = $row_mat[1];";
                                                $result_use = mysqli_query($conn, $sql_use);
                                                while ($row_use = mysqli_fetch_row($result_use)) {
                                                $mat_count_use = $mat_count_use + $row_use[1];
                                                    }
                                                $sql_use = "SELECT
                                                                hauling.hauling_date,
                                                                haulingmat.haulingmat_qty,
                                                                hauling.hauling_requestedBy,
                                                                hauling.hauling_deliverTo,
                                                                hauling.hauling_status
                                                            FROM
                                                                hauling
                                                            INNER JOIN
                                                                haulingmat ON hauling.hauling_id = haulingmat.haulingmat_haulingid
                                                            WHERE
                                                                haulingmat.haulingmat_matname = $row_mat[1];";
                                                $result_use = mysqli_query($conn, $sql_use);
                                                while ($row_use = mysqli_fetch_row($result_use)) {
                                                $mat_count_use = $mat_count_use + $row_use[1];
                                                    }
                                                }
                                ?>
                                    <tr>
                                        <td><?php echo $row[1] ;?></td>
                                        <td><?php echo $row[2] ;?></td>
                                        <td><?php echo $row[3] ;?></td>
                                        <td><?php echo $row[4] ;?></td>
                                        <td><?php echo $row1[0] ;?></td>
                                        <td><?php echo $mat_count_use ;?></td>
                                        <td><?php echo $row[4] ;?></td>
                                        <td><?php echo $row1[0] ;?></td>
                                        <td><?php echo $row[6] ;?></td>
                                        <td><?php echo $row[4] ;?></td>
                                    </tr>
                                    <?php
                                        }
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <?php
                                $sql = "SELECT DISTINCT
                                            categories.categories_id,
                                            categories.categories_name
                                        FROM
                                            materials
                                        INNER JOIN
                                            categories ON categories.categories_id = materials.mat_categ
                                        INNER JOIN
                                            matinfo ON materials.mat_id = matinfo.matinfo_matname
                                        WHERE
                                            matinfo.matinfo_project = $projects_id;";
                                $result = mysqli_query($conn, $sql);
                                while($row = mysqli_fetch_row($result)){
                            ?>
                            <div class="card ">
                                <form action="../server.php" method="POST">
                                    <h5 class="card-header"><?php echo $row[1];?></h5>
                                    <div class="card-body">
                                        <input type="hidden" name="categories_id" value="<?php echo $row[0]; ?>">
                                        <button type="submit" name="materialCategories" class="btn btn-info"
                                            id="open-category-btn" name="materialCategories">View</button>
                                    </div>
                                </form>
                            </div>
                            <?php
                                }
                            ?>
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