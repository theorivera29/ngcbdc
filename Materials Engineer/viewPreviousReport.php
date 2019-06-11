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
            <a href="#" class="open" onclick="window.location.href='previousReportsPage.php'">
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
    <button class="btn btn-warning" id="generate-report" type="button">Generate Report</button>
    <table class="table reportpage-table table-striped table-bordered">
        <thead>
            <tr>
                <th class="align-middle">Particulars</th>
                <th class="align-middle">Previous Material Stock</th>
                <th class="align-middle">Unit</th>
                <th class="align-middle">Delivered Material as of</th>
                <th class="align-middle">Material Pulled Out as of</th>
                <th class="align-middle">Unit</th>
                <th class="align-middle">Accumulated Materials Delivered</th>
                <th class="align-middle">Material on Site as of</th>
                <th class="align-middle">Unit</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $projects_id = $_GET['projects_id'];
                $lastmatinfo_month = $_GET['lastmatinfo_month'];
                $lastmatinfo_year = $_GET['lastmatinfo_year'];
                
                $sql = "SELECT
                            materials.mat_name,
                            categories.categories_name,
                            lastmatinfo.lastmatinfo_prevStock,
                            unit.unit_name,
                            lastmatinfo.lastmatinfo_deliveredMat,
                            lastmatinfo.lastmatinfo_matPulledOut,
                            lastmatinfo.lastmatinfo_accumulatedMat,
                            lastmatinfo.lastmatinfo_matOnSite
                        FROM
                            lastmatinfo
                        INNER JOIN
                            materials ON lastmatinfo.lastmatinfo_matname = materials.mat_id
                        INNER JOIN
                            categories ON lastmatinfo.lastmatinfo_categ = categories.categories_id
                        INNER JOIN
                            unit ON lastmatinfo.lastmatinfo_unit = unit.unit_id
                        WHERE 
                            lastmatinfo.lastmatinfo_project = $projects_id 
                            AND
                                lastmatinfo.lastmatinfo_year = $lastmatinfo_year
                            AND
                                lastmatinfo.lastmatinfo_month = $lastmatinfo_month
                        ORDER BY 1;";

                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_row($result)) {
            ?>
            <tr>
                <td><?php echo $row[0];?></td>
                <td><?php echo $row[2];?></td>
                <td><?php echo $row[3];?></td>
                <td><?php echo $row[4];?></td>
                <td><?php echo $row[5];?></td>
                <td><?php echo $row[3];?></td>
                <td><?php echo $row[6];?></td>
                <td><?php echo $row[7];?></td>
                <td><?php echo $row[3];?></td>
            </tr>

            <?php
                }
            ?>
        </tbody>
    </table>
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