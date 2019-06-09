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
            <a href="#" class="open" onclick="window.location.href='dashboard.php'">
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
            <table class="table today-task-table table-striped table-bordered" id="mydatatable">
                <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Task</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>

                <form action="../server.php" method="POST">
                    <tbody>
                        <?php 
                    while($row = mysqli_fetch_row($result)) {
                ?>
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
                            <td><button type="button" class="btn btn-danger" data-toggle="modal"
                                    data-target="#clear-task-modal-<?php echo $row[0] ;?>">Clear
                                </button></td>
                            <?php
                            }
                        ?>
                        </tr>
                        <!-- START DONE MODAL -->
                        <div class="modal fade" id="done-task-modal-<?php echo $row[0] ;?>" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Are you sure you are done with
                                            this task?
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            &times;
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <?php echo $row[2] ;?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-success">Yes</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END DONE MODAL -->
                        <!-- START CLEAR MODAL -->
                        <div class="modal fade" id="clear-task-modal-<?php echo $row[0] ;?>" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to clear
                                            this task?
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            &times;
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <?php echo $row[2] ;?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-success">Yes</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END CLEAR MODAL -->
                        <?php
                    }
                ?>
                    </tbody>
                </form>

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

        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });

    });
</script>

</html>