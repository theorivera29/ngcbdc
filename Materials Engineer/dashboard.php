<?php
    include "../db_connection.php";
    session_start();
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
    <link rel="stylesheet" href="bootstrap-datetimepicker.min.css">
    <script src="bootstrap-datetimepicker.min.js"></script>

</head>

<body>
    <div class="row">
        <div class="col-sm-5">
            <div class="card add-task-container">
                <h5 class="card-header">Add To-do Task</h5>
                <div class="card-body">
                    <p>Date:</p>
                    <input type="date" class="form-control add-task-date" name="date">
                    <textarea class="form-control" id="task-textarea"></textarea>
                    <button type="button" class="btn btn-success" id="save-task-btn" type="submit">Save</button>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card today-task-container">
                <div class="card-header container-fluid">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="">Today's To-do Task</h5>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-light" id="view-all-task-btn" type="button"
                            onclick="window.location.href = 'viewalltasks.php'">View All Task</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table today-task-table">
                        <thead>
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Task</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><button type="button" class="btn btn-success">Done</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card low-in-quantity-container">
        <h5 class="card-header">Materials Low in Quantity</h5>
        <table class="table low-quantity-table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">Material Name</th>
                    <th scope="col">Category</th>
                    <th scope="col">Quantity Remaining</th>
                    <th scope="col">Unit</th>
                    <th scope="col">Threshold</th>
                    <th scope="col">Projects</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $accounts_id = $_SESSION['account_id'];
                    $sql = "SELECT 
                                materials.mat_name, 
                                categories.categories_name, 
                                matinfo.currentQuantity, 
                                unit.unit_name, 
                                matinfo.matinfo_notif, 
                                projects.projects_name 
                            FROM
                                materials
                            INNER JOIN
                                categories ON materials.mat_categ = categories.categories_id
                            INNER JOIN
                                matinfo ON materials.mat_id = matinfo.matinfo_id
                            INNER JOIN
                                unit ON materials.mat_unit = unit.unit_id
                            INNER JOIN
                                projects ON matinfo.matinfo_project = projects.projects_id
                            INNER JOIN
                                projmateng ON projmateng.projmateng_project = projects.projects_id
                            WHERE 
                                projmateng.projmateng_mateng = $accounts_id";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_row($result)) {
                ?>
                <tr>
                    <td><?php echo $row[0] ;?></td>
                    <td><?php echo $row[1] ;?></td>
                    <td><?php echo $row[2] ;?></td>
                    <td><?php echo $row[3] ;?></td>
                    <td><?php echo $row[4] ;?></td>
                    <td><?php echo $row[5] ;?></td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
<script>
</script>

</html>