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
                        <a href="projects.php" id="sideNav-a">Projects</a>
                    </li>
                    <li>
                        <a href="hauleditems.php" id="sideNav-a">Hauled Materials</a>
                    </li>
                    <li>
                        <a href="sitematerials.php" id="sideNav-a">Site Materials</a>
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
                </div>
                <div class="project-tabs-content">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <div class="card project-container">
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
                                <form action="../server.php" method="POST">
                                    <div>
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
                                            <input type="hidden" name="projects_id" value="<?php echo $row[4];?>">
                                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#edit-project-modal-<?php echo $row[4]?>">Edit</button>
                                            <button type="submit" name="close_project">Close Project</button>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="edit-project-modal-<?php echo $row[4]?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <?php
                                                $sqledit = "SELECT projects_name, projects_address, projects_sdate, projects_edate FROM projects WHERE projects_id = $row[4];";
                                                $resultedit = mysqli_query($conn, $sqledit);
                                                while($rowedit = mysqli_fetch_row($resultedit)){
                                            ?>
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <h4>
                                                            <?php echo $rowedit[0]?>
                                                        </h4>
                                                    </button>
                                                </div>
                                                <form action="../server.php" method="POST">
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="projectName" class="label-styles">Project Name</label>
                                                            <input type="text" class="form-control" value="<?php echo $rowedit[0]?>" name="newProjectName" placeholder="Enter new project name" required>
                                                            <div class="invalid-feedback">Please fill out this field.</div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="address" class="label-styles">Address:</label>
                                                            <input type="text" class="form-control" value="<?php echo $rowedit[1]?>" name="newAddress" placeholder="Enter new project address" required>
                                                            <div class="invalid-feedback">Please fill out this field.</div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="startDate" class="label-styles">Start Date:</label>
                                                            <input type="date" value="<?php echo $rowedit[2]?>" name="newStartDate" class="form-control" required>
                                                            <div class="invalid-feedback">Please fill out this field.</div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="endDate" class="label-styles">End Date:</label>
                                                            <input type="date" value="<?php echo $rowedit[3]?>" name="newEndDate" class="form-control" required>
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
                                                                <input type="checkbox" name="mateng[]" value="<?php echo $rowmateng[1]?>" />
                                                                <span>
                                                                    <?php echo $rowmateng[0]?> </span>
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
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <?php
                                        }
                                    ?>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <div class="card project-container">
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
                                        $result1 = mysqli_query($conn, $sql);
                                        while ($row1 = mysqli_fetch_row($result1)) {
                                    ?>
                                <form action="../server.php" method="POST">
                                    <h5 class="card-header card-header-project">
                                        <?php echo $row1[0] ;?>
                                    </h5>
                                    <div class="card-body">
                                        <input type="hidden" name="projects_id" value="<?php echo $row1[4];?>">
                                        <button type="submit" name="reopen_project">Re-Open Project</button>
                                        <button type="submit" name="delete_project">Delete Project</button>
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
                                                <?php echo $row1[4];?>
                                            </h5>
                                        </span>
                                    </div>
                                </form>
                                <?php
                                        }   
                                    ?>
                            </div>
                        </div>
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

        $('#sidebarCollapse').on('click', function() {
            $('#sidebar').toggleClass('active');
        });

    });

</script>

</html>
