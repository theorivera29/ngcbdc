<?php
    include "../session.php";
    if (isset($_SESSION['hauling_no'])) {
        $hauling_no = $_SESSION['hauling_no'];
    } else {
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/hauleditems.php");  
    }
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
    <script src="../js/jquery/jquery-3.4.1.min.js"></script>
    <script src="../js/popper/popper.min.js"></script>
    <script src="../bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
</head>

<body>
    <div id="content">
        <span class="slide">
            <a href="#" class="open" onclick="window.location.href='hauleditems.php'">
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

    <button class="btn btn-warning generate-hauling-btn" type="button" onclick="window.location.href = 'generate_hauling.php'">Generate Hauling
        Receipt</button>
    <div class="mx-auto">
        <div class="card view-hauling-receipt-container">
            <div class="card-header">
                <div class="row col-lg-12">
                    <div class="col-lg-8">
                        <h4>Hauling Receipt</h4>
                    </div>
                </div>
            </div>
            <?php
        $sql = "SELECT 
                    hauling.hauling_no, 
                    hauling.hauling_date, 
                    hauling.hauling_deliverTo, 
                    hauling.hauling_hauledFrom, 
                    hauling.hauling_requestedBy, 
                    hauling.hauling_hauledBy, 
                    hauling.hauling_warehouseman, 
                    hauling.hauling_approvedBy, 
                    hauling.hauling_truckDetailsType, 
                    hauling.hauling_truckDetailsPLateNo, 
                    hauling.hauling_truckDetailsPO, 
                    hauling.hauling_truckDetailsHaulerDR 
                FROM 
                    hauling
                WHERE 
                    hauling.hauling_no = $hauling_no;";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_row($result)){
    ?>
            <div class="card-body">
                <form class="form">
                    <div class="form-group row formnum-container">
                        <div class=" col-lg-12">
                            <label class="col-lg-12 col-form-label">Form No.:</label>
                            <div class="col-lg-12">
                                <input class="form-control" type="text" value="<?php echo $row[0]?>" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row date-container">
                        <div class="col-lg-12">
                            <label class="col-lg-12 col-form-label">Date:</label>
                            <div class="col-lg-12">
                                <input class="form-control" type="date" value="<?php echo $row[1]?>" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <label class="col-lg-2 col-form-label">Deliver to:</label>
                        <div class="col-lg-10">
                            <input class="form-control" type="text" value="<?php echo $row[2]?>" disabled>
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <label class="col-lg-2 col-form-label">Hauled from:</label>
                        <div class="col-lg-10">
                            <input class="form-control" type="text" value="<?php echo $row[3]?>" disabled>
                        </div>
                    </div>
                    <div class="card">
                        <table class="table hauling-form-table">
                            <thead>
                                <tr>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Unit</th>
                                    <th scope="col">Articles</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql_item = "SELECT
                                                    haulingmat.haulingmat_qty,
                                                    unit.unit_name,
                                                    materials.mat_name
                                                FROM
                                                    haulingmat
                                                INNER JOIN
                                                    hauling ON hauling.hauling_id = haulingmat_haulingid
                                                INNER JOIN 
                                                    unit ON unit.unit_id = haulingmat.haulingmat_unit
                                                INNER JOIN 
                                                    materials ON materials.mat_id = haulingmat.haulingmat_matname
                                                WHERE
                                                    hauling.hauling_no = $hauling_no;";
                                    $result_item = mysqli_query($conn, $sql_item);
                                    while($row_item = mysqli_fetch_array($result_item)) {
                                ?>
                                <tr>
                                    <td><?php echo $row_item[0] ;?></td>
                                    <td><?php echo $row_item[1] ;?></td>
                                    <td><?php echo $row_item[2] ;?></td>
                                </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group row col-lg-12">
                        <div class="form-group col-lg-6">
                            <label class="col-lg-12 col-form-label">Requested:</label>
                            <div class="col-lg-12">
                                <input class="form-control" type="text" value="<?php echo $row[4]?>" disabled>
                            </div>
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="col-lg-12 col-form-label">Hauled by:</label>
                            <div class="col-lg-12">
                                <input class="form-control" type="text" value="<?php echo $row[5]?>" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <div class="form-group col-lg-6">
                            <label class="col-lg-12 col-form-label">Warehouseman:</label>
                            <div class="col-lg-12">
                                <input class="form-control" type="text" value="<?php echo $row[6]?>" disabled>
                            </div>
                            <label class="col-lg-12 col-form-label">Approved by:</label>
                            <div class="col-lg-12">
                                <input class="form-control" type="text" value="<?php echo $row[7]?>" disabled>
                            </div>
                        </div>

                        <div class="form-group row col-lg-6">
                            <div class="card hauling-form-card">
                                <div class="card-header">
                                    <h5>TRUCK DETAILS</h5>
                                </div>
                                <div class="card-body form-group row col-lg-12">
                                    <label class="col-lg-4 col-form-label">Type:</label>
                                    <div class="col-lg-8 form-group">
                                        <input class="form-control" type="text" value="<?php echo $row[8]?>" disabled>
                                    </div>
                                    <label class="col-lg-4 form-group col-form-label">Plate #:</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="text" value="<?php echo $row[9]?>" disabled>
                                    </div>
                                    <label class="col-lg-4 form-group col-form-label">P.O./R.S. #:</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="text" value="<?php echo $row[10]?>" disabled>
                                    </div>
                                    <label class="col-lg-4 form-group col-form-label">Hauler ID:</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="text" value="<?php echo $row[11]?>" disabled>
                                    </div>
                                </div>
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