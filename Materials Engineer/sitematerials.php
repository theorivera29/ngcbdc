<?php
    include "../session.php";
    unset($_SESSION['matinfo_id']);
    unset($_SESSION['projects_id']);
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
            <a href="#" class="open" id="sideNav-a" onclick="openSlideMenu()">
                <i class="fas fa-bars"></i>
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

        <div id="menu" class="navigation sidenav">
            <a href="#" class="close" id="sideNav-a" onclick="closeSlideMenu()">
                <i class="fas fa-times"></i>
            </a>
            <nav id="sidebar">
                <div class="sidebar-header">
                    <img src="../Images/login2.png" id="ngcbdc-logo">
                </div>
                <ul class="list-unstyled components">
                    <li>
                        <a href="dashboard.php" id="sideNav-a">Dashboard</a>
                    </li>
                    <li class="active">
                        <a href="#siteSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"
                            id="sideNav-a">Site</a>
                        <ul class="collapse list-unstyled" id="siteSubmenu">
                            <li>
                                <a href="projects.php" id="sideNav-a">Projects</a>
                            </li>
                            <li>
                                <a href="sitematerials.php" id="sideNav-a">Site Materials</a>
                            </li>
                        </ul>
                    </li>
                    <li class="active">
                        <a href="#haulingSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"
                            id="sideNav-a">Hauling</a>
                        <ul class="collapse list-unstyled" id="haulingSubmenu">
                            <li>
                                <a href="fillouthauling.php" id="sideNav-a">Fill out Hauling Receipt</a>
                            </li>
                            <li>
                                <a href="hauleditems.php" id="sideNav-a">View Hauled Materials</a>
                            </li>
                        </ul>
                    </li>
                    <li class="active">
                        <a href="#transactionSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"
                            id="sideNav-a">Transactions</a>
                        <ul class="collapse list-unstyled" id="transactionSubmenu">
                            <li>
                                <a href="requisitionslip.php" id="sideNav-a">Material Requisition Slip</a>
                            </li>
                            <li>
                                <a href="deliveredin.php" id="sideNav-a">Delivered In Form</a>
                            </li>
                            <li>
                                <a href="viewTransactions.php" id="sideNav-a">View Transactions</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="returns.php" id="sideNav-a">Returns</a>
                    </li>
                    <li>
                        <a href="addingOfNewMaterials.php" id="sideNav-a">Adding of Materials</a>
                    </li>
                    <li class="active">
                        <a href="#reportSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"
                            id="sideNav-a">Reports</a>
                        <ul class="collapse list-unstyled" id="reportSubmenu">
                            <li>
                                <a href="currentReport.php" id="sideNav-a">Monthly Report</a>
                            </li>
                            <li>
                                <a href="previousReports.php" id="sideNav-a">Previous Reports</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>

        </div>

    </div>

    <div class="site-materials-container">
        <h5 class="card-header">All Materials in Site</h5>
        <table class="table site-materials-table table-striped table-bordered" id="mydatatable">
            <thead>
                <tr>
                    <th class="align-middle">Particulars</th>
                    <th class="align-middle">Category</th>
                    <th class="align-middle">Previous Material Stock</th>
                    <th class="align-middle">Unit</th>
                    <th class="align-middle">Delivered Material as of <?php echo date("F Y"); ?></th>
                    <th class="align-middle">Material Pulled Out as of <?php echo date("F Y"); ?></th>
                    <th class="align-middle">Accumulated Materials Delivered</th>
                    <th class="align-middle">Material on Site as of <?php echo date("F Y"); ?></th>
                    <th class="align-middle">Unit</th>
                    <th class="align-middle">Project</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql_categ = "SELECT
                                    projmateng_project
                                FROM
                                    projmateng
                                WHERE
                                    projmateng_mateng = $accounts_id;";
                    $result = mysqli_query($conn, $sql_categ);
                    $id_array = array();
                    while($row_categ = mysqli_fetch_assoc($result)){
                        $id_array[] = $row_categ;
                    }

                    foreach($id_array as $data) {
                        $projects_id = $data['projmateng_project'];
                        $sql_categ = "SELECT DISTINCT
                                        categories_name
                                    FROM
                                        materials
                                    INNER JOIN
                                        categories ON categories.categories_id = materials.mat_categ
                                    INNER JOIN
                                        matinfo ON materials.mat_id = matinfo.matinfo_matname
                                    WHERE
                                        matinfo.matinfo_project = $projects_id;";
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
                                        matinfo.currentQuantity
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
                                        matinfo.matinfo_project = $projects_id
                                    ORDER BY 1;";
                            $result = mysqli_query($conn, $sql);
                            while($row = mysqli_fetch_row($result)){
                                $matinfo_id = $row[5];
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
                                                matinfo ON matinfo.matinfo_matname = materials.mat_id
                                            WHERE
                                                matinfo.matinfo_id = $matinfo_id;";
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
                                $sql3 = "SELECT
                                            projects_name
                                        FROM
                                            projects
                                        WHERE
                                            projects_id = $projects_id;";
                                $result3 = mysqli_query($conn, $sql3);
                                $row3 = mysqli_fetch_row($result3);
                ?>
                <tr>
                    <td>
                        <form action="../server.php" method="POST">
                            <input type="hidden" name="matinfo_id" value="<?php echo $row[5] ;?>">
                            <input type="hidden" name="projects_id" value="<?php echo $projects_id ;?>">
                            <button type="submit" class="btn btn-info" name="viewStockCard">
                                <?php echo $row[1] ;?>
                            </button>
                        </form>
                    </td>
                    
                    <td><?php echo $row[2] ;?></td>
                    <td><?php echo $row[3] ;?></td>
                    <td><?php echo $row[4] ;?></td>
                    <td>
                        <?php 
                            if ($row1[0] == 0) {
                                echo 0;
                            } else {
                                echo $row1[0];
                            }
                        ?>
                    </td>
                    <td>
                        <?php 
                            echo $mat_count_use;
                        ?>
                    </td>
                    <td>
                        <?php 
                            if ($row1[0] == 0) {
                                echo 0;
                            } else {
                                echo $row1[0];
                            }
                        ?>
                    </td>
                    <td>
                        <?php 
                            echo $row[6];
                        ?>
                    </td>
                    <td><?php echo $row[4] ;?></td>
                    <td><?php echo $row3[0] ;?></td>
                </tr>
                <?php
                            }
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>

<script type="text/javascript">
    $(document).ready(function () {
        $('#mydatatable').DataTable();
    });

    function openSlideMenu() {
        document.getElementById('menu').style.width = '15%';
    }

    function closeSlideMenu() {
        document.getElementById('menu').style.width = '0';
        document.getElementById('content').style.marginLeft = '0';
    }

    $(document).ready(function () {

        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });

    });
</script>

</html>
