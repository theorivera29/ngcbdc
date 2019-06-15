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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <script src="../js/jquery/jquery-3.4.1.min.js"></script>
    <script src="../js/popper/popper.min.js"></script>
    <script src="../bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
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
                    <button type="button" class="btn dropdown-toggle dropdown-settings" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                        <a href="#accountSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" id="sideNav-a">Account</a>
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

    <section id="tabs">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 project-tabs">
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">ONGOING</a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">CLOSED</a>
                    </div>
                    <button type="button" class="btn btn-primary add-project-btn" data-dismiss="modal" onclick="window.location.href = 'addProject.php'">Add Project</button>
                </div>
            </div>
            <div class="project-tabs-content">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <table class="table projects-table table-striped table-bordered display" id="mydatatable">
                            <thead>
                                <tr>
                                    <th scope="col">Project Name</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Start Date</th>
                                    <th scope="col">End Date</th>
                                    <th scope="col">Materials Engineer Involved</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "SELECT
                                        projects_name,
                                        projects_address,
                                        projects_sdate,
                                        projects_edate,
                                        projects_id
                                    FROM
                                        projects
                                    WHERE
                                        projects_status = 'open';";
                                        $result = mysqli_query($conn, $sql);
                                        while ($row = mysqli_fetch_row($result)) {
                                    ?>

                                <tr>
                                    <td>
                                        <?php echo $row[0] ;?>
                                    </td>
                                    <td>
                                        <?php echo $row[1] ;?>
                                    </td>
                                    <td>
                                        <?php echo $row[2] ;?>
                                    </td>
                                    <td>
                                        <?php echo $row[3] ;?>
                                    </td>
                                    <td class="mat-eng-involved">
                                        <?php
                                    $proj_id = $row[4];        
                                    $sql1 = "SELECT CONCAT (accounts.accounts_fname, ' ', accounts.accounts_lname) FROM projmateng INNER JOIN accounts ON projmateng.projmateng_mateng = accounts.accounts_id WHERE projmateng_project = $proj_id AND accounts.accounts_status = 'active';";
                                        $result1 = mysqli_query($conn, $sql1);
                                        while ($row1 = mysqli_fetch_row($result1)) {
                                    ?>
                                        <ul>
                                            <li>
                                                <?php echo $row1[0]; ?>
                                            </li>
                                        </ul>
                                        <?php
                                        }
                                ?>
                                    </td>
                                    <td><input type="hidden" name="projects_id" value="<?php echo $row[4];?>">
                                        <input type="hidden" name="projectName" value="<?php echo $row[0];?>">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit-project-modal-<?php echo $row[4]?>">Edit</button>
                                        <button type="button" class="btn btn-danger" name="close_project" data-toggle="modal" data-target="#close-proj-modal-<?php echo $row[4]?>">Close
                                            Project</button>
                                    </td>
                                </tr>
                                <!-- Start of Edit Modal -->
                                <div class="modal fade" id="edit-project-modal-<?php echo $row[4]?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <?php
                                                $sqledit = "SELECT projects_name, projects_address, projects_sdate, projects_edate FROM projects WHERE projects_id = $row[4];";
                                                $resultedit = mysqli_query($conn, $sqledit);
                                                while($rowedit = mysqli_fetch_row($resultedit)){
                                            ?>
                                        <div class="modal-content">
                                            <form action="../server.php" method="POST">
                                                <input type="hidden" name="projects_id" value="<?php echo $row[4];?>">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit
                                                        <?php echo $rowedit[0]?> Project</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        &times;
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="projectName" class="label-styles">Project
                                                            Name</label>
                                                        <input type="text" class="form-control" value="<?php echo $rowedit[0]?>" name="newProjectName" placeholder="Enter new project name">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="address" class="label-styles">Address:</label>
                                                        <input type="text" class="form-control" value="<?php echo $rowedit[1]?>" name="newAddress" placeholder="Enter new project address">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="startDate" class="label-styles">Start
                                                            Date:</label>
                                                        <input type="date" value="<?php echo $rowedit[2]?>" name="newStartDate" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="endDate" class="label-styles">End Date:</label>
                                                        <input type="date" value="<?php echo $rowedit[3]?>" name="newEndDate" class="form-control">
                                                    </div>
                                                    <?php
                                                            }   
                                                        ?>
                                                    <!--
                                                        
-->
                                                    <label class="label-styles">Materials Engineer Involved</label>

                                                    <?php
                                                        $proj_id = $row[4];        
                                                        $sql1 = "SELECT CONCAT (accounts.accounts_fname, ' ', accounts.accounts_lname), projmateng_mateng FROM projmateng INNER JOIN accounts ON projmateng.projmateng_mateng = accounts.accounts_id WHERE projmateng_project = $proj_id AND accounts.accounts_status = 'active';";
                                                        $result1 = mysqli_query($conn, $sql1);
                                                        while ($row1 = mysqli_fetch_row($result1)) {
                                                    ?>
                                                    <div class="input-group mb-2 col-md-12">

                                                        <div class="input-group-prepend col-md-12 options">

                                                            <div class="input-group-text">
                                                                <input type="checkbox" name="mateng[]" aria-label="Checkbox for following text input" value="<?php echo $row1[1]; ?>">
                                                            </div>

                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" value="<?php echo $row1[0]; ?>" disabled>
                                                        </div>
                                                    </div>
                                                    <?php
                                                        }
                                                    ?>
                                                    <div class="modal-footer">
                                                        <input type="hidden" name="project" value="<?php echo $row[4]; ?>">
                                                        <input type="submit" name="delete_projmateng" class="btn btn-success" value="Remove">
                                                        <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                                                    </div>

                                                    <label class="label-styles">Add Materials Engineer</label>

                                                    <?php
                                                        $proj_id = $row[4];
                                                        $sqlmateng = "SELECT CONCAT (accounts_fname, ' ', accounts_lname ), accounts_id  FROM accounts WHERE accounts_type = 'Materials Engineer' AND accounts_deletable = 'yes' AND accounts_status = 'active' AND accounts_id NOT IN (SELECT projmateng_mateng FROM projmateng WHERE projmateng_project = $proj_id);";
                                                        $resultmateng = mysqli_query($conn, $sqlmateng);
                                                        while($rowmateng = mysqli_fetch_row($resultmateng)){
                                                    ?>
                                                    <div class="input-group mb-2 col-md-12">

                                                        <div class="input-group-prepend col-md-12 options">

                                                            <div class="input-group-text">

                                                                <input type="checkbox" name="mateng[]" aria-label="Checkbox for following text input" value="<?php echo $rowmateng[1]; ?>">
                                                            </div>

                                                            <input type="text" class="form-control" aria-label="Text input with checkbox" value="<?php echo $rowmateng[0]; ?>" disabled>
                                                        </div>
                                                    </div>
                                                    <?php
                                                                }
                                                            ?>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="submit" name="edit_project" class="btn btn-success" value="Save">
                                                    <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                                <!-- End of Edit Modal -->
                                <!-- Start of Close Modal -->
                                <div class="modal fade" id="close-proj-modal-<?php echo $row[4];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form action="../server.php" method="POST">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Are you sure you
                                                        want
                                                        to close
                                                        <?php echo $row[0];?> project?</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        &times;
                                                    </button>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" name="projects_id" value="<?php echo $row[4];?>">
                                                    <button type="submit" class="btn btn-success" name="close_project">Yes</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of Close Modal -->

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
                                    <th scope="col">Materials Engineer Involved</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                    $sql = "SELECT
                                        projects_name,
                                        projects_address,
                                        projects_sdate,
                                        projects_edate,
                                        projects_id
                                    FROM
                                        projects
                                    WHERE
                                        projects_status = 'closed';";
                                        $result = mysqli_query($conn, $sql);
                                        while ($row = mysqli_fetch_row($result)) {
                                    ?>

                                <tr>
                                    <td>
                                        <?php echo $row[0] ;?>
                                    </td>
                                    <td>
                                        <?php echo $row[1] ;?>
                                    </td>
                                    <td>
                                        <?php echo $row[2] ;?>
                                    </td>
                                    <td>
                                        <?php echo $row[3] ;?>
                                    </td>
                                    <td>
                                        <?php
                                    $wew = $row[4];        
                                    $sql1 = "SELECT CONCAT (accounts.accounts_fname, ' ', accounts.accounts_lname) FROM projmateng INNER JOIN accounts ON projmateng.projmateng_mateng = accounts.accounts_id WHERE projmateng_project = $wew AND accounts.accounts_status = 'active';";
                                        $result1 = mysqli_query($conn, $sql1);
                                        while ($row1 = mysqli_fetch_row($result1)) {
                                    ?>
                                        <p>
                                            <?php echo $row1[0]; ?>
                                        </p>
                                        <?php
                                        }
                                ?>
                                    </td>
                                    <td><input type="hidden" name="projectName" value="<?php echo $row1[0];?>">
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#reopen-proj-modal-<?php echo $row[4]?>">Re-Open</button>
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete-proj-modal-<?php echo $row[4]?>">Delete
                                            Project</button>
                                    </td>
                                </tr>



                                <!-- Start of Reopen Modal -->
                                <div class="modal fade" id="reopen-proj-modal-<?php echo $row[4];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form action="../server.php" method="POST">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Are you sure you want
                                                        to reopen
                                                        <?php echo $row1[0] ;?> project?</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        &times;
                                                    </button>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" name="projects_id" value="<?php echo $row[4];?>">
                                                    <button type="submit" class="btn btn-success" name="reopen_project">Yes</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>

                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of Reopen Modal -->

                                <!-- Start of Delete Modal -->
                                <div class="modal fade" id="delete-proj-modal-<?php echo $row[4];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Are you sure you want
                                                    to delete
                                                    <?php echo $row1[0];?> project?</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    &times;
                                                </button>
                                            </div>
                                            <form action="../server.php" method="POST">
                                                <div class="modal-footer">
                                                    <input type="hidden" name="projectName" value="<?php echo $row[0]; ?>" />
                                                    <input type="hidden" name="projects_id" value="<?php echo $row[4]?>" />
                                                    <button type="submit" class="btn btn-success" name="delete_project">Yes</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>

                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of Delete Modal -->
                                <?php
                                        }
                                    ?>
                            </tbody>
                        </table>
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

    $(document).ready(function() {
        $('#mydatatable').DataTable();
        $('table.display').DataTable();
        $('#sidebarCollapse').on('click', function() {
            $('#sidebar').toggleClass('active');
        });

    });

</script>

</html>
