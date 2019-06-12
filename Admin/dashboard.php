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
                        <a href="#accountSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"
                            id="sideNav-a">Account</a>
                        <ul class="collapse list-unstyled" id="accountSubmenu">
                            <li>
                                <a href="accountcreation.php" id="sideNav-a">Create Account</a>
                            </li>
                            <li>
                                <a href="listofaccounts.php" id="sideNav-a">List of Accounts</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="passwordrequest.php" id="sideNav-a">Password Request</a>
                    </li>
                    <li>
                        <a href="projects.php" id="sideNav-a">Projects</a>
                    </li>
                    <li>
                        <a href="logs.php" id="sideNav-a">Logs</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <div class="row dashboard-card-container">
        <div class="card account-card-container">
            <h5 class="card-header"><a href="listofaccounts.php">Accounts</a></h5>
            <div class="card-body">
                <?php
                    $sql_accounts = "SELECT
                                COUNT(accounts_id)
                            FROM
                                accounts
                            WHERE
                                NOT accounts_deletable = 'no';";
                    $result_accounts = mysqli_query($conn, $sql_accounts);
                    $row_accounts = mysqli_fetch_row($result_accounts);
                ?>
                <p><?php echo $row_accounts[0];?></p>
            </div>
            <h6 class="card-footer">active accounts</h6>
        </div>

        <div class="card password-card-container">
            <h5 class="card-header"><a href="passwordrequest.php">Password Reset</a></h5>
            <div class="card-body">
                <?php
                    $sql_request = "SELECT
                                COUNT(req_id)
                            FROM
                                request
                            WHERE
                                req_status = 'pending';";
                    $result_request = mysqli_query($conn, $sql_request);
                    $row_request = mysqli_fetch_row($result_request);
                ?>
                <p><?php echo $row_request[0];?></p>
            </div>
            <h6 class="card-footer">requesting for a new password</h6>
        </div>

        <div class="card project-card-container">
            <h5 class="card-header"><a href="projects.php">Project</a></h5>
            <div class="card-body">
                <?php
                    $sql_projects = "SELECT
                                COUNT(projects_id)
                            FROM
                                projects
                            WHERE
                                projects_status = 'open';";
                    $result_projects = mysqli_query($conn, $sql_projects);
                    $row_projects = mysqli_fetch_row($result_projects);
                ?>
                <p><?php echo $row_projects[0];?></p>
            </div>
            <h6 class="card-footer">number of projects</h6>
        </div>

    </div>
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