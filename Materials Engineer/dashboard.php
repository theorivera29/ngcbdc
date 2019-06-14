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
                        <a href="#transactionSubmenu" data-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle" id="sideNav-a">Transactions</a>
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

    <div class="row">
        <div class="col-sm-5">
            <div class="card add-task-container">
                <h5 class="card-header">Add To-do Task</h5>
                <form action="../server.php" method="POST" class="needs-validation" novalidate>
                    <div class="card-body">
                        <p id="date-label">Date:</p>
                        <input type="date" class="form-group form-control add-task-date" name="todo_date" id="dateID"
                            required>
                        <div class="invalid-feedback">Please fill out this field.</div>
                        <textarea class="form-control" id="task-textarea" name="todo_task" minlength="2" maxlength="45"
                            pattern="[A-Za-z0-9.,/!-+=()<>@#%^&*]{45}" autocomplete="off" required></textarea>
                        <div class="invalid-feedback">Please fill out this field.</div>
                        <div class="container-counter">
                            <span id="characters">45</span><span id="char"> characters</span>
                        </div>
                        <div class="task-submitbtn-container">
                            <button type="button" class="btn btn-success" id="save-task-btn" data-toggle="modal"
                                data-target="#save-modal">Save</button>
                        </div>
                    </div>
                    <!-- Start of confirmation modal -->
                    <div class="modal fade" id="save-modal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to save
                                        changes?</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        &times;
                                    </button>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="create_todo" class="btn btn-success">Yes</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- End of confirmation modal -->
                </form>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card today-task-container">
                <div class="card-header container-fluid">
                    <div class="row">
                        <div class="col-md-8 ">
                            <h5 class="">Today's To-do Task</h5>
                        </div>
                        <div class="col-md-4 ">
                            <button class="btn btn-light" id="view-all-task-btn" type="button"
                                onclick="window.location.href = 'viewalltasks.php'">View All Task</button>
                        </div>
                    </div>
                </div>
                <div class="card-body todo-task-header">

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
                                    <td><button type="button" class="btn btn-success" data-toggle="modal"
                                            data-target="#done-task-modal-<?php echo $row[0] ;?>">Done
                                        </button></td>
                                    <?php
                                    } else {
                                ?>
                                    <td>
                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#clear-task-modal-<?php echo $row[0] ;?>">Clear
                                        </button></td>
                                    </td>
                                    <?php
                                    }
                                ?>
                                </tr>
                            </tbody>
                            <!-- START DONE MODAL -->
                            <div class="modal fade" id="done-task-modal-<?php echo $row[0] ;?>" tabindex="-1"
                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Are you sure you are done
                                                with this task?</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                &times;
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <?php echo $row[2] ;?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success"
                                                name="update_todo">Yes</button>
                                            <button type="button" class="btn btn-danger"
                                                data-dismiss="modal">No</button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END DONE MODAL -->
                            <!-- START CLEAR MODAL -->
                            <div class="modal fade" id="clear-task-modal-<?php echo $row[0] ;?>" tabindex="-1"
                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to
                                                clear this task?</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                &times;
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <?php echo $row[2] ;?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success"
                                                name="update_todo">Yes</button>
                                            <button type="button" class="btn btn-danger"
                                                data-dismiss="modal">No</button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END CLEAR MODAL -->
                        </form>
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
                </div>
            </div>
        </div>
    </div>

    <div class="card low-in-quantity-container">
        <h5 class="card-header">Materials Low in Quantity</h5>
        <table class="table low-quantity-table table-striped table-bordered" id="mydatatable">
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
                                projmateng.projmateng_mateng = $accounts_id;";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_row($result)) {
                        if($row[2] <= $row[4]) {
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
                    }
                ?>
            </tbody>
        </table>
    </div>

</body>
<script type="text/javascript">
    (function () {
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

    function openSlideMenu() {
        document.getElementById('menu').style.width = '15%';
    }

    function closeSlideMenu() {
        document.getElementById('menu').style.width = '0';
        document.getElementById('content').style.marginLeft = '0';
    }

    $(document).ready(function () {
        $('#mydatatable').DataTable();

        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });

        $('#myModal').on('shown.bs.modal', function () {
            $('#myInput').trigger('focus')
        })

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

        var maxLength = 45;
        $('textarea').keyup(function () {
            var length = $(this).val().length;
            var length = maxLength - length;
            $('#characters').text(length);
        });

        $('#task-textarea').keypress(function (event) {
            if (event.which == 13) {
                event.preventDefault();
            }
        });

        $('#task-textarea').keyup(function () {
            var txt = $('#comment').val();
            $('#comment').val(txt.replace(/[\n\r]+/g, " "));

        });
    });
</script>

</html>