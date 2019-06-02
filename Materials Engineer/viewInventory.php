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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
        integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
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

    <section id="tabs">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 project-tabs">
                    <nav>
                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                                role="tab" aria-controls="nav-home" aria-selected="true">SITE MATERIALS</a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                                role="tab" aria-controls="nav-profile" aria-selected="false">CATEGORY</a>
                        </div>
                    </nav>
                </div>
                <div class="view-inventory-tabs-content">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active view-inventory-tabs-container" id="nav-home"
                            role="tabpanel" aria-labelledby="nav-home-tab">
                            <table class="table view-inventory-tabs-table table-striped table-bordered"
                                id="mydatatable">
                                <thead>
                                    <tr>
                                        <th>Particulars</th>
                                        <th>Category</th>
                                        <th>Previous Material Stock</th>
                                        <th>Unit</th>
                                        <th>Delivered Material as of <?php echo date("F Y"); ?></th>
                                        <th>Material pulled out as of <?php echo date("F Y"); ?></th>
                                        <th>Unit</th>
                                        <th>Accumulated Materials Delivered</th>
                                        <th>Material on site as of <?php echo date("F Y"); ?></th>
                                        <th>Unit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $projects_id = $_GET['projects_id'];
                                    $sql_categ = "SELECT DISTINCT
                                                    categories_name
                                                FROM
                                                    materials
                                                INNER JOIN
                                                    categories ON categories.categories_id = materials.mat_categ
                                                INNER JOIN
                                                    matinfo ON materials.mat_id = matinfo.matinfo_matname
                                                WHERE
                                                    matinfo.matinfo_project = $projects_id;";
                                    $result = mysqli_query($conn, $sql_categ);
                                    $categories = array();
                                    while($row_categ = mysqli_fetch_assoc($result)){
                                        $categories[] = $row_categ;
                                    }

                                    foreach($categories as $data) {
                                        $categ = $data['categories_name'];
                                        
                                        $sql = "SELECT 
                                                    materials.mat_id,
                                                    materials.mat_name,
                                                    categories.categories_name,
                                                    matinfo.matinfo_prevStock,
                                                    unit.unit_name
                                                FROM
                                                    materials
                                                INNER JOIN 
                                                    categories ON materials.mat_categ = categories.categories_id
                                                INNER JOIN 
                                                    unit ON materials.mat_unit = unit.unit_id
                                                INNER JOIN
                                                    matinfo ON materials.mat_id = matinfo.matinfo_matname
                                                WHERE 
                                                    categories.categories_name = '$categ' 
                                                AND 
                                                matinfo.matinfo_project = '$projects_id'
                                                ORDER BY 1;";
                                        $result = mysqli_query($conn, $sql);
                                        while($row = mysqli_fetch_row($result)){
                                            $sql1 = "SELECT 
                                                        SUM(deliveredin.deliveredin_quantity) FROM deliveredin
                                                    INNER JOIN 
                                                        matinfo ON deliveredin.deliveredin_matname = matinfo.matinfo_matname
                                                    WHERE 
                                                        matinfo.matinfo_matname = '$row[0]';";
                                            $result1 = mysqli_query($conn, $sql1);
                                            $row1 = mysqli_fetch_row($result1);
                                            $sql2 = "SELECT 
                                                        SUM(usagein.usagein_quantity) FROM usagein
                                                        INNER JOIN 
                                                        matinfo ON usagein.usagein_matname = matinfo.matinfo_matname
                                                    WHERE 
                                                        matinfo.matinfo_matname = '$row[0]';";
                                            $result2 = mysqli_query($conn, $sql2);
                                            $row2 = mysqli_fetch_row($result2);
                                ?>
                                    <tr>
                                        <td><?php echo $row[1] ;?></td>
                                        <td><?php echo $row[2] ;?></td>
                                        <td><?php echo $row[3] ;?></td>
                                        <td><?php echo $row[4] ;?></td>
                                        <td><?php echo $row1[0] ;?></td>
                                        <td><?php echo $row2[0] ;?></td>
                                        <td><?php echo $row[4] ;?></td>
                                        <td><?php echo $row[3]+$row1[0] ;?></td>
                                        <td><?php echo $row[3]+$row1[0]-$row2[0] ;?></td>
                                        <td><?php echo $row[4] ;?></td>
                                    </tr>
                                <?php
                                        }
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <?php
                                $sql = "SELECT DISTINCT
                                            categories.categories_id,
                                            categories_name
                                        FROM
                                            materials
                                        INNER JOIN
                                            categories ON categories.categories_id = materials.mat_categ
                                        INNER JOIN
                                            matinfo ON materials.mat_id = matinfo.matinfo_matname
                                        WHERE
                                            matinfo.matinfo_matname = $projects_id;";
                                $result = mysqli_query($conn, $sql);
                                while($row = mysqli_fetch_row($result)){
                            ?>
                            <div class="card ">
                                <form action="../server.php" method="POST">
                                    <h5 class="card-header"><?php echo $row[1];?></h5>
                                    <div class="card-body">
                                        <input type="hidden" name="categories_id" value="<?php echo $row[0]; ?>">
                                        <input type="hidden" name="projects_id" value="<?php echo $projects_id; ?>">
                                        <button type="submit" name="materialCategories" class="btn btn-info" id="open-category-btn" onclick="window.location.href='materialCategories.php'">View</button>
                                    </div>
                                </form>
                            </div>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>
<script>
    $(document).ready(function () {
        $('#example').DataTable({
            columnDefs: [{
                orderable: false,
                className: 'select-checkbox',
                targets: 0
            }],
            select: {
                style: 'os',
                selector: 'td:first-child'
            },
            order: [
                [1, 'asc']
            ]
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

        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });

    });
</script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
</script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#mydatatable').DataTable();
    });
</script>


</html>