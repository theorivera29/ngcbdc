<?php
    include "../db_connection.php";
    session_start();

    $accounts_id = $_SESSION['account_id'];    
?>

<!DOCTYPE html>

<html>

<head>
    <title>NGCBDC</title>
    <link rel="icon" type="image/png" href="Images/NGCB_logo.png">
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" href="../bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="../bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>

</head>

<body>
    <section id="tabs">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 project-tabs">
                    <nav>
                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                                role="tab" aria-controls="nav-home" aria-selected="true">ONGOING</a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                                role="tab" aria-controls="nav-profile" aria-selected="false">CLOSED</a>
                        </div>
                    </nav>
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
                                    <button type="button" class="btn btn-info" id="view-inventory-btn"
                                        type="button"  onclick="window.location.href = 'viewInventory.php'">View inventory</button>
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

</html>