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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <script src="../js/jquery/jquery-3.4.1.min.js"></script>
    <script src="../js/popper/popper.min.js"></script>
    <script src="../bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js">
    </script>
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
                                    WHERE
                                        projects.projects_status = 'open';";
                            $result = mysqli_query($conn, $sql);
                            ?>
                        <form action="../server.php" method="POST">
                            <?php
                            while ($row = mysqli_fetch_row($result)) {
                        ?>
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <div class="card project-container">
                                    <h5 class="card-header card-header-project">
                                        <?php echo $row[0] ;?>
                                    </h5>
                                    <div class="card-body">
                                        <span>
                                            <h5>
                                                <?php echo $row[1] ;?>
                                            </h5>
                                        </span>
                                        <span>
                                            <h5>Start Date:
                                                <?php echo $row[2] ;?>
                                            </h5>
                                        </span>
                                        <span>
                                            <h5>End Date:
                                                <?php echo $row[3] ;?>
                                            </h5>
                                        </span>
                                        <input type="hidden" name="project_id" value="<?php echo $row[4];?>">
                                        <button type="button" class="btn btn-success" name="" data-toggle="modal" data-target="#edit-project-modal">Edit</button>
                                        <button type="submit" class="btn btn-danger" name="" data-toggle="modal" data-target="#close-project-modal">Close Project</button>
                                    </div>
                                </div>
                            </div>
                            <?php
                            }
                        ?>
                        </form>
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
                            $result1 = mysqli_query($conn, $sql);
                        ?>
                        <form action="../server.php" method="POST">
                            <?php
                            while ($row1 = mysqli_fetch_row($result1)) {
                        ?>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <div class="card project-container">
                                    <h5 class="card-header card-header-project">
                                        <?php echo $row1[0] ;?>
                                    </h5>
                                    <div class="card-body">
                                        <span>
                                            <h5>
                                                <?php echo $row1[1] ;?>
                                            </h5>
                                        </span>
                                        <span>
                                            <h5>Start Date:
                                                <?php echo $row1[2] ;?>
                                            </h5>
                                        </span>
                                        <span>
                                            <h5>End Date:
                                                <?php echo $row1[3] ;?>
                                            </h5>
                                        </span>
                                        <input type="hidden" name="project_id" value="<?php echo $row[4];?>">
                                        <button type="submit" class="btn btn-info" id="view-inventory-btn" name="viewInventory">View inventory</button>
                                    </div>
                                </div>
                            </div>
                            <?php
                            }   
                        ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="close-project-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <h4>Are you sure you want to close this project?</h4>
                    </button>
                </div>
                <div class="modal-body">
                    NAME NG PROJECT
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success">Yes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-project-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <?php
        $sql = "SELECT projects_name, projects_address, projects_sdate, projects_edate FROM projects WHERE projects_id = 1;";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_row($result)){
    ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <h4>
                            <?php echo $row[0]?>
                        </h4>
                    </button>
                </div>
                <form action="../server.php" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="projectName" class="label-styles">Project Name</label>
                            <input type="text" class="form-control" value="<?php echo $row[0]?>" name="newProjectName" placeholder="Enter new project name" required>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="label-styles">Address:</label>
                            <input type="text" class="form-control" value="<?php echo $row[1]?>" name="newAddress" placeholder="Enter new project address" required>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                        <div class="form-group">
                            <label for="startDate" class="label-styles">Start Date:</label>
                            <input type="date" value="<?php echo $row[2]?>" name="newStartDate" class="form-control" required>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                        <div class="form-group">
                            <label for="endDate" class="label-styles">End Date:</label>
                            <input type="date" value="<?php echo $row[3]?>" name="newEndDate" class="form-control" required>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                        <?php
        }   
    ?>
                        <div class="input-group mb-3">
                                <?php
                                    $sqlmateng = "SELECT 
                                    CONCAT(accounts_fname, accounts_lname), accounts_id FROM accounts;";
                                    $resultmateng = mysqli_query($conn, $sqlmateng);
                                    while($rowmateng = mysqli_fetch_row($resultmateng)){
                                ?>
                                <div>
                                <input type="checkbox" name="mateng[]" value="<?php echo $rowmateng[1]?>"/>    
                                <span><?php echo $rowmateng[0]?> </span> 
                                </div>
                                <?php
                                    }
                                ?>
                        <div>
                            <label class="label-styles">Materials Engineer Involved</label>
                            <select id="multiselect" multiple="multiple">
                                <option>JAM SPICA ROCAFORT</option>
                                <option>JAM SPICA ROCAFORT</option>
                                <option>CARYL MARIE</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="edit_project" class="btn btn-success" value="Save">
                        <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                    </div>
                </form>
            </div>
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

    $(document).ready(function() {

        $('#sidebarCollapse').on('click', function() {
            $('#sidebar').toggleClass('active');
        });

    });

    $(document).ready(function() {
        $('#multiselect').multiselect({
            buttonWidth: '100%',
            includeSelectAllOption: true,
            nonSelectedText: 'Select an Option'
        });
    });

</script>

</html>
