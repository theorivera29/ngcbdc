<?php
    include "../db_connection.php";
?>
<!DOCTYPE html>

<html>

<head>
    <title>NGCBDC</title>
    <link rel="icon" type="image/png" href="Images/NGCB_logo.png">
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" href="../bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <script src="../JS/jquery/jquery-3.4.1.min.js"></script>
    <script src="../bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="mx-auto mt-5 col-md-11">
        <div class="card">
            <div class="card-header">
                <h4>User Information</h4>
            </div>
            <div class="card-body">
                <form class="form">
                    <div class="row form-group">
                        <label class="col-lg-2 col-form-label ">First name</label>
                        <div class="col-lg-4">
                            <input class="form-control" type="text" value="">
                        </div>
                        <label class="col-lg-2 col-form-label">Last name</label>
                        <div class="col-lg-4">
                            <input class="form-control" type="text" value="">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-lg-2 col-form-label">Username</label>
                        <div class="col-lg-4">
                            <input class="form-control" type="text" value="">
                        </div>
                        <label class="col-lg-2 col-form-label ">Email Address</label>
                        <div class="col-lg-4">
                            <input class="form-control" type="email" value="">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-lg-2 col-form-label">Password</label>
                        <div class="col-lg-4">
                            <input class="form-control" type="password" value="">
                        </div>
                        <label class="col-lg-2 col-form-label">Confirm Password</label>
                        <div class="col-lg-4">
                            <input class="form-control" type="password" value="">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-3">
                            <input type="button" class="btn btn-primary" value="Save Changes">
                            <input type="reset" class="btn btn-danger" value="Cancel">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>