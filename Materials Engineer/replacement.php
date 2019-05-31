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
            <a href="#" class="open" id="sideNav-a" onclick="openSlideMenu()">
                <i class="fas fa-bars"></i>
            </a>
            <h4 class="title">NEW GOLDEN CITY BUILDERS AND DEVELOPMENT CORPORATION</h4>
            <!-- Example single danger button -->
            <div class="btn-group dropdown-account">
                <button type="button" class="btn dropdown-toggle dropdown-settings" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="account.php">Account Settings</a>
                    <a class="dropdown-item" href="">Logout</a>
                </div>
            </div>
        </span>

        <div id="menu" class="navigation sidenav">
            <a href="#" class="close" id="sideNav-a" onclick="closeSlideMenu()">
                <i class="fas fa-times"></i>
            </a>
            <nav id="sidebar">
                <div class="sidebar-header">
                    <h3>NGCBDC</h3>
                </div>

                <ul class="list-unstyled components">
                    <li>
                        <a href="dashboard.php" id="sideNav-a">Dashboard</a>
                    </li>
                    <li class="active">
                        <a href="#siteSubmenu" data-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle" id="sideNav-a">Site</a>
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
                        <a href="#haulingSebmenu" data-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle" id="sideNav-a">Hauling</a>
                        <ul class="collapse list-unstyled" id="haulingSebmenu">
                            <li>
                                <a href="fillouthauling.php" id="sideNav-a">Fill out Hauling Receipt</a>
                            </li>
                            <li>
                                <a href="hauleditems.php" id="sideNav-a">View Hauled Materials</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="" id="sideNav-a">Returns/Replacements</a>
                    </li>
                    <li>
                        <a href="reports.php" id="sideNav-a">Reports</a>
                    </li>
                </ul>
            </nav>

        </div>

    </div>
<div class="mx-auto mt-5 col-md-10">
        <div class="card">
            <div class="card-header">
                <h4>Replace Disposed Materials</h4>
            </div>
            <div class="card-body">
                <form class="form">
                    <div class="form-group row date-container">
                        <div class="col-lg-12">
                            <label class="col-lg-12 col-form-label">Date:</label>
                            <div class="col-lg-12">
                                <input class="form-control" type="date" name="disposalDate" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <label class="col-lg-2 col-form-label">Project:</label>
                        <div class="col-lg-9">
                            <input class="form-control" type="text" name="project" disabled>
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <label class="col-lg-2 col-form-label">Location:</label>
                        <div class="col-lg-9">
                            <input class="form-control" type="text" name="location" disabled>
                        </div>
                    </div>
                    <div class="card">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Unit</th>
                                    <th scope="col">Articles</th>
                                    <th scope="col">Remarks</th>
                                    <th scope="col">Quantity Replaced</th>
                                    <th scope="col">Date Replaced</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Replacement Quantity</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                                <tr data-toggle="collapse" data-target="#accordion"
                                    class="clickable">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>                                   
                                    <td><input class="form-control" type="text" placeholder="Replacement Quantity">
                                    </td>
                                    <td> <input type="button" class="btn btn-md btn-outline-secondary save-row"
                                            value="Save" /></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td id="accordion" class="collapse">
                                        <!-- returning qty -->
                                    </td>
                                    <td id="accordion" class="collapse">
                                         <!-- date returned -->
                                    </td>
                                </tr>
                                </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<script>
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
</html>