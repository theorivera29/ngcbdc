<?php
    include "../session.php";
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
    <script src="../js/jquery/jquery-3.4.1.min.js"></script>
    <script src="../js/popper/popper.min.js"></script>
    <script src="../bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
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
                    <li>
                        <a href="returns.php" id="sideNav-a">Returns</a>
                    </li>
                    <li>
                        <a href="addingOfNewMaterials.php" id="sideNav-a">Adding of Materials</a>
                    </li>
                    <li>
                        <a href="requisitionslip.php" id="sideNav-a">Material Requisition</a>
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
    
    <button class="btn btn-warning" id="generate-report" type="button">Generate Report</button>
    <table class="table reportpage-table table-striped table-bordered">
        <thead>
            <tr>
                <th class="align-middle">Particulars</th>
                <th class="align-middle">Previous Material Stock</th>
                <th class="align-middle">Unit</th>
                <th class="align-middle">Delivered Material as of <?php echo date("F Y"); ?></th>
                <th class="align-middle">Material Pulled Out as of <?php echo date("F Y"); ?></th>
                <th class="align-middle">Unit</th>
                <th class="align-middle">Accumulated Materials Delivered</th>
                <th class="align-middle">Material on Site as of <?php echo date("F Y"); ?></th>
                <th class="align-middle">Unit</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $projects_id = $_GET['projects_id'];
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
            ?>
            <tr>
                <td><b> <?php echo $categ ;?> </b> </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php
                $sql = "SELECT 
                            materials.mat_id,
                            materials.mat_name,
                            categories.categories_name,
                            matinfo.matinfo_prevStock,
                            unit.unit_name
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
                                SUM(deliveredin.deliveredin_quantity) FROM deliveredin
                            INNER JOIN 
                                matinfo ON deliveredin.deliveredin_matname = matinfo.matinfo_matname
                            WHERE 
                                matinfo.matinfo_matname = '$row[0]';";
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
                <td><?php echo $row[1] ;?></td>
                <td><?php echo $row[3] ;?></td>
                <td><?php echo $row[4] ;?></td>
                <td>
                    <?php 
                        if($row1[0] == null ){
                            echo 0;
                        } else {
                            echo $row1[0];
                        }
                    ?>
                </td>
                <td>
                    <?php 
                        if($row2[0] == null ){
                            echo 0;
                        } else {
                            echo $row2[0];
                        }
                    ?>
                </td>
                <td><?php echo $row[4] ;?></td>
                <td><?php echo $row[3]+$row1[0] ;?></td>
                <td><?php echo $row[3]+$row1[0]-$row2[0] ;?></td>
                <td><?php echo $row[4] ;?></td>
            </tr>
            <?php
                }
            }
        ?>
        </tbody>
    </table>
</body>
<script type="text/javascript">
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