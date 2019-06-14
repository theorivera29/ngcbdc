
<?php
    include "../session.php";
    if (isset($_SESSION['projects_id'])) {
        $projects_id = $_SESSION['projects_id'];
        unset($_SESSION['categories_id']);
    } else {
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/projects.php");  
    }
    $sql_project_name = "SELECT 
                            projects_name
                        FROM
                            projects
                        WHERE
                            projects_id = $projects_id;";
    $result = mysqli_query($conn, $sql_project_name);
    $row = mysqli_fetch_row($result);
    $projects_name = $row[0];
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
            <a href="#" class="open" onclick="window.location.href='projects.php'">
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
        <div class="view-inventory-container">
            <div class="row view-inventory-row">
                <h4 class="project-title"><?php echo $projects_name ;?></h4>
                <div class="col-xs-12 project-tabs">
                    <nav>
                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-mat-tab" data-toggle="tab" href="#nav-mat"
                                role="tab" aria-controls="nav-mat" aria-selected="true">SITE MATERIALS</a>
                            <a class="nav-item nav-link" id="nav-category-tab" data-toggle="tab" href="#nav-category"
                                role="tab" aria-controls="nav-category" aria-selected="false">CATEGORY</a>
                        </div>
                    </nav>
                </div>
                <div class="view-inventory-tabs-content">
                    <div class="tab-content view-inventory-content" id="nav-tabContent">
                        <div class="tab-pane fade show active view-inventory-tabs-container" id="nav-mat"
                            role="tabpanel" aria-labelledby="nav-mat-tab">
                            <table class="table view-inventory-tabs-table table-striped table-bordered display"
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
                                            $sql1 = "SELECT 
                                                        SUM(deliveredmat.deliveredmat_qty) 
                                                    FROM 
                                                        deliveredmat
                                                    WHERE 
                                                        deliveredmat.deliveredmat_materials = '$row[0]';";
                                            $result1 = mysqli_query($conn, $sql1);
                                            $row1 = mysqli_fetch_row($result1);
                                            $sql2 = "SELECT 
                                                        SUM(usagein.usagein_quantity) FROM usagein
                                                    INNER JOIN 
                                                        matinfo ON usagein.usagein_matname = matinfo.matinfo_matname
                                                    WHERE 
                                                        matinfo.matinfo_matname = '$row[0]';";
                                            $result2 = mysqli_query($conn, $sql2);
                                            $row2 = mysqli_fetch_row($result2);
                                ?>
                                    <tr>
                                        <td>
                                            <form action="../server.php" method="POST">
                                                <input type="hidden" name="matinfo_id" value="<?php echo $row[5] ;?>">
                                                <button type="submit" class="btn btn-info" name="viewStockCard"><?php echo $row[1] ;?></button>
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
                                                if ($row2[0] == 0) {
                                                    echo 0;
                                                } else {
                                                    echo $row2[0];
                                                }
                                            ?>
                                        </td>
                                        <td><?php echo $row[4] ;?></td>
                                        <td>
                                            <?php 
                                                if (($row[3]+$row1[0]) == 0) {
                                                    echo 0;
                                                } else {
                                                    echo $row[3]+$row1[0];
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php 
                                                if (($row[3]+$row1[0]-$row2[0]) == 0) {
                                                    echo 0;
                                                } else {
                                                    echo $row[3]+$row1[0]-$row2[0];
                                                }
                                            ?>
                                        </td>
                                        <td><?php echo $row[4] ;?></td>
                                    </tr>
                                    <?php
                                        }
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="nav-category" role="tabpanel" aria-labelledby="nav-category-tab">
                        <table class="table category-table table-striped table-bordered display"
                                id="mydatatable">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sql = "SELECT DISTINCT
                                            categories.categories_id,
                                            categories_name
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
                                    <tr>
                                        <form action="../server.php" method="POST">
                                        <td><?php echo $row[1] ;?></button>
                                        </td>
                                        <td>
                                        <input type="hidden" name="categories_id" value="<?php echo $row[0]; ?>">
                                        <button type="submit" name="materialCategories" class="btn btn-info" id="open-category-btn">View</button>

                                        </td>
                                        </form>
                                    </tr>
                                    <?php
                                        }
                                ?>
                                </tbody>
                            </table>

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
        $('table.display').DataTable();
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });
    });
</script>

</html>