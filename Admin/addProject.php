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
            <a href="#" class="open" id="sideNav-a" onclick="openSlideMenu()">
                <i class="fas fa-bars"></i>
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
                        <a class="dropdown-item" href="../logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </span>

        <div id="menu" class="navigation sidenav">
            <a href="#" class="close" id="sideNav-a" onclick="closeSlideMenu()">
                <i class="fas fa-times"></i>
            </a>
            <nav id="sidebar">
                <div class="sidebar-header">
                    <img src="../Images/login2.png" id="ngcbdc-logo">
                </div>
                <ul class="list-unstyled components">
                    <li>
                        <a href="dashboard.php" id="sideNav-a">Dashboard</a>
                    </li>
                    <li class="active">
                        <a href="#accountSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"
                            id="sideNav-a">Account</a>
                        <ul class="collapse list-unstyled" id="accountSubmenu">
                            <li>
                                <a href="accountcreation.php" id="sideNav-a">Create Account</a>
                            </li>
                            <li>
                                <a href="listofaccounts.php" id="sideNav-a">List of Accounts</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="passwordrequest.php" id="sideNav-a">Password Request</a>
                    </li>
                    <li>
                        <a href="projects.php" id="sideNav-a">Projects</a>
                    </li>
                    <li>
                        <a href="logs.php" id="sideNav-a">Logs</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <div class="add-project-container">
        <form action="../server.php" method="POST">
            <div class="form-group">
                <label for="projectName" class="label-styles">PROJECT NAME:</label>
                <input name="projectName" type="text" class="form-control" placeholder="Enter project name" pattern="[A-Za-z\s]*" title="Input letters" required>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="form-group">
                <label for="address" class="label-styles">ADDRESS:</label>
                <input name="address" type="text" class="form-control" placeholder="Enter project address" pattern="^[A-Za-z][A-Za-z0-9\s!@#$%^&* ]*$" title="Input letters and numbers only" required>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="form-group">
                <label for="startDate" class="label-styles">START DATE:</label>
                <input name="startDate" id="startDate" type="date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="endDate" class="label-styles">END DATE:</label>
                <input name="endDate" id="endDate" type="date" class="form-control" required>
            </div>
            <label class="label-styles">Materials Engineer Involved</label>
            <?php
                    $sqlmateng = "SELECT 
                    CONCAT(accounts_fname,' ', accounts_lname), accounts_id FROM accounts WHERE accounts_type = 'Materials Engineer';";
                    $resultmateng = mysqli_query($conn, $sqlmateng);
                    while($rowmateng = mysqli_fetch_row($resultmateng)){
                ?>

            <div class="input-group mb-3">

                <div class="input-group-prepend">

                    <div class="input-group-text">
                        <input type="checkbox" name="mateng[]" aria-label="Checkbox for following text input"
                            value="<?php echo $rowmateng[1]?>">
                    </div>
                </div>
                <input type="text" class="form-control" aria-label="Text input with checkbox"
                    value="<?php echo $rowmateng[0]?>" disabled>
            </div>
            <?php
                    }
                ?> 

            <div class="add-project-btn">
                <button type="submit" class="btn btn-success add-proj">Save</button>
                <input type="reset" class="btn btn-danger" value="Cancel">
            </div>

            <!-- Start of confirmation modal -->
            <div class="modal fade" id="create-proj-modal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to create this project?</h5>
                            <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
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
    $(document).ready(function () {

        $('#sidebarCollapse').on('click', function () {
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

    // $(document).ready(function () {
    //     $('#multiselect').multiselect({
    //         buttonWidth: '75%',
    //         includeSelectAllOption: true,
    //         nonSelectedText: 'Select Materials Engineer'
    //     });
    // });

    $(document).ready(function () {
        $(".add-proj").click(function (e) {
            var projname = $("#projectName").val();
            var address = $("#address").val();
            var sdate = $("#startDate").val();
            var edate = $("#endDate").val();
            var selectMat=$("#mateng option:selected").val();
            if ((projname != '') && (address != '') && (sdate != '') && (edate != '') && (selectMat !='')) {
                e.preventDefault();
                $("#create-proj-modal").modal('show');
            }
        });
    });
</script>

</html>