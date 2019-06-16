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
    <script src="../js/jquery/jquery-3.4.1.min.js"></script>
    <script src="../js/popper/popper.min.js"></script>
    <script src="../bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
    
</head>

<body>
    <div id="content">
        <span class="slide">
            <a href="#" class="open" onclick="window.location.href='returns.php'">
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
    <div class="mx-auto col-md-11">
        <div class="card">
            <div class="card-header">
                <div class="row col-lg-12">
                    <div class="col-lg-8">
                        <h4>Return Hauled Materials</h4>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?php
                    $hauling_no = $_SESSION['hauling_no'];
                    $sql_hauling = "SELECT
                                hauling_date,
                                hauling_hauledBy,
                                hauling_hauledFrom
                            FROM 
                                hauling
                            WHERE
                                hauling_no = $hauling_no;";
                    $result_hauling = mysqli_query($conn, $sql_hauling);
                    $row_hauling = mysqli_fetch_row($result_hauling);
                ?>
                <div class="form-group row formnum-container">
                    <div class=" col-lg-12">
                        <label class="col-lg-12 col-form-label">Form No.:</label>
                        <div class="col-lg-12">
                            <input class="form-control" type="text" value="<?php echo $hauling_no ;?>" disabled>
                        </div>
                    </div>
                </div>
                <div class="form-group row date-container">
                    <div class="col-lg-12">
                        <label class="col-lg-12 col-form-label">Hauling Date:</label>
                        <div class="col-lg-12">
                            <input class="form-control" type="date" value="<?php echo $row_hauling[0] ;?>" disabled>
                        </div>
                    </div>
                </div>
                <div class="form-group row col-lg-12">
                    <label class="col-lg-2 col-form-label">Hauled by:</label>
                    <div class="col-lg-10">
                        <input class="form-control" type="text" value="<?php echo $row_hauling[1] ;?>" disabled>
                    </div>
                </div>
                <div class="form-group row col-lg-12">
                    <label class="col-lg-2 col-form-label">Hauled from:</label>
                    <div class="col-lg-10">
                        <input class="form-control" type="text" value="<?php echo $row_hauling[2] ;?>" disabled>
                    </div>
                </div>
                <div class="card">
                    <table class="table returns-table table-hover table-bordered display">
                        <thead>
                            <tr>
                                <th></th>
                                <th scope="col">Total Quantity</th>
                                <th scope="col">Unit</th>
                                <th scope="col">Articles</th>
                                <th scope="col">Returned Quantity</th>
                                <th scope="col">Returned Date</th>
                                <th scope="col">Remaining Quantity</th>
                                <th scope="col">Status</th>
                                <th scope="col">Returning Quantity</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                    $sql = "SELECT 
                                                haulingmat.haulingmat_qty, 
                                                unit.unit_name,
                                                materials.mat_name,
                                                materials.mat_id 
                                            FROM 
                                                materials
                                            INNER JOIN 
                                                haulingmat ON haulingmat.haulingmat_matname = materials.mat_id
                                            INNER JOIN 
                                                unit ON materials.mat_unit = unit.unit_id
                                            INNER JOIN 
                                                hauling ON haulingmat.haulingmat_haulingid = hauling.hauling_id
                                            WHERE 
                                                hauling.hauling_no = $hauling_no;";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_row($result)) {
                                        $ctr = $row[0];
                                        $sql_sum = "SELECT
                                                        SUM(returnhistory.returnhistory_returningqty)
                                                    FROM
                                                        returns
                                                    INNER JOIN
                                                        returnhistory ON returns.returns_id = returnhistory.returns_id
                                                    WHERE
                                                        returns.returns_matname = $row[3];";
                                        $result_sum = mysqli_query($conn, $sql_sum);
                                        $row_sum = mysqli_fetch_row($result_sum);
                                        $sum = $row_sum[0];
                                        $stmt = $conn->prepare("SELECT returns_status, returns_id FROM returns WHERE returns_matname = ?;");
                                        $stmt->bind_param("i", $row[3]);
                                        $stmt->execute();
                                        $stmt->store_result();
                                        $stmt->bind_result($status, $returns_id);
                                        $stmt->fetch();
                                ?>
                            <tr data-toggle="collapse" data-target="#accordion-<?php echo $row[3] ;?>"
                                class="clickable">
                                <form class="form needs-validation" action="../server.php" method="POST" novalidate>
                                    <td><i class="fa fa-plus green" aria-hidden="true"></</td> <td><?php echo $row[0] ;?></td>
                                    <td><?php echo $row[1] ;?></td>
                                    <td><?php echo $row[2] ;?></td>
                                    <td>
                                        <?php 
                                            if ($sum == null ) {
                                                echo 0;
                                            } else {
                                                echo $sum;
                                            }
                                        ?>
                                    </td>
                                    <td>-</td>
                                    <td>
                                        <?php   
                                            echo $row[0]-$sum;
                                        ?>
                                    </td>
                                    <td><?php echo $status ;?></td>
                                    <?php
                                        if (strcmp($status, "Incomplete") == 0) {
                                    ?>
                                    <td>
                                        <input class="form-control" name="returningQuantity" type="text"
                                            id="returningQuantity" placeholder="Returning Quantity" autocomplete="off">
                                    </td>
                                    <td>
                                        <input type="hidden" name="returns_id" value="<?php echo $returns_id ;?>">
                                        <input type="submit" name="return_hauling"
                                            class="btn btn-md btn-outline-secondary save-row">
                                    </td>
                                    <?php
                                        } else {
                                            ?>
                                    <td>
                                    </td>
                                    <td>
                                    </td>
                                            <?php
                                        }
                                    ?>
                                </form>
                            </tr>
                            <?php
                                        $sql_ret = "SELECT
                                                        returnhistory.returnhistory_returningqty,
                                                        returnhistory.returnhistory_date
                                                    FROM
                                                        returns
                                                    INNER JOIN
                                                        returnhistory ON returns.returns_id = returnhistory.returns_id
                                                    WHERE
                                                        returns.returns_matname = $row[3];";
                                        $result_ret = mysqli_query($conn, $sql_ret);
                                        while ($row_ret = mysqli_fetch_row($result_ret)) {                                                 
                                        $ctr = $ctr - $row_ret[0];  
                                ?>
                            <tr class="hiddenrow">
                                <td colspan="4" id="accordion-<?php echo $row[3] ;?>" class="collapse"></td>
                                <td id="accordion-<?php echo $row[3] ;?>" class="collapse">
                                    <?php echo $row_ret[0];?>
                                </td>
                                <td id="accordion-<?php echo $row[3] ;?>" class="collapse">
                                    <?php echo $row_ret[1];?>
                                </td>
                                <td id="accordion-<?php echo $row[3] ;?>" class="collapse">
                                    <?php echo $ctr;?>
                                </td>
                                <td colspan="3" id="accordion-<?php echo $row[3] ;?>" class="collapse"></td>
                            </tr>
                            <?php                                   
                                        }
                                    }
                                ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php
            
        ?>
        </div>
    </div>
</body>
<script type="text/javascript">
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