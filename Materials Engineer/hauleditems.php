<?php
    include "../db_connection.php";
?>
<!DOCTYPE html>

<html>

<head>
    <title>NGCBDC</title>
    <link rel="icon" type="image/png" href="Images/NGCB_logo.png">
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" href="../bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <script src="../JS/jquery/jquery-3.4.1.min.js"></script>
    <script src="../JS/popper/popper.min.js"></script>
    <script src="../bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
</head>

<body>
<div class="mx-auto mt-5 col-md-10">
    <div class="card">
    <div class="card-header">
                <h4>Hauling Receipt</h4>
            </div>
        <table class="table hauled-items-table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">Form No.</th>
                    <th scope="col">Hauling Date</th>
                    <th scope="col">Hauled From</th>
                    <th scope="col">Hauled By</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <?php
        $sql = "SELECT hauling_no, hauling_date, hauling_hauledFrom, hauling_deliverTo FROM  hauling;";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_array($result)) {
    ?>
            <tbody>
               
                <tr>
                    <td><?php echo $row[0]?></td>
                    <td><?php echo $row[1]?></td>
                    <td><?php echo $row[2]?></td>
                    <td><?php echo $row[3]?></td>
                    <td><button type="button" class="btn btn-success">Done</button></td>
                </tr>
            </tbody>
                            <?php
        }
    ?>
        </table>
    </div>
</div>
</body>

</html>