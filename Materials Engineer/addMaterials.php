<?php
    include "../session.php";
    if (isset($_SESSION['projects_id'])) {
        $proj_id = $_SESSION['projects_id'];
    } else {
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/projects.php");  
    }
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

<html>

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

    <div class="adding-materials-container">
        <?php 
        $sql = "SELECT projects_name FROM projects WHERE projects_id = '$proj_id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_row($result);
        ?>
        <h4 class="project-title">
            <?php echo $row[0]?>
        </h4>
        <h5 class=" card-header">List of All Materials Added</h5>
        <table class="table adding-materials-table table-striped table-bordered display" id="mydatatable">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Material Name</th>
                    <th>Threshold</th>
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
                matinfo.matinfo_matname,
                matinfo.matinfo_id
                FROM materials
                INNER JOIN categories 
                ON materials.mat_categ = categories.categories_id 
                INNER JOIN unit 
                ON materials.mat_unit = unit.unit_id
                INNER JOIN matinfo 
                ON matinfo.matinfo_matname = materials.mat_id
                WHERE matinfo.matinfo_project = $proj_id;";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_row($result)) {
                ?>
                <tr>
                    <form action="../server.php" method="POST">
                        <td>
                            <?php echo $row[0]; ?>
                        </td>
                        <td>
                            <?php echo $row[1]; ?>
                        </td>
                        <?php
                    $matname = $row[3];
                    $sql1 = "SELECT matinfo_notif FROM matinfo WHERE matinfo_matname = $matname;";
                    $result1 = mysqli_query($conn, $sql1);
                    $row1 = mysqli_fetch_row($result1)
                ?>
                        <td>
                            <input type="text" class="form-control" value="<?php echo $row1[0]?>" name="threshold"
                                placeholder="Enter Threshold">
                        </td>
                        <td>
                            <?php echo $row[2]; ?>
                        </td>
                        <td>
                            <input type="hidden" name="matinfo_id" value="<?php echo $row[4]?>" />
                            <input type="hidden" name="proj_id" value="<?php echo $proj_id?>" />
                            <input type="submit" name="edit_threshold" class="btn btn-info" value="Save">
                        </td>
                    </form>
                </tr>
                <?php
                }   
             ?>
            </tbody>
        </table>
        <h5 class=" card-header list-of-material">List of All Materials</h5>
        <form action="../server.php" method="POST">
            <table class="table adding-materials-table table-striped table-bordered display" id="mydatatable">
                <thead>
                    <tr>
                        <th>Select</th>
                        <th>Category</th>
                        <th>Material Name</th>
                        <th>Unit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
            $sql = "SELECT 
                categories.categories_name, 
                materials.mat_name, 
                unit.unit_name, 
                materials.mat_id 
                FROM materials 
                INNER JOIN categories 
                ON materials.mat_categ = categories.categories_id 
                INNER JOIN unit ON materials.mat_unit = unit.unit_id
                WHERE mat_id NOT IN (SELECT matinfo_matname FROM matinfo WHERE matinfo_project = $proj_id);";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_row($result)) {
            ?>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" name="matName[]" value="<?php echo $row[3]?>"></label>
                            </div>
                        </td>
                        <td><input name="category" type="text" class="form-control" value="<?php echo $row[0]?>"
                                readonly></td>
                        <td><input type="hidden" class="form-control" value="<?php echo $row[3]?>" readonly>
                            <?php echo $row[1]; ?>
                        </td>
                        <td>
                            <?php echo $row[2]?>
                        </td>
                    </tr>
                    <?php
                }   
             ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">

                            <div class="row form-group save-btn-container">
                                <div class="col-lg-12">
                                    <input type="hidden" name="proj_id" value="<?php echo $proj_id?>">
                                    <input type="submit" name="adding_materials" class="btn btn-primary"
                                        value="Save Changes">
                                    <input type="reset" class="btn btn-danger" value="Cancel">
                                </div>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>

        </form>

    </div>
    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
        <div class="card ">
            <h5 class="card-header">Category Name</h5>
            <div class="card-body">
                <button type="button" class="btn btn-info" id="open-category-btn" type="button"
                    onclick="window.location.href='materialCategories.php'">View</button>
            </div>
        </div>
    </div>

    <!-- Start of confirmation modal -->
    <div class="modal fade" id="save-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to save changes?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        &times;
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Yes</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>

                </div>
            </div>
        </div>
    </div>

    <!-- End of confirmation modal -->
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
</script>

</html>