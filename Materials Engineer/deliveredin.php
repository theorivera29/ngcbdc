<?php
    include "../session.php";

     $accounts_id =$_SESSION['account_id'];
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
                    <button type="button" class="btn dropdown-toggle dropdown-settings" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                        <a href="#siteSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" id="sideNav-a">Site</a>
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
                        <a href="#haulingSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" id="sideNav-a">Hauling</a>
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
                        <a href="#transactionSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" id="sideNav-a">Transactions</a>
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
                        <a href="#reportSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" id="sideNav-a">Reports</a>
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

    <div class="mx-auto mt-5 col-md-10">
        <div class="card">
            <div class="card-header">
                <h4>Delivered Materials</h4>
            </div>
            <div class="card-body">
                <form class="form needs-validation" action="../server.php" method="POST" novalidate>
                    <div class="form-group row date-container">
                        <div class="col-lg-12">
                            <label class="col-lg-12 col-form-label">Date:</label>
                            <div class="col-lg-12">
                                <input class="form-control" type="date" name="deliveredDate" required>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row formnum-container">
                        <div class="col-lg-12">
                            <label class="col-lg-12 col-form-label">Receipt No.:</label>
                            <div class="col-lg-12">
                                <input class="form-control" type="text" name="resibo" minlength="4" maxlength="11" required>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row formnum-container">
                        <div class="col-lg-12">
                            <label class="col-lg-12 col-form-label">Remarks:</label>
                            <div class="form-group col-lg-12">
                                <select class="form-control" name="remarks" id="remarks" required>
                                    <option value="" selected disabled>Select remarks:</option>
                                    <option value="Delivered from Main Office">Delivered from Main Office</option>
                                    <option value="Delivered using Petty Cash">Delivered using Petty Cash</option>
                                    <option value="Replacement from Main Office">Replacement from Main Office</option>
                                    <option value="Replacement using Petty Cash">Replacement using Petty Cash</option>
                                </select>
                                <div class="invalid-feedback">Please select one.</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <label class="col-lg-2 col-form-label">Project:</label>
                        <div class="form-group col-lg-9">
                            <select class="form-control" name="projectName" id="projects" required>
                                <option value="" selected disabled>Choose a project</option>
                                <?php
                                                $sql = "SELECT 
                                                    projects_name, projects_id 
                                                FROM projmateng 
                                                INNER JOIN projects 
                                                ON projmateng_project = projects.projects_id 
                                                INNER JOIN accounts 
                                                ON  projmateng_mateng = accounts.accounts_id 
                                                WHERE accounts.accounts_id 
                                                IN (SELECT projmateng_mateng FROM projmateng WHERE projmateng_mateng = $accounts_id);";
                                                    $result = mysqli_query($conn, $sql);
                                                    while ($row = mysqli_fetch_row($result)) {
                                            ?>

                                <option value="<?php echo $row[1]; ?>">
                                    <?php echo $row[0]; ?>
                                </option>
                                <?php
                                        }
                                        ?>
                            </select>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <label class="col-lg-2 col-form-label">Location:</label>
                        <div class="col-lg-9">
                            <input id="location" class="form-control" type="text" name="location" required>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                    </div>
                    <div class="card">
                        <table class="table deliveredin-form-table">
                            <thead>
                                <tr>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Articles</th>
                                    <th scope="col">Units</th>
                                    <th scope="col">Supplied By</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="deliveredTable">
                            </tbody>
                            <tfoot>
                                <tr id="deliveredRow">
                                    <td><input class="form-control" name="quantity[]" type="text" id="quantity" placeholder="Quantity" required>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select class="form-control" name="articles[]" id="articles" required>
                                            </select>
                                            <div class="invalid-feedback">Please select one.</div>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" type="text" id="units" disabled>
                                        <input type="hidden" class="form-control" name="unit[]" id="unit">
                                    </td>
                                    <td><input class="form-control" name="suppliedBy[]" type="text" id="suppliedBy" placeholder="Supplied By" required>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </td>
                                    <td colspan="5">
                                        <input type="button" class="btn btn-md btn-outline-secondary add-row" value="Add Row" />
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="row form-group save-btn-container">
                        <div class="col-lg-12">
                            <input type="button" class="btn btn-primary deliveredin-btn" value="Save Changes" data-toggle="modal" data-target="#save-modal">
                            <input type="reset" class="btn btn-danger" value="Cancel">
                        </div>
                    </div>
                    <!-- Start of confirmation modal -->
                    <div class="modal fade" id="save-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to save
                                        changes?</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        &times;
                                    </button>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="create_deliveredin" class="btn btn-success">Yes</button>
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
    var i = 1;
    $(document).ready(function() {
        $(".add-row").click(function() {
            var quantity = $("#quantity").val();
            var articles = $("#articles option:selected");
            var unit = $("#unit").val();
            var units = $("#units").val();
            var suppliedBy = $("#suppliedBy").val();
            var markup = "<tr><td><input type='text' name='quantity[]' class='form-control' value='" + quantity + "' /></td><td><select class='form-control' name='articles[]' id='articles" + i + "' value='" + articles.val() + "' readonly><option value='" + articles.val() + "' selected readonly>" + articles.text() + "</option></select></td><td><input type='text' class='form-control' value='" + units + "' /><input type='hidden' class='form-control' name='unit[]' value='" + unit + "'></td><td><input type='text' name='suppliedBy[]' class='form-control' value='" + suppliedBy + "' /></td><td><input type='button' class='btn btn-sm btn-outline-secondary delete-row' value='Delete' /></td></tr>";

            if ((quantity != '') && (articles != '') && (unit != '') && (suppliedBy != '')) {
                $("table tbody").append(markup);
                $("#deliveredRow input[type=text]").val('');
                $("#deliveredRow select").val('');
            }
            i++;
        });

        $("#deliveredTable").on('click', '.delete-row', function() {
            $(this).closest('tr').remove();
        });

        $('#sidebarCollapse').on('click', function() {
            $('#sidebar').toggleClass('active');
        });

        $('#articles').on('change', function() {
            console.log($(this).children('option:selected').val())
            $.get('http://localhost/NGCBDC/Materials%20Engineer/../server.php?mat_name=' + $(this).children(
                'option:selected').val(), function(data) {
                var d = JSON.parse(data);
                $('#units').val(d[0][1])
                $('#unit').val(d[0][0])
            })
        })

        $('#projects').on('change', function() {
            console.log($(this).children('option:selected').val())
            $.get('http://localhost/NGCBDC/Materials%20Engineer/../server.php?projects_id=' + $(this).children(
                'option:selected').val(), function(data) {
                var d = JSON.parse(data);
                console.log(d);
                $('#location').val(d)
            })
        })

        $('#projects').on('change', function() {
            $.get('http://localhost/NGCBDC/Materials%20Engineer/../server.php?project_id=' + $(this).children(
                'option:selected').val(), function(data) {
                var d = JSON.parse(data)
                var print_options = '';
                print_options = print_options + `<option disabled selected>Choose your option</option>`
                d.forEach(function(da) {
                    print_options = print_options + `<option value="${da[0]}">${da[1]}</option>`
                })
                $('#articles').html(print_options)
            })
        })

    });

    function openSlideMenu() {
        document.getElementById('menu').style.width = '15%';
    }

    function closeSlideMenu() {
        document.getElementById('menu').style.width = '0';
        document.getElementById('content').style.marginLeft = '0';
    }


    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    var projects = $("#projects option:selected");

</script>

</html>
