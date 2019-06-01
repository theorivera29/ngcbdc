<?php
    include "../db_connection.php";
    session_start();

    $accounts_id = $_SESSION['account_id'];    
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
    <script src="../JS/jquery/jquery-3.4.1.min.js"></script>
    <script src="../JS/popper/popper.min.js"></script>
    <script src="../bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
</head>

<body>
    <div id="content">
        <span class="slide">
            <a href="#" class="open" onclick="openSlideMenu()">
                <i class="fas fa-bars"></i>
            </a>
            <h4 class="title">NEW GOLDEN CITY BUILDERS AND DEVELOPMENT CORPORATION</h4>
<!--            <div class="account-container">
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
                        <a class="dropdown-item" href="">Logout</a>
                    </div>
                </div>
            </div>-->
        </span>

        <div id="menu" class="navigation sidenav">
            <a href="#" class="close" onclick="closeSlideMenu()">
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
                    <li>
                        <a href="returnsOrReplaced.php" id="sideNav-a">Returns/Replacements</a>
                    </li>
                    <li>
                        <a href="addingOfMaterials.php" id="sideNav-a">Adding of Materials</a>
                    </li>
                    <li>
                        <a href="reports.php" id="sideNav-a">Reports</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <!-- <section id="tabs">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 project-tabs">
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                            role="tab" aria-controls="nav-home" aria-selected="true">RETURN</a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                            role="tab" aria-controls="nav-profile" aria-selected="false">REPLACE</a>
                    </div>

                </div>
                <div class="returns-or-replace-content">
                    <div class="tab-content" id="nav-tabContent return-container">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                            aria-labelledby="nav-home-tab">
                            <div class="card return-container">
                                <div class="card-header">
                                    <h4>List of Materials to be Return</h4>
                                </div>
                                <table class="table hauled-items-table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Form No.</th>
                                            <th scope="col">Hauling Date</th>
                                            <th scope="col">Hauled From</th>
                                            <th scope="col">Hauled By</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><button type="button" class="btn btn-success">Open</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <div class="card replace-container">
                                <div class="card-header">
                                    <h4>List of Materials to be Replaced</h4>
                                </div>
                                <table class="table hauled-items-table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Disposal Date</th>
                                            <th scope="col">Project</th>
                                            <th scope="col">Location</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><button type="button" class="btn btn-success">Open</button></td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->

    <section id="tabs">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 project-tabs">
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-return"
                            role="tab" aria-controls="nav-home" aria-selected="true">TO BE RETURN</a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-permanent"
                            role="tab" aria-controls="nav-profile" aria-selected="false">PERMANENTLY HAULED</a>
                    </div>

                </div>
                <div class="returns-or-replace-content">
                    <div class="tab-content" id="nav-tabContent return-container">
                        <div class="tab-pane fade show active" id="nav-return" role="tabpanel"
                            aria-labelledby="nav-home-tab">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Hauling Receipt (To Be Return)</h4>
                                </div>
                                <div class="card-body">
                                    <form action="../server.php" method="POST" class="needs-validation" novalidate>
                                        <div class="form-group row formnum-container">
                                            <div class=" col-lg-12">
                                                <label class="col-lg-12 col-form-label">Form No.:</label>
                                                <div class="col-lg-12">
                                                    <input class="form-control" type="text" name="formNo"
                                                          required>
                                                    <div class="invalid-feedback">Please fill out this field.</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row date-container">
                                            <div class="col-lg-12">
                                                <label class="col-lg-12 col-form-label">Date:</label>
                                                <div class="col-lg-12">
                                                    <input class="form-control" type="date" name="date" required>
                                                    <div class="invalid-feedback">Please fill out this field.</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row col-lg-12">
                                            <label class="col-lg-2 col-form-label">Deliver to:</label>
                                            <div class="col-lg-9">
                                                <input class="form-control" type="text" name="deliverTo"
                                                     required>
                                                <div class="invalid-feedback">Please fill out this field.</div>
                                            </div>
                                        </div>
                                        <div class="form-group row col-lg-12">
                                            <label class="col-lg-2 col-form-label">Hauled from:</label>
                                            <div class="col-lg-9">
                                                <input class="form-control" type="text" name="hauledFrom"
                                                     required>
                                                <div class="invalid-feedback">Please fill out this field.</div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <table class="table hauling-form-table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Quantity</th>
                                                        <th scope="col">Articles</th>
                                                        <th scope="col">Unit</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="haulingTable">
                                                </tbody>
                                                <tfoot>
                                                    <tr id="haulingRow">
                                                        <td><input class="form-control" name="quantity" type="text"
                                                                id="quantity" placeholder="Quantity"
                                                                 >
                                                        </td>
                                                        <td>
                                                            <!--<div class="form-group">
                                                                <select class="form-control" name="articles"
                                                                    id="articles">
                                                                    <option value="" selected disabled>Choose an Article
                                                                    </option>
                                                                </select>
                                                            </div>-->
                                                            <input class="form-control" name="articles" type="text"
                                                                id="quantity" placeholder="Articles"
                                                                 >
                                                        </td>
                                                        <td><input class="form-control" name="unit" type="text"
                                                                id="unit" placeholder="Unit">
                                                        </td>
                                                        <td colspan="5">
                                                            <input type="button"
                                                                class="btn btn-md btn-outline-secondary add-row"
                                                                value="Add Row" />
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <div class="form-group row col-lg-12">
                                            <div class="form-group col-lg-6">
                                                <label class="col-lg-12 col-form-label">Requested by:</label>
                                                <div class="col-lg-12">
                                                    <input class="form-control" type="text" name="requestedBy"
                                                         required>
                                                    <div class="invalid-feedback">Please fill out this field.</div>
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label class="col-lg-12 col-form-label">Hauled by:</label>
                                                <div class="col-lg-12">
                                                    <input class="form-control" type="text" name="hauledBy"
                                                         required>
                                                    <div class="invalid-feedback">Please fill out this field.</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row col-lg-12">
                                            <div class="form-group col-lg-6">
                                                <label class="col-lg-12 col-form-label">Warehouseman:</label>
                                                <div class="col-lg-12">
                                                    <input class="form-control" type="text" name="warehouseman"
                                                         required>
                                                    <div class="invalid-feedback">Please fill out this field.</div>
                                                </div>
                                                <label class="col-lg-12 col-form-label">Approved by:</label>
                                                <div class="col-lg-12">
                                                    <input class="form-control" type="text" name="approvedBy"
                                                         required>
                                                    <div class="invalid-feedback">Please fill out this field.</div>
                                                </div>
                                            </div>

                                            <div class="form-group row col-lg-6">
                                                <div class="card hauling-form-card">
                                                    <div class="card-header">
                                                        <h5>TRUCK DETAILS</h5>
                                                    </div>
                                                    <div class="card-body form-group row col-lg-12">
                                                        <label class="col-lg-4 col-form-label">Type:</label>
                                                        <div class="col-lg-8">
                                                            <input class="form-control" type="text" name="type"
                                                                 required>
                                                            <div class="invalid-feedback">Please fill out this field.
                                                            </div>
                                                        </div>
                                                        <label class="col-lg-4 col-form-label">Plate #:</label>
                                                        <div class="col-lg-8">
                                                            <input class="form-control" type="text" name="plateNo"
                                                                  required>
                                                            <div class="invalid-feedback">Please fill out this field.
                                                            </div>
                                                        </div>
                                                        <label class="col-lg-4 col-form-label">P.O./R.S. #:</label>
                                                        <div class="col-lg-8">
                                                            <input class="form-control" type="text" name="PORS"
                                                                 required>
                                                            <div class="invalid-feedback">Please fill out this field.
                                                            </div>
                                                        </div>
                                                        <label class="col-lg-4 col-form-label">Hauler ID:</label>
                                                        <div class="col-lg-8">
                                                            <input class="form-control" type="text" name="haulerID"
                                                                 required>
                                                            <div class="invalid-feedback">Please fill out this field.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group save-btn-container">
                                            <div class="col-lg-12">
                                                <input type="submit" name="create_toBeReturnedHauling" class="btn btn-success"
                                                    value="Save">
                                                <input type="reset" class="btn btn-danger" value="Cancel">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-permanent" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <div class="card replace-container">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Hauling Receipt (Permanently Hauled)</h4>
                                    </div>
                                    <div class="card-body">
                                        <form action="../server.php" method="POST" class="needs-validation" novalidate>
                                            <div class="form-group row formnum-container">
                                                <div class=" col-lg-12">
                                                    <label class="col-lg-12 col-form-label">Form No.:</label>
                                                    <div class="col-lg-12">
                                                        <input class="form-control" type="text" name="formNo"
                                                              required>
                                                        <div class="invalid-feedback">Please fill out this field.</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row date-container">
                                                <div class="col-lg-12">
                                                    <label class="col-lg-12 col-form-label">Date:</label>
                                                    <div class="col-lg-12">
                                                        <input class="form-control" type="date" name="date" required>
                                                        <div class="invalid-feedback">Please fill out this field.</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row col-lg-12">
                                                <label class="col-lg-2 col-form-label">Deliver to:</label>
                                                <div class="col-lg-9">
                                                    <input class="form-control" type="text" name="deliverTo"
                                                         required>
                                                    <div class="invalid-feedback">Please fill out this field.</div>
                                                </div>
                                            </div>
                                            <div class="form-group row col-lg-12">
                                                <label class="col-lg-2 col-form-label">Hauled from:</label>
                                                <div class="col-lg-9">
                                                    <input class="form-control" type="text" name="hauledFrom"
                                                         required>
                                                    <div class="invalid-feedback">Please fill out this field.</div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <table class="table hauling-form-table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Quantity</th>
                                                            <th scope="col">Articles</th>
                                                            <th scope="col">Unit</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="haulingTable">
                                                    </tbody>
                                                    <tfoot>
                                                        <tr id="haulingRow">
                                                            <td><input class="form-control" name="quantity" type="text"
                                                                    id="quantity" placeholder="Quantity"
                                                                     >
                                                            </td>
                                                            <td>
                                                                <!--<div class="form-group">
                                                                    <select class="form-control" name="articles"
                                                                        id="articles">
                                                                        <option value="" selected disabled>Choose an
                                                                            Article
                                                                        </option>
                                                                    </select>
                                                                </div>-->
                                                                <input class="form-control" name="quantity" type="text"
                                                                    id="quantity" placeholder="Quantity">
                                                            </td>
                                                            <td><input class="form-control" name="unit" type="text"
                                                                    id="unit" placeholder="Unit">
                                                            </td>
                                                            <td colspan="5">
                                                                <input type="button"
                                                                    class="btn btn-md btn-outline-secondary add-row"
                                                                    value="Add Row" />
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                            <div class="form-group row col-lg-12">
                                                <div class="form-group col-lg-6">
                                                    <label class="col-lg-12 col-form-label">Requested by:</label>
                                                    <div class="col-lg-12">
                                                        <input class="form-control" type="text" name="requestedBy"
                                                             required>
                                                        <div class="invalid-feedback">Please fill out this field.</div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-lg-6">
                                                    <label class="col-lg-12 col-form-label">Hauled by:</label>
                                                    <div class="col-lg-12">
                                                        <input class="form-control" type="text" name="hauledBy"
                                                             required>
                                                        <div class="invalid-feedback">Please fill out this field.</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row col-lg-12">
                                                <div class="form-group col-lg-6">
                                                    <label class="col-lg-12 col-form-label">Warehouseman:</label>
                                                    <div class="col-lg-12">
                                                        <input class="form-control" type="text" name="warehouseman"
                                                             required>
                                                        <div class="invalid-feedback">Please fill out this field.</div>
                                                    </div>
                                                    <label class="col-lg-12 col-form-label">Approved by:</label>
                                                    <div class="col-lg-12">
                                                        <input class="form-control" type="text" name="approvedBy"
                                                             required>
                                                        <div class="invalid-feedback">Please fill out this field.</div>
                                                    </div>
                                                </div>

                                                <div class="form-group row col-lg-6">
                                                    <div class="card hauling-form-card">
                                                        <div class="card-header">
                                                            <h5>TRUCK DETAILS</h5>
                                                        </div>
                                                        <div class="card-body form-group row col-lg-12">
                                                            <label class="col-lg-4 col-form-label">Type:</label>
                                                            <div class="col-lg-8">
                                                                <input class="form-control" type="text" name="type"
                                                                     required>
                                                                <div class="invalid-feedback">Please fill out this
                                                                    field.
                                                                </div>
                                                            </div>
                                                            <label class="col-lg-4 col-form-label">Plate #:</label>
                                                            <div class="col-lg-8">
                                                                <input class="form-control" type="text" name="plateNo"
                                                                      required>
                                                                <div class="invalid-feedback">Please fill out this
                                                                    field.
                                                                </div>
                                                            </div>
                                                            <label class="col-lg-4 col-form-label">P.O./R.S. #:</label>
                                                            <div class="col-lg-8">
                                                                <input class="form-control" type="text" name="PORS"
                                                                     required>
                                                                <div class="invalid-feedback">Please fill out this
                                                                    field.
                                                                </div>
                                                            </div>
                                                            <label class="col-lg-4 col-form-label">Hauler ID:</label>
                                                            <div class="col-lg-8">
                                                                <input class="form-control" type="text" name="haulerID"
                                                                     required>
                                                                <div class="invalid-feedback">Please fill out this
                                                                    field.
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row form-group save-btn-container">
                                                <div class="col-lg-12">
                                                    <input type="submit" name="create_permanentHauling" class="btn btn-success"
                                                        value="Save">
                                                    <input type="reset" class="btn btn-danger" value="Cancel">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script type="text/javascript">
                $(document).ready(function () {
                    $(".add-row").click(function () {
                        var quantity = $("#quantity").val();
                        var unit = $("#unit").val();
                        var articles = $("#articles").val();
                        var markup = "<tr><td>" + quantity + "</td><td>" + articles + "</td><td>" +
                            unit +
                            "</td><td><input type='button' class='btn btn-sm btn-outline-secondary delete-row' value='Delete' /></td></tr>";
                        if ((quantity != '') && (articles != '') && (unit != '')) {
                            $("table tbody").append(markup);
                            $("#haulingRow input[type=text]").val('');
                            $("#haulingRow select").val('');
                        }
                    });

                    $("#haulingTable").on('click', '.delete-row', function () {
                        $(this).closest('tr').remove();
                    });
                });

                $(function () {
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

                });
            </script>
</body>

</html>