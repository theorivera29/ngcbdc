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
    <div class="mx-auto col-md-10">
        <div class="card">
            <div class="card-header">
                <div class="row col-lg-12">
                    <div class="col-lg-8">
                        <h4>Return Hauled Materials</h4>
                    </div>
                </div>
            </div>
        <?php
        $sql = "SELECT 
                    hauling.hauling_date, 
                    hauling.hauling_no, 
                    hauling.hauling_hauledBy, 
                    hauling.hauling_hauledFrom, 
                    hauling.hauling_quantity, 
                    hauling.hauling_unit, 
                    hauling.hauling_matname, 
                    returns.return_returnedqty, 
                    returns.return_date, 
                    returns.return_returningqty, 
                    hauling.hauling_status 
                FROM 
                    hauling 
                INNER JOIN 
                    returns ON hauling.hauling_id = returns.return_id 
                WHERE 
                    hauling.hauling_no=1;";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_row($result)){
    ?>
            <div class="card-body">
                <form class="form needs-validation" action="../server.php" method="POST" novalidate>
                    <div class="form-group row formnum-container">
                        <div class=" col-lg-12">
                            <label class="col-lg-12 col-form-label">Form No.:</label>
                            <div class="col-lg-12">
                                <input class="form-control" type="text" value="<?php echo $row[1]?>" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row date-container">
                        <div class="col-lg-12">
                            <label class="col-lg-12 col-form-label">Hauling Date:</label>
                            <div class="col-lg-12">
                                <input class="form-control" type="date" value="<?php echo $row[0]?>" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <label class="col-lg-2 col-form-label">Hauled by:</label>
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
                        <table class="table table-hover">
                            <thead>
                                <tr>
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
                                <tr data-toggle="collapse" data-target="#accordion" class="clickable">
                                    <td><?php echo $row[4]?></td>
                                    <td><?php echo $row[5]?></td>
                                    <td><?php echo $row[6]?></td>
                                    <td><?php echo $row[7]?></td>
                                    <td><?php echo $row[8]?></td>
                                    <td><?php echo $row[4] - $row[7]?></td>
                                    <td><?php echo $row[10]?></td>
                                    <td> <input class="form-control" name="returningQuantity" type="text"
                                            id="returningQuantity" placeholder="Returning Quantity"></td>
                                    <td> <input type="submit" name="return_hauling"
                                            class="btn btn-md btn-outline-secondary save-row" value="Save" /></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td id="accordion" class="collapse">
                                        <!-- returning qty -->
                                    </td>
                                    <td id="accordion" class="collapse">
                                        <!-- date returned -->
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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