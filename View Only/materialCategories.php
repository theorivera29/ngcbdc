<?php
    include "../db_connection.php";
    session_start();

    $accounts_id = $_SESSION['account_id'];    
?>

<!DOCTYPE html>

<html>

<head>
    <!-- Hindi lahat ng ito ay need -->
    <title>NGCBDC</title>
    <link rel="icon" type="image/png" href="Images/NGCB_logo.png">
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
        integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

</head>

<body>
<div id="content">
        <span class="slide">
            <a href="#" class="open" onclick="openSlideMenu()">
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
            <a href="#" class="close" onclick="closeSlideMenu()">
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
                        <a href="returnsOrReplaced.php" id="sideNav-a">Returns/Replacements</a>
                    </li>
                    <li>
                        <a href="addingOfMaterials.php" id="sideNav-a">Adding of Materials</a>
                    </li>
                    <li>
                        <a href="reports.php" id="sideNav-a">Reports</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    
    <h4 class="category-title">NAME OF CATEGORY</h4>
    <div class="list-of-accounts-container">
        <table class="table list-of-accounts-table table-striped table-bordered" id="mydatatable">
            <thead>
                <tr>
                    <th scope="col">Particulars</th>
                    <th scope="col">Previous Material Stock</th>
                    <th scope="col">Unit</th>
                    <th scope="col">Delivered Material as of Month</th>
                    <th scope="col">Material Pulled out as of Month</th>
                    <th scope="col">Unit</th>
                    <th scope="col">Accumulated Materials Delivered</th>
                    <th scope="col">Materials on site as of Month</th>
                    <th scope="col">Unit</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $projects_id = $_GET['projects_id'];
                $categories_id = $_GET['categories_id'];
                    
                $sql = "SELECT 
                            materials.mat_id,
                            materials.mat_name,
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
                        materials.mat_categ = $categories_id
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
                        <td><?php echo $row[2] ;?></td>
                        <td><?php echo $row[3] ;?></td>
                        <td><?php echo $row1[0] ;?></td>
                        <td><?php echo $row2[0] ;?></td>
                        <td><?php echo $row[3] ;?></td>
                        <td><?php echo $row[2]+$row1[0] ;?></td>
                        <td><?php echo $row[2]+$row1[0]-$row2[0] ;?></td>
                        <td><?php echo $row[3] ;?></td>
                    </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
</script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#mydatatable').DataTable();
    });
</script>

</html>