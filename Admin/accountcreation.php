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
    <script src="../bootstrap-validate-2.2.0/dist/bootstrap-validate.js"></script>
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
    <form id="createAccountForm" action="../server.php" method="POST" class="needs-validation" novalidate>
        <div class="mx-auto mt-5 col-md-11 account-creation-container">
            <div class="card">
                <div class="card-header">
                    <h4>Create Account</h4>
                </div>
                <div class="card-body">

                    <div class="form-group">
                        <label for="firstName" class="label-styles">First Name</label>
                        <input name="firstName" id="firstName" type="text" class="form-control"
                            placeholder="Enter first name" required>

                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="lastName" class="label-styles">Last Name</label>
                        <input name="lastName" id="lastName" type="text" class="form-control"
                            placeholder="Enter last name" required>

                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="username" class="label-styles">Username</label>
                        <h5>
                            <?php
                                if(isset($_SESSION['username_error'])) {
                                    echo "Username is already taken.";
                                    unset($_SESSION['username_error']);
                                }
                            ?>
                        </h5>
                        <input name="username" id="username" type="text" class="form-control"
                            placeholder="Enter username" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="label-styles">Email</label>
                        <h5>
                            <?php
                                if(isset($_SESSION['email_error'])) {
                                    echo "Email is already taken.";
                                    unset($_SESSION['email_error']);
                                }
                            ?>
                        </h5>
                        <input name="email" id="email" type="email" class="form-control" placeholder="Enter email"
                            pattern="[A-Za-z0-9._]*@[A-Za-z]*\.[A-Za-z]*"
                            title="Follow the format. Example: email@email.com" required>
                    </div>
                    <div class="form-group">
                        <h5 class="form-group" class="label-styles">Account Type:</h5>
                        <div class="form-group custom-control custom-radio custom-control-inline">
                            <input type="radio" id="customRadioInline1" name="accountType" class="custom-control-input"
                                value="View Only" required>
                            <label class="custom-control-label" for="customRadioInline1">View Only</label>
                        </div>
                        <div class="form-group custom-control custom-radio custom-control-inline">
                            <input type="radio" id="customRadioInline2" name="accountType" class="custom-control-input"
                                value="Materials Engineer" required>
                            <label class="custom-control-label" for="customRadioInline2">Materials Engineer</label>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success add-acct" id="create-accnt-btn">Create an
                            Account</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Start of confirmation modal -->
        <div class="modal fade" id="create-accnt-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to create this account?
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            &times;
                        </button>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="createAccount" class="btn btn-success">Yes</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>

                    </div>
                </div>
            </div>
        </div>
        <!-- End of confirmation modal -->

    </form>

    <?php 
        if (isset($_SESSION['create_success'])) {
    ?>
    <div class="modal fade" id="success-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">You have successfully created an account.</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        &times;
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Okay</button>
                </div>
            </div>
        </div>
    </div>
    <?php
            unset($_SESSION['create_success']);
        }
    ?>
</body>

<script type="text/javascript">
    $(document).ready(function () {
        $("#success-modal").modal('show');
    });

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

        $(".add-acct").click(function (e) {
            var fname = $("#firstName").val();
            var lname = $("#lastName").val();
            var uname = $("#username").val();
            var email = $("input[name=email]").val();
            var selectFrom = $("input[name=accountType]:checked").val();
            if ((fname != '') && (lname != '') && (uname != '') && (email != '') && (selectFrom !=
                    '')) {
                e.preventDefault();
                $("#create-accnt-modal").modal('show');
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

    bootstrapValidate('#username',
        'regex:^[A-Za-z0-9._]*$:You can only use alphabetic characters, numbers, period and underscore.')
    bootstrapValidate('#email', 'email:Enter a valid email address.')
</script>

</html>