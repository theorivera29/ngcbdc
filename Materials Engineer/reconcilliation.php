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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <script src="../js/jquery/jquery-3.4.1.min.js"></script>
    <script src="../js/popper/popper.min.js"></script>
    <script src="../bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
</head>

<body>
    <div id="content">
        <span class="slide">
            <a href="#" class="open" onclick="window.location.href='viewInventory.php'">
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

    <div class="card low-in-quantity-container">
        <h5 class="card-header">Reconcilliation of Project Name</h5>
        <div class="recon-btn">
            <button class="btn btn-danger" id="cancel-recon-btn" data-target="#" type="button">Cancel</button>
            <button class="btn btn-success" id="save-recon-btn" data-target="#" type="button">Save</button>
            <button class="btn btn-info" id="edit-recon-btn" data-target="#" type="button">Edit</button>
            <button class="btn btn-warning" id="generate-recon-btn" data-target="#" type="button">Generate Form</button>
        </div>
        <table class="table reconcilliation-table table-striped table-bordered" id="mydatatable">
            <thead>
                <tr>
                    <th scope="col">Number</th>
                    <th scope="col">Material Name</th>
                    <th scope="col">System Count</th>
                    <th scope="col">Physical Count</th>
                    <th scope="col">Difference</th>
                    <th scope="col">Remarks</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $row[0] ;?></td>
                    <td><?php echo $row[1] ;?></td>
                    <td><?php echo $row[2] ;?></td>
                    <td><input type="text" class="form-control" pattern="[0-9]*" value="" required></td>
                    <td><?php echo $row[3] ;?></td>
                    <td><?php echo $row[4] ;?></td>
                </tr>
            </tbody>
        </table>
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
        $('#mydatatable').DataTable();

        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });

        $('#myModal').on('shown.bs.modal', function () {
            $('#myInput').trigger('focus')
        })

        //Display Only Date till today // 
        var dtToday = new Date();
        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if (month < 10)
            month = '0' + month.toString();
        if (day < 10)
            day = '0' + day.toString();

        var today = year + '-' + month + '-' + day;
        $('#dateID').attr('min', today);

        var maxLength = 45;
        $('textarea').keyup(function () {
            var length = $(this).val().length;
            var length = maxLength - length;
            $('#characters').text(length);
        });

        $('#task-textarea').keypress(function (event) {
            if (event.which == 13) {
                event.preventDefault();
            }
        });

        $('#task-textarea').keyup(function () {
            var txt = $('#comment').val();
            $('#comment').val(txt.replace(/[\n\r]+/g, " "));

        });
    });
</script>

</html>