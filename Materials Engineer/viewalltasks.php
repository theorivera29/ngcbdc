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
    <script src="../JS/jquery/jquery-3.4.1.min.js"></script>
    <script src="../JS/popper/popper.min.js"></script>
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
    
    <div class="card view-all-task-container">
        <h5 class="card-header">All Task</h5>
        <div class="card-body">
            <?php
                $sql = "SELECT 
                            todo_id,
                            todo_date,
                            todo_task,
                            todo_status,
                            todoOf 
                        FROM 
                            todo 
                        WHERE 
                            todoOf = $accounts_id ORDER BY todo_task;";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
            ?>
            <table class="table today-task-table">
                <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Task</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <?php 
                    while($row = mysqli_fetch_row($result)) {
                ?>
                <form action="../server.php" method="POST">
                <tbody>
                    <tr>
                        <td><?php echo $row[1] ;?></td>
                        <td><?php echo $row[2] ;?></td>
                        <td><?php echo $row[3] ;?></td>
                        <input type="hidden" name="todo_id" value="<?php echo $row[0];?>">
                        <input type="hidden" name="todo_task" value="<?php echo $row[2];?>">
                        <input type="hidden" name="todo_status" value="<?php echo $row[3];?>">
                        <?php
                            if(strcmp($row[3], "in progress") == 0) {
                        ?>
                        <td><button type="submit" name="update_todo_all" class="btn btn-success">Done</button></td>
                        <?php
                            } else {
                        ?>
                        <td><button type="submit" name="update_todo_all" class="btnbtn-danger">Clear</button></td>
                        <?php
                            }
                        ?>
                    </tr>
                </tbody>
                </form>
                <?php
                    }
                ?>
            </table>
            <?php
                } else {
            ?>
            <div>
                <p id="no-task-text">NO TASK</p>
            </div>
            <?php
                }
            ?>
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