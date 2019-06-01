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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
        integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" href="../bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap-datetimepicker.min.css">
    <script src="../JS/jquery/jquery-3.4.1.min.js"></script>
    <script src="../JS/popper/popper.min.js"></script>
    <script src="../bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
    <script src="bootstrap-datetimepicker.min.js"></script>

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
                        <a class="dropdown-item" href="">Logout</a>
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
                        <a href="#haulingSebmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"
                            id="sideNav-a">Hauling</a>
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

    <div class="row">
        <div class="col-sm-5">
            <div class="card add-task-container">
                <h5 class="card-header">Add To-do Task</h5>
                <form action="../server.php" method="POST" class="needs-validation" novalidate>
                    <div class="card-body">
                        <p id="date-label">Date:</p>
                        <input type="date" class="form-group form-control add-task-date" name="todo_date" id="dateID" required>
                        <div class="invalid-feedback">Please fill out this field.</div>
                        <textarea class="form-control" id="task-textarea" name="todo_task" required></textarea>
                        <div class="invalid-feedback">Please fill out this field.</div>
                        <button type="submit" class="btn btn-success" id="save-task-btn"
                            name="create_todo">Save</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card today-task-container">
                <div class="card-header container-fluid">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="">Today's To-do Task</h5>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-light" id="view-all-task-btn" type="button"
                                onclick="window.location.href = 'viewalltasks.php'">View All Task</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="../server.php" method="POST">
                        <?php
                        $date_today = date("Y-m-d");
                        $sql = "SELECT 
                                    todo_id,
                                    todo_date,
                                    todo_task,
                                    todo_status,
                                    todoOf 
                                FROM 
                                    todo 
                                WHERE 
                                    todoOf = $accounts_id && todo_date = '$date_today' ORDER BY todo_task;";
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
                                    <td><button type="submit" name="update_todo" data-toggle="modal"
                                            data-target="#done-task-modal" class="btn btn-success">Done</button>
                                    </td>
                                    <?php
                                    } else {
                                ?>
                                    <td><button type="submit" name="update_todo" data-toggle="modal"
                                            data-target="#clear-task-modal" class="btnbtn-danger">Clear</button>
                                    </td>
                                    <?php
                                    }
                                ?>
                                </tr>
                            </tbody>
                            <?php
                            }
                        ?>
                        </table>
                        <?php
                        } else {
                    ?>
                        <div>
                            <p id="no-task-text">NO TASK FOR TODAY</p>
                        </div>
                        <?php
                        }
                    ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card low-in-quantity-container">
        <h5 class="card-header">Materials Low in Quantity</h5>
        <table class="table low-quantity-table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">Material Name</th>
                    <th scope="col">Category</th>
                    <th scope="col">Quantity Remaining</th>
                    <th scope="col">Unit</th>
                    <th scope="col">Threshold</th>
                    <th scope="col">Projects</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT 
                                materials.mat_name, 
                                categories.categories_name, 
                                matinfo.currentQuantity, 
                                unit.unit_name, 
                                matinfo.matinfo_notif, 
                                projects.projects_name 
                            FROM
                                materials
                            INNER JOIN
                                categories ON materials.mat_categ = categories.categories_id
                            INNER JOIN
                                matinfo ON materials.mat_id = matinfo.matinfo_id
                            INNER JOIN
                                unit ON materials.mat_unit = unit.unit_id
                            INNER JOIN
                                projects ON matinfo.matinfo_project = projects.projects_id
                            INNER JOIN
                                projmateng ON projmateng.projmateng_project = projects.projects_id
                            WHERE 
                                projmateng.projmateng_mateng = $accounts_id";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_row($result)) {
                ?>
                <tr>
                    <td><?php echo $row[0] ;?></td>
                    <td><?php echo $row[1] ;?></td>
                    <td><?php echo $row[2] ;?></td>
                    <td><?php echo $row[3] ;?></td>
                    <td><?php echo $row[4] ;?></td>
                    <td><?php echo $row[5] ;?></td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="done-task-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you are done with this task?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="clear-task-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to clear this task?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
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

    $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').trigger('focus')
    })

    $(document).ready(function () {
            //Display Only Date till today // 
            var dtToday = new Date();
            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate();
            var year = dtToday.getFullYear();
            if (month < 10)
                month = '0' + month.toString();
            if (day < 10)
                day = '0' + day.toString();

            var today = year + '-' + month + '-' + day;
            $('#dateID').attr('min', today);

        });
    
        $(function () {
            'use strict';
            window.addEventListener('load', function () {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
</script>

</html>