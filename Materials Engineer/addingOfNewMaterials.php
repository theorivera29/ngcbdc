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
            <a href="#" class="open" onclick="openSlideMenu()">
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

    <section id="tabs">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 project-tabs">
                    <nav>
                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                                role="tab" aria-controls="nav-home" aria-selected="true">ADD NEW CATEGORY</a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                                role="tab" aria-controls="nav-profile" aria-selected="false">ADD NEW MATERIAL</a>
                        </div>
                    </nav>
                </div>
                <div class="adding-of-materials-content">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active adding-of-materials-container" id="nav-home"
                            role="tabpanel" aria-labelledby="nav-home-tab">
                            <form class="needs-validation" novalidate>
                                <table class="table new-category-table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Category</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="add-categ-table">
                                    </tbody>
                                    <tfoot>
                                        <tr id="add-categ-row">
                                            <td><input class="form-control" name="category" type="text" id="category"
                                                    placeholder="Category Name">
                                            </td>
                                            <td colspan="5">
                                                <input type="button" class="btn btn-md btn-outline-secondary addCat-row"
                                                    value="Add Row" />
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="row form-group save-btn-container">
                                    <div class="col-lg-12">
                                        <input type="submit" class="btn btn-primary" value="Save Changes">
                                        <input type="reset" class="btn btn-danger" value="Cancel">
                                    </div>
                                </div>

                                <table class="table view-inventory-tabs-table table-striped table-bordered display"
                                    id="mydatatable">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>3</td>
                                            <td><input type="button" class="btn btn-md btn-outline-secondary"
                                                    value="Edit" /></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <form class="needs-validation" novalidate>
                                <table class="table new-category-table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Category</th>
                                            <th scope="col">Material</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="add-material-table">
                                    </tbody>
                                    <tfoot>
                                        <tr id="add-material-row">
                                            <td><select class="custom-select" id="category1">
                                                    <option value="" selected disabled>Choose Category</option>
                                                    <option value="1"></option>
                                                </select>
                                            </td>
                                            <td><input class="form-control" name="material" type="text" id="material"
                                                    placeholder="Material Name">
                                            </td>
                                            <td colspan="5">
                                                <input type="button" class="btn btn-md btn-outline-secondary addMat-row"
                                                    value="Add Row" />
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="row form-group save-btn-container">
                                    <div class="col-lg-12">
                                        <input type="submit" class="btn btn-primary" value="Save Changes">
                                        <input type="reset" class="btn btn-secondary" value="Cancel">
                                    </div>
                                </div>
                                <table class="table view-inventory-tabs-table table-striped table-bordered display"
                                    id="mydatatable">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Material Name</th>
                                            <th>Unit</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>3</td>
                                            <td>33</td>
                                            <td>33</td>
                                            <td><input type="button" class="btn btn-md btn-outline-secondary"
                                                    value="Edit" /></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>

<script type="text/javascript">
    $(document).ready(function () {
        $('#mydatatable').DataTable();

        $('table.display').DataTable();

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

    $(document).ready(function () {
        $(".addCat-row").click(function () {
            var category = $("#category").val();
            var markup = "<tr><td>" + category +
                "</td><td><input type='button' class='btn btn-sm btn-outline-secondary delete-row' value='Delete' /></td></tr>";
            if ((category != '')) {
                $("table #add-categ-table").append(markup);
                $("#add-categ-row input[type=text]").val('');
            }
        });

        $("#add-categ-table").on('click', '.delete-row', function () {
            $(this).closest('tr').remove();
        });

        $(".addMat-row").click(function () {
            var category = $("#category1").val();
            var material = $("#material").val();
            var markup = "<tr><td>" + category + "</td><td>" + material +
                "</td><td><input type='button' class='btn btn-sm btn-outline-secondary delete-row' value='Delete' /></td></tr>";
            if ((category != '') && (material != '')) {
                $("table #add-material-table").append(markup);
                $("#add-material-row input[type=text]").val('');
                $("#add-material-row select").val('');
            }
        });

        $("#add-material-table").on('click', '.delete-row', function () {
            $(this).closest('tr').remove();
        });

        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });
    });
</script>


</html>