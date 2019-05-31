<?php
    include "../db_connection.php";
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


    <!-- data tables -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
</head>

<body>
    <div class="site-materials-container">
        <table class="table site-materials-table table-striped table-bordered" id="mydatatable">
            <thead>
                <tr>
                <th class="align-middle">Particulars</th>
                <th class="align-middle">Category</th>
                <th class="align-middle">Previous Material Stock</th>
                <th class="align-middle">Unit</th>
                <th class="align-middle">Delivered Material as of</th>
                <th class="align-middle">Material Pulled Out as of</th>
                <th class="align-middle">Accumulated Materials Delivered</th>
                <th class="align-middle">Material on Site as of</th>
                <th class="align-middle">Unit</th>
                <th class="align-middle">Project</th>
                </tr>
            </thead>
            <?php
                $sql = "SELECT materials.mat_name, materials.mat_categ, matinfo.matinfo_prevStock, materials.mat_unit, deliveredin.deliveredin_quantity, usagein.usagein_quantity, matinfo.currentQuantity, matinfo.matinfo_project FROM matinfo INNER JOIN materials on matinfo.matinfo_matname = materials.mat_id INNER JOIN deliveredin on deliveredin_matname = materials.mat_id INNER JOIN usagein on usagein_matname = materials.mat_id";
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_row($result)){
            ?>
            <tr>
                <td><?php echo $row[0]?></td>
                <td><?php echo $row[1]?></td>
                <td><?php echo $row[2]?></td>
                <td><?php echo $row[3]?></td>
                <td><?php echo $row[4]?></td>
                <td><?php echo $row[5]?></td>
                <td><?php echo $row[6]?></td>
                <td><?php echo $row[7]?></td>
                <td><?php echo $row[3]?></td>
                <td><?php echo $row[0]?></td>
            </tr>
            <?php
                }
            ?>
        </table>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
</script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#mydatatable').DataTable();
    });
</script>

</html>