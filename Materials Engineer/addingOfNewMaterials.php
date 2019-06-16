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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <script src="../js/jquery/jquery-3.4.1.min.js"></script>
    <script src="../js/popper/popper.min.js"></script>
    <script src="../bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

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

    <section id="tabs">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 project-tabs">
                    <nav>
                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-category-tab" data-toggle="tab" href="#nav-category" role="tab" aria-controls="nav-category" aria-selected="true">ADD
                                NEW CATEGORY</a>
                            <a class="nav-item nav-link" id="nav-unit-tab" data-toggle="tab" href="#nav-unit" role="tab" aria-controls="nav-unit" aria-selected="false">ADD NEW UNIT</a>
                            <a class="nav-item nav-link" id="nav-material-tab" data-toggle="tab" href="#nav-material" role="tab" aria-controls="nav-material" aria-selected="false">ADD NEW MATERIAL</a>
                        </div>
                    </nav>
                </div>

                <div class="adding-of-materials-content">
                    <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                        <!-- Start of Category -->
                        <div class="tab-pane fade show active adding-of-materials-container" id="nav-category" role="tabpanel" aria-labelledby="nav-category-tab">
                            <form action="../server.php" method="POST">
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
                                            <td><input class="form-control" name="category[]" type="text" id="category" placeholder="Category Name" required>
                                            </td>
                                            <td colspan="5">
                                                <input type="button" name="category[]" class="btn btn-md btn-outline-secondary addCat-row" value="Add Row" />
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="row form-group save-btn-container">
                                    <div class="col-lg-12">
                                        <button type="button" class="btn btn-primary add-categ" data-toggle="modal" data-target="#add-categ-modal">Save Category</button>
                                        <input type="reset" class="btn btn-danger" value="Cancel">
                                    </div>
                                </div>
                                <!-- Start of confirmation modal -->
                                <div class="modal fade" id="add-categ-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to
                                                    add the following categories?</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    &times;
                                                </button>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" name="create_category" class="btn btn-success">Yes</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of confirmation modal -->
                            </form>
                            <table class="table view-inventory-tabs-table table-striped table-bordered display" id="mydatatable">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                            $sql = "SELECT
                                                        categories_id,
                                                        categories_name
                                                    FROM
                                                        categories
                                                    ORDER BY 1;";
                                            $result = mysqli_query($conn, $sql);
                                            while($row = mysqli_fetch_row($result)){
                                        ?>
                                    <tr>
                                        <td>
                                            <?php echo $row[1];?>
                                        </td>
                                        <td><button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#edit-categ-modal-<?php echo $row[0]?>">Edit</button>
                                        </td>
                                    </tr>
                                    <!-- Start of edit category modal -->
                                    <div class="modal fade" id="edit-categ-modal-<?php echo $row[0]?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <form action="../server.php" method="POST">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit Category:
                                                            <?php echo $row[1];?>
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            &times;
                                                        </button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="editcategory" class="label-styles">Category</label>
                                                            <input type="text" class="form-control" value="<?php echo $row[1]?>" name="newCategName" placeholder="Enter new category name">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="hidden" value="<?php echo $row[0]?>" name="categ_id" />
                                                        <button type="submit" name="edit_category" class="btn btn-success">Save</button>
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- End of edit category modal -->
                                    <?php
                                            }
                                        ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- End of Category -->

                        <!-- Start of Unit-->
                        <div class="tab-pane fade show adding-of-materials-container" id="nav-unit" role="tabpanel" aria-labelledby="nav-unit-tab">
                            <form action="../server.php" method="POST">
                                <table class="table new-category-table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Unit</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="add-unit-table">
                                    </tbody>
                                    <tfoot>
                                        <tr id="add-unit-row">
                                            <td><input class="form-control" name="units[]" type="text" id="units" placeholder="Unit" required>
                                            </td>
                                            <td colspan="5">
                                                <input type="button" class="btn btn-md btn-outline-secondary addUnit-row" value="Add Row" />
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="row form-group save-btn-container">
                                    <div class="col-lg-12">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-unit-modal">Save
                                            Unit</button>
                                        <input type="reset" class="btn btn-danger" value="Cancel">
                                    </div>
                                </div>
                                <!-- Start of confirmation modal -->
                                <div class="modal fade" id="add-unit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to
                                                    add the following units?</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    &times;
                                                </button>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" name="create_unit" class="btn btn-success">Yes</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of confirmation modal -->
                            </form>

                            <table class="table view-inventory-tabs-table table-striped table-bordered display" id="mydatatable">
                                <thead>
                                    <tr>
                                        <th>Unit</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                            $sql = "SELECT
                                                        unit_id,
                                                        unit_name
                                                    FROM
                                                        unit
                                                    ORDER BY 1;";
                                            $result = mysqli_query($conn, $sql);
                                            while($row = mysqli_fetch_row($result)){
                                        ?>
                                

                                    <tr>
                                        <td>
                                            <?php echo $row[1]?>
                                        </td>
                                        <td><button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#edit-unit-modal-<?php echo $row[0]?>">Edit</button>
                                        </td>
                                    </tr>

                                    <!-- Start of edit unit modal -->
                                    <div class="modal fade" id="edit-unit-modal-<?php echo $row[0]?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <form action="../server.php" method="POST">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit
                                                            Unit:
                                                            <?php echo $row[1];?>
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="editcategory" class="label-styles">Unit</label>
                                                            <input type="text" class="form-control" value="<?php echo $row[1]?>" name="unit_name" placeholder="Enter new unit name">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="hidden" value="<?php echo $row[0]?>" name="unit_id" />
                                                        <button type="submit" name="edit_unit" class="btn btn-success">Save</button>
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- End of edit unit modal -->
                                
                                <?php
                                            }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- End of Unit -->


                        <!-- Start of Materials -->
                        <div class="tab-pane fade" id="nav-material" role="tabpanel" aria-labelledby="nav-material-tab">
                            <form action="../server.php" method="POST">
                                <table class="table new-category-table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Category</th>
                                            <th scope="col">Material</th>
                                            <th scope="col">Unit</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="add-material-table">
                                    </tbody>
                                    <tfoot>
                                        <tr id="add-material-row">
                                            <td><select name="categ[]" class="custom-select" id="category1" required>
                                                    <option value="disabled" selected disabled>Choose Category</option>
                                                    <?php 
                                                            $sql = "SELECT
                                                                categories_name
                                                            FROM
                                                                    categories
                                                            ORDER BY 1;";
                                                        $result = mysqli_query($conn, $sql);
                                                        while($row = mysqli_fetch_row($result)){
                                                    ?>
                                                    <option value="<?php echo $row[0]?>">
                                                        <?php echo $row[0]?>
                                                    </option>
                                                    <?php
                                                        }
                                                    ?>
                                                </select>
                                            </td>
                                            <td><input class="form-control" name="material[]" type="text" id="material" placeholder="Material Name" required>
                                            </td>
                                            <td><select name="unit[]" class="custom-select" id="unit" required>
                                                    <option value="disabled" selected disabled>Choose unit</option>
                                                    <?php 
                                                            $sql = "SELECT
                                                                unit_name
                                                            FROM
                                                                unit
                                                            ORDER BY 1;";
                                                        $result = mysqli_query($conn, $sql);
                                                        while($row = mysqli_fetch_row($result)){
                                                    ?>
                                                    <option value="<?php echo $row[0]?>">
                                                        <?php echo $row[0]?>
                                                    </option>
                                                    <?php
                                                        }
                                                    ?>
                                                </select>
                                            </td>
                                            <td colspan="5">
                                                <input type="button" class="btn btn-md btn-outline-secondary addMat-row" value="Add Row" />
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="row form-group save-btn-container">
                                    <div class="col-lg-12">
                                        <input type="button" class="btn btn-primary" value="Save Material" data-toggle="modal" data-target="#add-mat-modal">
                                        <input type="reset" class="btn btn-danger" value="Cancel">
                                    </div>
                                </div>

                                <!-- Start of confirmation modal -->
                                <div class="modal fade" id="add-mat-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to
                                                    add the following materials?</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    &times;
                                                </button>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" name="create_materials" class="btn btn-success">Yes</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of confirmation modal -->
                            </form>
                            <form action="../server.php" method="POST">
                                <table class="table view-inventory-tabs-table table-striped table-bordered display" id="mydatatable">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Material Name</th>
                                            <th>Unit</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php 
                                            $sql = "SELECT
                                                        categories.categories_name,
                                                        materials.mat_name,
                                                        unit.unit_name,
                                                        materials.mat_id,
                                                        unit.unit_id
                                                    FROM
                                                        materials
                                                    INNER JOIN
                                                        categories ON materials.mat_categ = categories.categories_id
                                                    INNER JOIN
                                                        unit ON materials.mat_unit = unit.unit_id";
                                            $result = mysqli_query($conn, $sql);
                                            while($row = mysqli_fetch_row($result)){
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $row[0];?>
                                            </td>
                                            <td>
                                                <?php echo $row[1];?>
                                            </td>
                                            <td>
                                                <?php echo $row[2];?>
                                            </td>
                                            
                                            <td><input type="button" class="btn btn-md btn-outline-secondary" value="Edit" data-toggle="modal" data-target="#edit-material-modal-<?php echo $row[3]?>" /></td>
                                        </tr>

                                        <!-- Start of edit material modal -->
                                        <div class="modal fade" id="edit-material-modal-<?php echo $row[3]?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <form action="../server.php" method="POST">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit
                                                                Material:
                                                                <?php echo $row[1];?>
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                &times;
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="editcategory" class="label-styles">Category</label>
                                                                <select name="newCategory" class="custom-select">
                                                                    <option value="<?php echo $row[4]?>" selected disabled>
                                                                        <?php echo $row[0]?>
                                                                    </option>
                                                                    <?php 
                                                                    $sqlcateg = "SELECT
                                                                                categories_name,
                                                                                categories_id
                                                                            FROM
                                                                                categories
                                                                            ORDER BY 1;";
                                                                    $resultcateg = mysqli_query($conn, $sqlcateg);
                                                                    while($rowcateg = mysqli_fetch_row($resultcateg)){
                                                                ?>
                                                                    <option value="<?php echo $rowcateg[1]?>">
                                                                        <?php echo $rowcateg[0]?>
                                                                    </option>
                                                                    <?php
                                                                }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="editmaterialname" class="label-styles">Material Name</label>
                                                                <input class="form-control" name="newMatName" value="<?php echo $row[1];?>" type="text" placeholder="Material Name">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="editunit" class="label-styles">Unit</label>
                                                                <select name="newUnit" class="custom-select">
                                                                    <option value="<?php echo $row[4]?>" selected disabled>
                                                                        <?php echo $row[2]?>
                                                                    </option>
                                                                    <?php 
                                                                            $sqlunit = "SELECT
                                                                                unit_id,
                                                                                unit_name
                                                                            FROM
                                                                                unit
                                                                            ORDER BY 1;";
                                                                    $resultunit = mysqli_query($conn, $sqlunit);
                                                                    while($rowunit = mysqli_fetch_row($resultunit)){
                                                                ?>
                                                                    <option value="<?php echo $rowunit[0]?>">
                                                                        <?php echo $rowunit[1]?>
                                                                    </option>
                                                                    <?php
                                                                }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="modal-footer">
                                                               <input type="hidden" name="mat_id" value="<?php echo $row[3]; ?>" />
                                                                <button type="submit" name="edit_material" class="btn btn-success">Save</button>
                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- End of edit materials modal -->
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                        <!-- end of Materials -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

<script type="text/javascript">
    $(document).ready(function() {
        $('#mydatatable').DataTable();

        $('table.display').DataTable();

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

    $(document).ready(function() {
        $(".addCat-row").click(function() {
            var category = $("#category").val();
            var markup = "<tr><td><input type='text' name='category[]' class='form-control' value='" +
                category +
                "' required/></td><td><input type='button' class='btn btn-sm btn-outline-secondary delete-row' value='Delete' /></td></tr>";
            if ((category != '')) {
                $("table #add-categ-table").append(markup);
                $("#add-categ-row input[type=text]").val('');
            }
        });

        $("#add-categ-table").on('click', '.delete-row', function() {
            $(this).closest('tr').remove();
        });

        $(".addMat-row").click(function() {
            var category = $("#category1").val();
            var material = $("#material").val();
            var unit = $("#unit").val();
            var markup = "<tr><td><input type='text' name='categ[]' class='form-control' value='" +
                category +
                "' readonly/></td><td><input type='text' name='material[]' class='form-control' value='" +
                material +
                "' required/></td><td><input type='text' name='unit[]' class='form-control' value='" + unit +
                "' readonly/></td></td><td><input type='button' class='btn btn-sm btn-outline-secondary delete-row' value='Delete' /></td></tr>";
            if ((category != '') && (material != '')) {
                $("table #add-material-table").append(markup);
                $("#add-material-row input[type=text]").val('');
                $("#add-material-row select").val('disabled');
            }
        });

        $("#add-material-table").on('click', '.delete-row', function() {
            $(this).closest('tr').remove();
        });

        $(".addUnit-row").click(function() {
            var units = $("#units").val();
            var markup = "<tr><td><input type='text' name='units[]' class='form-control' value='" +
                units +
                "' required/></td><td><input type='button' class='btn btn-sm btn-outline-secondary delete-row' value='Delete' /></td></tr>";
            if ((units != '')) {
                $("table #add-unit-table").append(markup);
                $("#add-unit-row input[type=text]").val('');
            }
        });

        $("#add-unit-table").on('click', '.delete-row', function() {
            $(this).closest('tr').remove();
        });
    });

</script>


</html>
