<?php
    include "../session.php";
    unset($_SESSION['hauling_no']);
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
                        <a href="projects.php" id="sideNav-a">Projects</a>
                    </li>
                    <li>
                        <a href="hauleditems.php" id="sideNav-a">Hauled Materials</a>
                    </li>
                    <li>
                        <a href="sitematerials.php" id="sideNav-a">Site Materials</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <div class="list-of-accounts-container">
        <h4 class="card-header">Hauled Materials</h4>
        <table class="table list-of-accounts-table table-striped table-bordered" id="mydatatable">
            <thead>
                <tr>
                    <th scope="col">Form No.</th>
                    <th scope="col">Hauling Date</th>
                    <th scope="col">Hauled From</th>
                    <th scope="col">Hauled By</th>
                    <th scope="col">Hauling Type</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                        $sql = "SELECT 
                        hauling_no, 
                        hauling_date, 
                        projects.projects_name, 
                        hauling_deliverTo,
                        hauling_hauledBy, 
                        hauling_status 
                        FROM  hauling  
                        INNER JOIN 
                            projects ON projects.projects_id = hauling.hauling_hauledFrom;";
                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_array($result)) {
                    ?>

                <tr>
                    <form action="../server.php" method="POST">
                        <td>
                            <?php echo $row[0]?>
                        </td>
                        <td>
                            <?php echo $row[1]?>
                        </td>
                        <td>
                            <?php echo $row[3]?>
                        </td>
                        <td>
                            <?php echo $row[4]?>
                        </td>
                        <td>
                            <?php echo $row[5]?>
                        </td>
                        <td>
                            <input type="hidden" name="hauling_no" value="<?php echo $row[0]?>">
                            <button type="submit" class="btn btn-success" name="view_hauling">View</button></td>
                    </form>
                </tr>

                <?php
                        }
                    ?>
            </tbody>
        </table>
    </div>
</body>

<script type="text/javascript">
    $(document).ready(function () {
        $('#mydatatable').DataTable();
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