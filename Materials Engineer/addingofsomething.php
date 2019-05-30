<?php
    include "../db_connection.php";
?>
<!DOCTYPE html>

<html>

<head>
    <title>NGCBDC</title>
    <link rel="icon" type="image/png" href="../Images/login2.png">
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
        integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" href="jquery.dataTables.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="select.dataTables.min.css" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script rel="stylesheet" src="../Libraries/dataTables.select.min.js" crossorigin="anonymous"></script>
    <script rel="stylesheet" src="../Libraries/jquery-3.3.1.js" crossorigin="anonymous"></script>
    <script rel="stylesheet" src="../Libraries/jquery.dataTables.min.js" crossorigin="anonymous"></script>
</head>

<body>
    <table id="example" class="table table-striped table-bordered add-category-table">
        <thead>
            <tr>
                <th></th>
                <th>Category</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="form-group custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck1">
                        <label class="custom-control-label" for="customCheck1"></label>
                    </div>
                </td>
                <td></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th>Category</th>
            </tr>
        </tfoot>
    </table>
</body>
<script>
    $(document).ready(function () {
        $('#example').DataTable({
            columnDefs: [{
                orderable: false,
                className: 'select-checkbox',
                targets: 0
            }],
            select: {
                style: 'os',
                selector: 'td:first-child'
            },
            order: [
                [1, 'asc']
            ]
        });
    });
</script>

</html>