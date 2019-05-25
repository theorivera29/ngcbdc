<?php
    include "../db_connection.php";
?>

<!DOCTYPE html>

<html>

<head>
    <title>NGCBDC</title>
    <link rel="icon" type="image/png" href="Images/NGCB_logo.png">
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
        integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</head>

<body>
<div class="mx-auto mt-5 col-md-10">
    <div class="card">
        <table class="table hauled-items-table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">Hauling Receipt</th>
                    <th scope="col">Date</th>
                    <th scope="col">Project</th>
                    <th scope="col">Deliver To</th>
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