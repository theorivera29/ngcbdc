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
    <script src="../js/jquery/jquery-3.4.1.min.js"></script>
    <script src="../js/popper/popper.min.js"></script>
    <script src="../bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
</head>

<body>
    <div id="content">
        <span class="slide">
            <a href="#" class="open" onclick="window.location.href='viewTransactions.php'">
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
    <div class="mx-auto mt-5 col-md-10">
        <div class="card">
            <div class="card-header">
                <h4>Material Requisition Slip</h4>
            </div>
            <?php
                $req_no= $_GET['requisition_no'];
                $sql = "SELECT 
                requisition.requisition_no, 
                requisition.requisition_date, 
                projects.projects_name, 
                projects.projects_address,
                requisition.requisition_remarks, 
                requisition.requisition_reqBy, 
                requisition.requisition_approvedBy 
                FROM requisition 
                INNER JOIN projects 
                ON requisition.requisition_project = projects.projects_id 
                WHERE requisition.requisition_no = $req_no;";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_row($result)) {
            ?>
            <div class="card-body">
                <form action="../server.php" method="POST">
                    <div class="form-group row date-container">
                        <div class="col-lg-12">
                            <label class="col-lg-12 col-form-label">Date:</label>
                            <div class="col-lg-12">
                                <input class="form-control" type="date" value="<?php echo $row[1]; ?>" readonly/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row formnum-container">
                        <div class="col-lg-12">
                            <label class="col-lg-12 col-form-label">Material Requisition No.:</label>
                            <div class="col-lg-12">
                                <input class="form-control" type="text" value="<?php echo $row[0]; ?>" readonly/>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row col-lg-12">
                        <label class="col-lg-2 col-form-label">Project:</label>
                        <div class="col-lg-9">
                            <input class="form-control" type="text" value="<?php echo $row[2]; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <label class="col-lg-2 col-form-label">Location:</label>
                        <div class="col-lg-9">
                            <input class="form-control" type="text" value="<?php echo $row[3]; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <label class="col-lg-2 col-form-label">Remarks:</label>
                        <div class="col-lg-9">
                            <input class="form-control" type="text" value="<?php echo $row[4]; ?>" readonly>
                        </div>
                    </div>
                    <div class="card">
                        <table class="table requisition-form-table">
                            <thead>
                                <tr>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Particulars</th>
                                    <th scope="col">Unit</th>
                                    <th scope="col">Location</th>
                                </tr>
                            </thead>
                            <tbody id="requisitionTable">
                            </tbody>
                            <?php    
                                $req_id = $_GET['requisition_id'];
                                $sql1 = "SELECT 
                                reqmaterial.reqmaterial_qty, 
                                materials.mat_name, 
                                unit.unit_name, 
                                reqmaterial.reqmaterial_areaOfUsage 
                                FROM reqmaterial
                                INNER JOIN materials 
                                ON reqmaterial.reqmaterial_material = materials.mat_id 
                                INNER JOIN unit 
                                ON materials.mat_unit = unit.unit_id
                                WHERE reqmaterial.reqmaterial_requisition = $req_id;";
                                $result1 = mysqli_query($conn, $sql1);
                                while ($row1 = mysqli_fetch_row($result1)) {
                            ?>
                            <tfoot>
                                <tr id="requisitionRow">
                                    <td>
                                        <input class="form-control" value="<?php echo $row1[0]; ?>" type="text" readonly>
                                    </td>
                                    <td>
                                        <input class="form-control" value="<?php echo $row1[1]; ?>" type="text" readonly>
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" value="<?php echo $row1[2]; ?>" readonly>
                                    </td>
                                    <td>
                                        <input class="form-control"  type="text" value="<?php echo $row1[3]; ?>" readonly>
                                    </td>
                                </tr>
                            </tfoot>
                            <?php
                                }
                            ?>
                        </table>
                    </div>
                    <div class="form-group row col-lg-12">
                        <div class="form-group col-lg-6">
                            <label class="col-lg-12 col-form-label">Requested by:</label>
                            <div class="col-lg-12">
                                <input class="form-control" type="text" value="<?php echo $row[5]; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="col-lg-12 col-form-label">Approved by:</label>
                            <div class="col-lg-12">
                                <input class="form-control" type="text" value="<?php echo $row[6]; ?>" readonly>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <?php
                }
            ?>
        </div>
    </div>
</body>
<script type="text/javascript">
    $(document).ready(function() {
        $('#sidebarCollapse').on('click', function() {
            $('#sidebar').toggleClass('active');
        });
    });

    function openSlideMenu() {
        document.getElementById('menu').style.width = '15%';
    }

    function closeSlideMenu() {
        document.getElementById('menu').style.width = '0';
        document.getElementById('content').style.marginLeft = '0';
    }

</script>


</html>
