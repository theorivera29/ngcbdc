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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <script src="../js/jquery/jquery-3.4.1.min.js"></script>
    <script src="../js/popper/popper.min.js"></script>
    <script src="../bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
    <script src="../bootstrap-validate-2.2.0/dist/bootstrap-validate.js"></script>
</head>

<body>
<div id="content">
        <span class="slide">
            <a href="#" class="open" onclick="window.location.href='projects.php'">
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
    <div class="add-project-container">
        <form action="../server.php" method="POST" class="needs-validation" novalidate>
            <div class="form-group">
                <label for="projectName" class="label-styles">PROJECT NAME:</label>
                <input name="projectName" id="projectName" type="text" class="form-control" placeholder="Enter project name" pattern="^[A-Za-z][A-Za-z0-9\s-_#&.+()@/<>`~|]*$" title="Input letters" required>
            </div>
            <div class="form-group">
                <label for="address" class="label-styles">ADDRESS:</label>
                <input name="address" id="address" type="text" class="form-control" placeholder="Enter project address" pattern="^[A-Za-z][A-Za-z0-9\s.,-!@#$%^&* ]*$" title="Input letters and numbers only" required>
            </div>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label for="startDate" class="label-styles">START DATE:</label>
                    <input name="startDate" id="startDate" type="date" class="form-control start-date"
                        onchange="startDateEnable()" required>
                </div>
                <div class="col-lg-6">
                    <label for="endDate" class="label-styles">END DATE:</label>
                    <input name="endDate" id="endDate" type="date" class="form-control end-date" required>
                </div>
            </div>
            <label class="label-styles">Materials Engineer Involved</label>
            <?php
                    $sqlmateng = "SELECT 
                    CONCAT(accounts_fname,' ', accounts_lname), accounts_id FROM accounts WHERE accounts_type = 'Materials Engineer' AND accounts_deletable = 'yes';";
                    $resultmateng = mysqli_query($conn, $sqlmateng);
                    while($rowmateng = mysqli_fetch_row($resultmateng)){
                ?>

            <div class="input-group mb-2 col-md-12">
                <div class="input-group-prepend col-md-12 options">
                    <div class="input-group-text">

                        <input type="checkbox" name="mateng[]" aria-label="Checkbox for following text input" value="<?php echo $rowmateng[1]?>" required>
                    </div>

                    <input type="text" class="form-control" aria-label="Text input with checkbox" value="<?php echo $rowmateng[0]?>" disabled>
                </div>
            </div>
            <?php
                }
            ?>
            <div class="add-project-btn">
                <button type="submit" class="btn btn-success add-proj">Save</button>
                <input type="reset" class="btn btn-danger" value="Cancel">
            </div>

            <!-- Start of confirmation modal -->
            <div class="modal fade" id="create-proj-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to create this project?
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                &times;
                            </button>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="create_project" class="btn btn-success">Yes</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>

                        </div>
                    </div>
                </div>
            </div>
            <!-- End of confirmation modal -->
        </form>
    </div>
</body>

<script type="text/javascript">
    $(document).ready(function() {

        $('#sidebarCollapse').on('click', function() {
            $('#sidebar').toggleClass('active');
        });
    });

    function openSlideMenu() {
        document.getElementById('menu').style.width = '15%';
    }

    function closeSlideMenu() {
        document.getElementById('menu').style.width = '0';
        document.getElementById('content').style.marginLeft = '0';
    }

    function startDateEnable() {
        var date = $("#startDate").val();
        var dtToday = new Date(date);

        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if (month < 10)
            month = '0' + month.toString();
        if (day < 10)
            day = '0' + day.toString();

        var start = year + '-' + month + '-' + day;
        $('#endDate').attr('min', start);
    }

    $(document).ready(function() {
        $(".add-proj").click(function(e) {
            var projname = $("#projectName").val();
            var address = $("#address").val();
            var sdate = $("#startDate").val();
            var edate = $("#endDate").val();
            var selectMat = $("#mateng option:selected").val();
            if ((projname != '') && (address != '') && (sdate != '') && (edate != '') && (selectMat !=
                    '')) {
                e.preventDefault();
                $("#create-proj-modal").modal('show');
            }
        });
    });

    (function () {
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

    $(function () {
        var requiredCheckboxes = $('.options :checkbox[required]');
        requiredCheckboxes.change(function () {
            if (requiredCheckboxes.is(':checked')) {
                requiredCheckboxes.removeAttr('required');
            } else {
                requiredCheckboxes.attr('required', 'required');
            }
        });
    });

    bootstrapValidate('#projectName', 'regex:^[A-Za-z][A-Za-z0-9\s-_#&.+()@/<>`~|]*$:You can only input alphabetic characters.')
    bootstrapValidate('#address', 'required:Please fill out this field!')
    bootstrapValidate('#startDate', 'required:Please fill out this field!')
    bootstrapValidate('#endDate', 'required:Please fill out this field!')
</script>

</html>
