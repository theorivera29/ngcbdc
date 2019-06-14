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
                        <a href="#transactionSubmenu" data-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle" id="sideNav-a">Transactions</a>
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
                                                    <input class="form-control" type="text" name="formNo" id="formNo"
                                                        pattern="[0-9]*" title="Input numbers" required>
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
                                                    pattern="[A-Za-z\s]*" title="Input letters" required>
                                                <div class="invalid-feedback">Please fill out this field.</div>
                                            </div>
                                        </div>
                                        <div class="form-group row col-lg-12">
                                            <label class="col-lg-2 col-form-label">Hauled from:</label>
                                            <select class="form-control" name="projectName" required>
                                                <option value="" selected disabled>Choose a project</option>
                                                <?php
                                                $sql = "SELECT
                                                    projects_name,
                                                    projects_id
                                                FROM
                                                    projects;";
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
                                        </div>
                                        <div class="card">
                                            <table class="table hauling-form-table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Quantity</th>
                                                        <th scope="col">Articles</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="returnHaulingTable">
                                                </tbody>
                                                <tfoot>
                                                    <tr id="returnHaulingRow">
                                                        <td><input class="form-control" name="quantity[]"
                                                                pattern="[0-9]*" title="Input numbers" type="text"
                                                                id="quantity" placeholder="Quantity" required>
                                                            <div class="invalid-feedback">Please fill out this field.
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <select class="form-control" name="articles[]"
                                                                    id="articles">
                                                                    <option value="" selected disabled>Choose an Article
                                                                    </option>
                                                                    <?php
                                                                            $sql = "SELECT
                                                                                mat_name,
                                                                                mat_id
                                                                            FROM
                                                                                materials;";
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
                                                            </div>
                                                        </td><input type="hidden" class="form-control" name="unit[]"
                                                            pattern="[A-Za-z\s]*" title="Input letters" type="text"
                                                            id="unit" placeholder="Unit" required>
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
                                                        pattern="[A-Za-z\s]*" title="Input letters" required>
                                                    <div class="invalid-feedback">Please fill out this field.</div>
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label class="col-lg-12 col-form-label">Hauled by:</label>
                                                <div class="col-lg-12">
                                                    <input class="form-control" type="text" name="hauledBy"
                                                        pattern="[A-Za-z\s]*" title="Input letters" required>
                                                    <div class="invalid-feedback">Please fill out this field.</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row col-lg-12">
                                            <div class="form-group col-lg-6">
                                                <label class="col-lg-12 col-form-label">Warehouseman:</label>
                                                <div class="col-lg-12">
                                                    <input class="form-control" type="text" name="warehouseman"
                                                        pattern="[A-Za-z\s]*" title="Input letters" required>
                                                    <div class="invalid-feedback">Please fill out this field.</div>
                                                </div>
                                                <label class="col-lg-12 col-form-label">Approved by:</label>
                                                <div class="col-lg-12">
                                                    <input class="form-control" type="text" name="approvedBy"
                                                        pattern="[A-Za-z\s]*" title="Input letters" required>
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
                                                                pattern="[A-Za-z\s]*" title="Input letters" required>
                                                            <div class="invalid-feedback">Please fill out this field.
                                                            </div>

                                                        </div>
                                                        <label class="col-lg-4 col-form-label">Plate #:</label>
                                                        <div class="col-lg-8">
                                                            <input class="form-control" type="text" name="plateNo"
                                                                pattern="[A-Za-z0-9\s]*"
                                                                title="Input letters and numbers" required>
                                                            <div class="invalid-feedback">Please fill out this field.
                                                            </div>
                                                        </div>
                                                        <label class="col-lg-4 col-form-label">P.O./R.S. #:</label>
                                                        <div class="col-lg-8">
                                                            <input class="form-control" type="text" name="PORS"
                                                                pattern="[A-Za-z0-9\s]*"
                                                                title="Input letters and numbers" required>
                                                            <div class="invalid-feedback">Please fill out this field.
                                                            </div>
                                                        </div>
                                                        <label class="col-lg-4 col-form-label">Hauler ID:</label>
                                                        <div class="col-lg-8">
                                                            <input class="form-control" type="text" name="haulerID"
                                                                pattern="[0-9]*" title="Input numbers" required>
                                                            <div class="invalid-feedback">Please fill out this field.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group save-btn-container">
                                            <div class="col-lg-12">
                                                <input type="button" data-toggle="modal" data-target="#save-modal"
                                                    class="btn btn-success" value="Save">
                                                <input type="reset" class="btn btn-danger" value="Cancel">
                                            </div>
                                        </div>
                                        <!-- Start of confirmation modal -->
                                        <div class="modal fade" id="save-modal" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Are you sure you
                                                            want to save this hauling form?</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            &times;
                                                        </button>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" name="create_toBeReturnedHauling"
                                                            class="btn btn-success">Yes</button>
                                                        <button type="button" class="btn btn-danger"
                                                            data-dismiss="modal">No</button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- End of confirmation modal -->
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Permanently Hauled -->
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
                                                            id="formNo1" pattern="[0-9]*" title="Input numbers only"
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
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row col-lg-12">
                                                <label class="col-lg-2 col-form-label">Deliver to:</label>
                                                <div class="col-lg-9">
                                                    <input class="form-control" type="text" name="deliverTo"
                                                        pattern="[A-Za-z\s]*" title="Input letters" required>
                                                </div>
                                            </div>
                                            <div class="form-group row col-lg-12">
                                                <label class="col-lg-2 col-form-label">Hauled from:</label>
                                                <select class="form-control" name="projectName" required>
                                                    <option value="" selected disabled>Choose a project</option>
                                                    <?php
                                                $sql = "SELECT
                                                    projects_name,
                                                    projects_id
                                                FROM
                                                    projects;";
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
                                            </div>
                                            <div class="card">
                                                <table class="table hauling-form-table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Quantity</th>
                                                            <th scope="col">Articles</th>
                                                            <th scope="col">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="permanentHaulingTable">
                                                    </tbody>
                                                    <tfoot>
                                                        <tr id="permanentHaulingRow">
                                                            <td><input class="form-control" name="quantity[]"
                                                                    pattern="[0-9]*" title="Input numbers" type="text"
                                                                    id="quantity1" placeholder="Quantity" required>
                                                                <div class="invalid-feedback">Please fill out this
                                                                    field.</div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <select class="form-control" name="articles[]"
                                                                        id="articles">
                                                                        <option value="" selected disabled>Choose an
                                                                            Article</option>
                                                                        <?php
                                                                            $sql = "SELECT
                                                                                mat_name,
                                                                                mat_id
                                                                            FROM
                                                                                materials;";
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
                                                                </div>
                                                            </td><input type="hidden" class="form-control" name="unit[]"
                                                                pattern="[A-Za-z\s]*" title="Input letters" type="text"
                                                                id="unit1" placeholder="Unit" required>
                                                            <td colspan="5">
                                                                <input type="button"
                                                                    class="btn btn-md btn-outline-secondary add-row1"
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
                                                            pattern="[A-Za-z\s]*" title="Input letters" required>
                                                        <div class="invalid-feedback">Please fill out this field.</div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-lg-6">
                                                    <label class="col-lg-12 col-form-label">Hauled by:</label>
                                                    <div class="col-lg-12">
                                                        <input class="form-control" type="text" name="hauledBy"
                                                            pattern="[A-Za-z\s]*" title="Input letters" required>
                                                        <div class="invalid-feedback">Please fill out this field.</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row col-lg-12">
                                                <div class="form-group col-lg-6">
                                                    <label class="col-lg-12 col-form-label">Warehouseman:</label>
                                                    <div class="col-lg-12">
                                                        <input class="form-control" type="text" name="warehouseman"
                                                            pattern="[A-Za-z\s]*" title="Input letters" required>
                                                        <div class="invalid-feedback">Please fill out this field.</div>
                                                    </div>
                                                    <label class="col-lg-12 col-form-label">Approved by:</label>
                                                    <div class="col-lg-12">
                                                        <input class="form-control" type="text" name="approvedBy"
                                                            pattern="[A-Za-z\s]*" title="Input letters" required>
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
                                                                    pattern="[A-Za-z\s]*" title="Input letters"
                                                                    required>
                                                                <div class="invalid-feedback">Please fill out this
                                                                    field.</div>
                                                            </div>
                                                            <label class="col-lg-4 col-form-label">Plate #:</label>
                                                            <div class="col-lg-8">
                                                                <input class="form-control" type="text" name="plateNo"
                                                                    pattern="[A-Za-z0-9\s]*"
                                                                    title="Input letters and numbers" required>
                                                                <div class="invalid-feedback">Please fill out this
                                                                    field.</div>
                                                            </div>
                                                            <label class="col-lg-4 col-form-label">P.O./R.S. #:</label>
                                                            <div class="col-lg-8">
                                                                <input class="form-control" type="text" name="PORS"
                                                                    pattern="[A-Za-z0-9\s]*"
                                                                    title="Input letters and numbers" required>
                                                                <div class="invalid-feedback">Please fill out this
                                                                    field.</div>
                                                            </div>
                                                            <label class="col-lg-4 col-form-label">Hauler ID:</label>
                                                            <div class="col-lg-8">
                                                                <input class="form-control" type="text" name="haulerID"
                                                                    pattern="[0-9\s]*" title="Input letters and numbers"
                                                                    required>
                                                                <div class="invalid-feedback">Please fill out this
                                                                    field.</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row form-group save-btn-container">
                                                <div class="col-lg-12">
                                                    <input type="button" class="btn btn-success" value="Save"
                                                        data-toggle="modal" data-target="#save-modal1">
                                                    <input type="reset" class="btn btn-danger" value="Cancel">
                                                </div>
                                            </div>
                                            <!-- Start of confirmation modal -->
                                            <div class="modal fade" id="save-modal1" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Are you sure
                                                                you
                                                                want to save
                                                                this hauling form?</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                &times;
                                                            </button>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" name="create_permanentHauling"
                                                                class="btn btn-success">Yes</button>
                                                            <button type="button" class="btn btn-danger"
                                                                data-dismiss="modal">No</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- End of confirmation modal -->
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
<script type="text/javascript">
    $(document).ready(function () {
        // For to be returned Hauling
        $(".add-row").click(function () {
            var quantity = $("#quantity").val();
            var unit = $("#unit").val();
            var articles = $("#articles option:selected").text();
            var markup = "<tr><td><input type='text' name='quantity[]' class='form-control' value='" +
                quantity +
                "' required/></td><td><input type='text' name='articles[]' class='form-control' value='" +
                articles +
                "' required/><input type='hidden' name='unit[]' class='form-control' value='" +
                unit +
                "' required/></td><td><input type='button' class='btn btn-sm btn-outline-secondary delete-row' value='Delete' /></td></tr>";
            if ((quantity != '') && (articles != '') && (unit != '')) {
                $("table tbody").append(markup);
                $("#returnHaulingRow input[type=text]").val('');
                $("#returnHaulingRow select").val('');
            }
        });

        $("#returnHaulingTable").on('click', '.delete-row', function () {
            $(this).closest('tr').remove();
        });

        // For Permanently Hauled
        $(".add-row1").click(function () {
            var quantity1 = $("#quantity1").val();
            var unit1 = $("#unit1").val();
            var articles1 = $("#articles1 option:selected").text();
            var markup1 = "<tr><td><input type='text' name='quantity[]' class='form-control' value='" +
                quantity1 +
                "' required/></td><td><input type='text' name='articles[]' class='form-control' value='" +
                articles1 +
                "' required/><input type='hidden' name='unit[]' class='form-control' value='" +
                unit1 +
                "' required/></td><td><input type='button' class='btn btn-sm btn-outline-secondary delete-row' value='Delete' /></td></tr>";
            if ((quantity1 != '') && (articles1 != '') && (unit1 != '')) {
                $("table tbody").append(markup1);
                $("#permanentHaulingRow input[typ e=text]").val('');
                $("#permanentHaulingRow select").val('');
            }
        });

        $("#permanentHaulingTable").on('click', '.delete-row', function () {
            $(this).closest('tr').remove();
        });

        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });

        $('#articles').on('change', function () {
            console.log($(this).children('option:selected').val())
            $.get('http://localhost/NGCBDC/Materials%20Engineer/../server.php?mat_name=' + $(this)
                .children(
                    'option:selected').val(),
                function (data) {
                    var d = JSON.parse(data);
                    $('#unit').val(d[0][0])
                });
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


    function openSlideMenu() {
        document.getElementById('menu').style.width = '15%';
    }

    function closeSlideMenu() {
        document.getElementById('menu').style.width = '0';
        document.getElementById('content').style.marginLeft = '0';
    }

    bootstrapValidate('#formNo', 'numeric:You can only input numeric characters.')
    bootstrapValidate('#formNo1', 'numeric:You can only input numeric characters.')

</script>


</html>