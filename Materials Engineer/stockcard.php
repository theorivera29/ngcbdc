<?php
    include "../session.php";

    if (isset($_SESSION['matinfo_id'])) {
        $matinfo_id = $_SESSION['matinfo_id'];
    } else {
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/viewinventory.php");  
    }
    $projects_id = $_SESSION['projects_id'];
    $sql_name = "SELECT 
                    materials.mat_name
                FROM
                    materials
                INNER JOIN
                    matinfo ON materials.mat_id = matinfo.matinfo_matname
                WHERE
                    matinfo.matinfo_id = $matinfo_id;";
    $result_name = mysqli_query($conn, $sql_name);
    $row_name = mysqli_fetch_row($result_name);
    $mat_name = $row_name[0];
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
            <a href="#" class="open" name="" onclick="window.location.href='viewInventory.php'">
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

    <section id="tabs">
        <div class="container">
            <div class="row">
            <h4 class="project-title"><?php echo strtoupper($mat_name) ;?></h4>
                <div class="col-xs-12 project-tabs">
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                            role="tab" aria-controls="nav-home" aria-selected="true">DELIVERED IN</a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                            role="tab" aria-controls="nav-profile" aria-selected="false">USAGE IN</a>
                    </div>
                    <!-- <button class="btn btn-warning" id="generate-stockcard" type="button">Generate Stockcard</button> -->
                </div>
                <div class="stockcard-tabs-content">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                            aria-labelledby="nav-home-tab">
                            <div class="delivered-in-container">
                                <table
                                    class="table stockcard-table table-striped table-bordered delivered-in-table display"
                                    id="mydatatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Date</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Unit</th>
                                            <th scope="col">Supplied By</th>
                                            <th scope="col">Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $sql_mat = "SELECT
                                                            unit.unit_name
                                                        FROM
                                                            materials
                                                        INNER JOIN
                                                            unit ON unit.unit_id = materials.mat_unit
                                                        INNER JOIN
                                                            matinfo ON matinfo.matinfo_matname = materials.mat_id
                                                        WHERE
                                                            matinfo.matinfo_id = $matinfo_id;";
                                            $result_mat = mysqli_query($conn, $sql_mat);
                                            $mat_count_del = 0;
                                            while ($row_mat = mysqli_fetch_row($result_mat)) {
                                                $sql_del = "SELECT
                                                                deliveredin.deliveredin_date,
                                                                deliveredmat.deliveredmat_qty,
                                                                deliveredmat.suppliedBy,
                                                                deliveredin.deliveredin_remarks,
                                                                deliveredin.deliveredin_receiptno
                                                            FROM
                                                                deliveredmat
                                                            INNER JOIN
                                                                deliveredin ON deliveredin.deliveredin_id = deliveredmat.deliveredmat_deliveredin
                                                            INNER JOIN
                                                                matinfo ON deliveredmat.deliveredmat_materials = matinfo.matinfo_matname
                                                            WHERE
                                                                matinfo.matinfo_id = $matinfo_id
                                                                AND
                                                                    deliveredin.deliveredin_project = $projects_id;";
                                                $result_del = mysqli_query($conn, $sql_del);
                                                while ($row_del = mysqli_fetch_row($result_del)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $row_del[0] ;?></td>
                                            <td><?php echo $row_del[1] ;?></td>
                                            <td><?php echo $row_mat[0] ;?></td>
                                            <td><?php echo $row_del[2] ;?></td>
                                            <td><?php echo $row_del[3] ;?></td>
                                        </tr>
                                        <?php
                                            $mat_count_del = $mat_count_del + $row_del[1];
                                                }
                                            }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3">Running Total (in):</td>
                                            <td colspan="2"><?php echo $mat_count_del ;?></td>
                                        </tr>
                                    </tfoot>
                                </table>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <div class="usage-in-container">
                                <table class="table stockcard-table table-striped table-bordered display"
                                    id="mydatatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Date</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Unit</th>
                                            <th scope="col">Pulled By</th>
                                            <th scope="col">Area of Usage</th>
                                            <th scope="col">Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php   
                                        $sql_mat = "SELECT
                                                        unit.unit_name,
                                                        materials.mat_id
                                                    FROM
                                                        materials
                                                    INNER JOIN
                                                        unit ON unit.unit_id = materials.mat_unit
                                                    INNER JOIN
                                                        matinfo ON matinfo.matinfo_matname = materials.mat_id
                                                    WHERE
                                                        matinfo.matinfo_id = $matinfo_id;";
                                        $result_mat = mysqli_query($conn, $sql_mat);
                                        $mat_count_use = 0;
                                        while ($row_mat = mysqli_fetch_row($result_mat)) {
                                            $sql_use = "SELECT
                                                            requisition.requisition_date,
                                                            reqmaterial.reqmaterial_qty,
                                                            requisition.requisition_reqBy,
                                                            reqmaterial.reqmaterial_areaOfUsage,
                                                            requisition.requisition_remarks
                                                        FROM
                                                            requisition
                                                        INNER JOIN
                                                            reqmaterial ON reqmaterial.reqmaterial_requisition = requisition.requisition_id
                                                        WHERE
                                                            reqmaterial.reqmaterial_material = $row_mat[1];";
                                            $result_use = mysqli_query($conn, $sql_use);
                                            while ($row_use = mysqli_fetch_row($result_use)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $row_use[0] ;?></td>
                                            <td><?php echo $row_use[1] ;?></td>
                                            <td><?php echo $row_mat[0] ;?></td>
                                            <td><?php echo $row_use[2] ;?></td>
                                            <td><?php echo $row_use[3] ;?></td>
                                            <td><?php echo $row_use[4] ;?></td>
                                        </tr>
                                        <?php
                                            $mat_count_use = $mat_count_use + $row_use[1];
                                                }
                                            $sql_use = "SELECT
                                                            hauling.hauling_date,
                                                            haulingmat.haulingmat_qty,
                                                            hauling.hauling_requestedBy,
                                                            hauling.hauling_deliverTo,
                                                            hauling.hauling_status
                                                        FROM
                                                            hauling
                                                        INNER JOIN
                                                            haulingmat ON hauling.hauling_id = haulingmat.haulingmat_haulingid
                                                        WHERE
                                                            haulingmat.haulingmat_matname = $row_mat[1];";
                                            $result_use = mysqli_query($conn, $sql_use);
                                            while ($row_use = mysqli_fetch_row($result_use)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $row_use[0] ;?></td>
                                            <td><?php echo $row_use[1] ;?></td>
                                            <td><?php echo $row_mat[0] ;?></td>
                                            <td><?php echo $row_use[2] ;?></td>
                                            <td><?php echo $row_use[3] ;?></td>
                                            <td><?php echo $row_use[4] ;?></td>
                                        </tr>
                                        <?php
                                            $mat_count_use = $mat_count_use + $row_use[1];
                                                }
                                            }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4">Running Total (out):</td>
                                            <td colspan="2"><?php echo $mat_count_use ;?></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
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
        $('table.display').DataTable();

        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });

    });
</script>

</html>