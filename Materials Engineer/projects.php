<?php
    include "../session.php";
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

    <section id="tabs">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 project-tabs">
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                            role="tab" aria-controls="nav-home" aria-selected="true">ONGOING</a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                            role="tab" aria-controls="nav-profile" aria-selected="false">CLOSED</a>
                    </div>
                </div>

                <div class="project-tabs-content">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                            aria-labelledby="nav-home-tab">
                            <table class="table projects-table table-striped table-bordered" id="mydatatable">
                                <thead>
                                    <tr>
                                        <th scope="col">Project Name</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Start Date</th>
                                        <th scope="col">End Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $sql = "SELECT
                                        projects.projects_name,
                                        projects.projects_address,
                                        projects.projects_sdate,
                                        projects.projects_edate,
                                        projects.projects_id
                                    FROM
                                        projects
                                    INNER JOIN
                                        projmateng ON projects.projects_id = projmateng.projmateng_project
                                    WHERE
                                        projmateng.projmateng_mateng = $accounts_id
                                    AND 
                                        projects.projects_status = 'open';";
                                        $result = mysqli_query($conn, $sql);
                                        while ($row = mysqli_fetch_row($result)) {
                                    ?>
                                    <tr>
                                        <form action="../server.php" method="POST">
                                        <td><?php echo $row[0] ;?></td>
                                        <td><?php echo $row[1] ;?></td>
                                        <td><?php echo $row[2] ;?></td>
                                        <td><?php echo $row[3] ;?></td>
                                        <td>
                                            <input type="hidden" name="projects_id" value="<?php echo $row[4];?>">
                                            <button type="submit" class="btn btn-info" id="view-inventory-btn" name="viewInventory">View inventory</button>
                                            <button type="submit" class="btn btn-info" id="" name="addMaterials">Add Materials</button>
                                            <button type="submit" class="btn btn-info" id="" name="reconciliation">Reconciliation</button>
                                        </td>
                                        </form>
                                    </tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <table class="table projects-table table-striped table-bordered display" id="mydatatable">
                                <thead>
                                    <tr>
                                        <th scope="col">Project Name</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Start Date</th>
                                        <th scope="col">End Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                            $sql = "SELECT
                                            projects.projects_name,
                                            projects.projects_address,
                                            projects.projects_sdate,
                                            projects.projects_edate,
                                            projects.projects_id
                                        FROM
                                            projects
                                        INNER JOIN
                                            projmateng ON projects.projects_id = projmateng.projmateng_project
                                        WHERE
                                            projmateng.projmateng_mateng = $accounts_id
                                        AND 
                                            projects.projects_status = 'closed';";
                                            $result = mysqli_query($conn, $sql);
                                            while ($row = mysqli_fetch_row($result)) {
                                        ?>
                                    <tr>
                                        <form action="../server.php" method="POST">
                                        <td><?php echo $row[0] ;?></td>
                                        <td><?php echo $row[1] ;?></td>
                                        <td><?php echo $row[2] ;?></td>
                                        <td><?php echo $row[3] ;?></td>
                                        <td>
                                            <input type="hidden" name="projects_id" value="<?php echo $row[4];?>">
                                            <button type="submit" class="btn btn-info" id="view-inventory-btn" name="viewInventory">View inventory</button>
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
    function openSlideMenu() {
        document.getElementById('menu').style.width = '15%';
    }

    function closeSlideMenu() {
        document.getElementById('menu').style.width = '0';
        document.getElementById('content').style.marginLeft = '0';
    }

    $(document).ready(function () {
        $('#mydatatable').DataTable();
        $('table.display').DataTable();

        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });

    });
</script>

</html>