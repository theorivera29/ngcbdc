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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="../bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>

</head>

<body>
<div id="content">
        <span class="slide">
            <a href="#" class="open" id="sideNav-a" onclick="openSlideMenu()">
                <i class="fas fa-bars"></i>
            </a>
            <h4 class="title">NEW GOLDEN CITY BUILDERS AND DEVELOPMENT CORPORATION</h4>
            <!-- Example single danger button -->
            <div class="btn-group dropdown-account">
                <button type="button" class="btn dropdown-toggle dropdown-settings" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="account.php">Account Settings</a>
                    <a class="dropdown-item" href="">Logout</a>
                </div>
            </div>
        </span>

        <div id="menu" class="navigation sidenav">
            <a href="#" class="close" id="sideNav-a" onclick="closeSlideMenu()">
                <i class="fas fa-times"></i>
            </a>
            <nav id="sidebar">
                <div class="sidebar-header">
                    <h3>NGCBDC</h3>
                </div>

                <ul class="list-unstyled components">
                    <li>
                        <a href="dashboard.php" id="sideNav-a">Dashboard</a>
                    </li>
                    <li class="active">
                        <a href="#siteSubmenu" data-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle" id="sideNav-a">Site</a>
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
                        <a href="#haulingSebmenu" data-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle" id="sideNav-a">Hauling</a>
                        <ul class="collapse list-unstyled" id="haulingSebmenu">
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
                        <a href="reports.php" id="sideNav-a">Reports</a>
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
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                            aria-labelledby="nav-home-tab">
                            <div class="card project-container">
                                <h5 class="card-header card-header-project"><?php echo $row[0] ;?></h5>
                                <div class="card-body">
                                    <span>
                                        <h5><?php echo $row[1] ;?></h5>
                                    </span>
                                    <span>
                                        <h5>Start Date: <?php echo $row[2] ;?></h5>
                                    </span>
                                    <span>
                                        <h5>End Date: <?php echo $row[3] ;?></h5>
                                    </span>
                                    <button type="button" class="btn btn-info" id="view-inventory-btn" type="button"
                                        onclick="window.location.href = 'reportpage.php'">View Report</button>
                                </div>
                            </div>
                        </div>
                        <?php
                            }
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
                            $result1 = mysqli_query($conn, $sql);
                            while ($row1 = mysqli_fetch_row($result1)) {
                        ?>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <div class="card project-container">
                            <h5 class="card-header card-header-project"><?php echo $row1[0] ;?></h5>
                                <div class="card-body">
                                    <span>
                                        <h5><?php echo $row1[1] ;?></h5>
                                    </span>
                                    <span>
                                        <h5>Start Date: <?php echo $row1[2] ;?></h5>
                                    </span>
                                    <span>
                                        <h5>End Date: <?php echo $row1[3] ;?></h5>
                                    </span>
                                    <button type="button" class="btn btn-info" id="view-inventory-btn"
                                        type="button">View inventory</button>
                                </div>
                            </div>
                        </div>
                        <?php
                            }   
                        ?>           
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>
<script>
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