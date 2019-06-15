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
                        <a class="dropdown-item" href="account.php">Account Settings</a>
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
                        <a href="#siteSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"
                            id="sideNav-a">Site</a>
                        <ul class="collapse list-unstyled" id="siteSubmenu">
                            <li>
                                <a href="projects.php" id="sideNav-a">Projects</a>
                            </li>
                            <li>
                                <a href="sitematerials.php" id="sideNav-a">Site Materials</a>
                            </li>
                        </ul>
                    </li>
                    <li class="active">
                        <a href="#haulingSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"
                            id="sideNav-a">Hauling</a>
                        <ul class="collapse list-unstyled" id="haulingSubmenu">
                            <li>
                                <a href="fillouthauling.php" id="sideNav-a">Fill out Hauling Receipt</a>
                            </li>
                            <li>
                                <a href="hauleditems.php" id="sideNav-a">View Hauled Materials</a>
                            </li>
                        </ul>
                    </li>
                    <li class="active">
                        <a href="#transactionSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"
                            id="sideNav-a">Transactions</a>
                        <ul class="collapse list-unstyled" id="transactionSubmenu">
                            <li>
                                <a href="requisitionslip.php" id="sideNav-a">Material Requisition Slip</a>
                            </li>
                            <li>
                                <a href="deliveredin.php" id="sideNav-a">Delivered In Form</a>
                            </li>
                            <li>
                                <a href="viewTransactions.php" id="sideNav-a">View Transactions</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="returns.php" id="sideNav-a">Returns</a>
                    </li>
                    <li>
                        <a href="addingOfNewMaterials.php" id="sideNav-a">Adding of Materials</a>
                    </li>
                    <li class="active">
                        <a href="#reportSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"
                            id="sideNav-a">Reports</a>
                        <ul class="collapse list-unstyled" id="reportSubmenu">
                            <li>
                                <a href="currentReport.php" id="sideNav-a">Monthly Report</a>
                            </li>
                            <li>
                                <a href="previousReports.php" id="sideNav-a">Previous Reports</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>

        </div>

    </div>

    <div class="mx-auto mt-5 col-md-11">
        <div class="card">
            <div class="card-header">
                <h4>User Information</h4>
            </div>
            <div class="card-body">
                <?php 
                    $sql = "SELECT 
                    accounts_fname, accounts_lname, accounts_username, accounts_email, accounts_password FROM accounts
                    WHERE accounts_id = $accounts_id;";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_row($result);
                ?>
                <form action="../server.php" method="POST">
                    <div class="row form-group">
                        <label class="col-lg-2 col-form-label ">First name</label>
                        <div class="col-lg-4">
                            <input class="form-control" type="text" value="<?php echo $row[0]?>" name="firstName">
                        </div>
                        <label class="col-lg-2 col-form-label">Last name</label>
                        <div class="col-lg-4">
                            <input class="form-control" type="text" value="<?php echo $row[1]?>" name="lastName">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-lg-2 col-form-label">Username</label>
                        <div class="col-lg-4">
                            <input class="form-control" type="text" value="<?php echo $row[2]?>" name="username">
                        </div>
                        <label class="col-lg-2 col-form-label ">Email Address</label>
                        <div class="col-lg-4">
                            <input class="form-control" type="email" value="<?php echo $row[3]?>" name="email">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-lg-2 col-form-label">New Password</label>
                        <div class="col-lg-4">
                            <input class="form-control" type="password" name="pass" id="pass">
                        </div>
                        <label class="col-lg-2 col-form-label">Confirm Password</label>
                        <div class="col-lg-4">
                            <input class="form-control" type="password" name="confpass" id="confpass">
                        </div>
                        <div class="col">
                            <input type="checkbox" id="checkbox-new-password" onclick="showNewPassword()" />
                            <label for="checkbox-new-password">Show new password</label>
                        </div>
                        <div class="col">
                            <span class="error" style="color:red"></span><br />
                        </div>
                    </div>
                    <div class="row form-group accnt-btn">
                        <input type="button" class="btn btn-success save-accnt-btn" data-toggle="modal"
                                data-target="#edit-acct-modal"
                            value="Save Changes">
                        <input type="reset" class="btn btn-danger cancel-accnt-btn" value="Cancel">

                    </div>
                    <!-- Start of confirmation modal -->
                    <div class="modal fade" id="edit-acct-modal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to save changes?</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        &times;
                                    </button>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="update_account" class="btn btn-success">Yes</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of confirmation modal -->
                </form>
            </div>
        </div>
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

        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });

        var allowsubmit = false;
        $(function () {
            $('#confpass').keyup(function (e) {
                var pass = $('#pass').val();
                var confpass = $(this).val();
                if (pass == confpass) {
                    $('.error').text('');
                    allowsubmit = true;
                } else {
                    $('.error').text('Password do not matched');
                    allowsubmit = false;
                }
            });

            $('#form').submit(function () {

                var pass = $('#pass').val();
                var confpass = $('#confpass').val();

                if (pass == confpass) {
                    allowsubmit = true;
                }
                if (allowsubmit) {
                    return true;
                } else {
                    return false;
                }
            });
        });

    });

    function showNewPassword() {
        var show = document.getElementById("pass");
        if (show.type === "password") {
            show.type = "text";
        } else {
            show.type = "password";
        }
        var showconfirm = document.getElementById("confpass");
        if (showconfirm.type === "password") {
            showconfirm.type = "text";
        } else {
            showconfirm.type = "password";
        }
    }
</script>

</html>