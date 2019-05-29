<?php
    include "../db_connection.php";
?>
<!DOCTYPE html>

<html>

<head>
    <title>NGCBDC</title>
    <link rel="icon" type="image/png" href="Images/NGCB_logo.png">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="../bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="../bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="mx-auto mt-5 col-md-11">
        <div class="card">
            <div class="card-header">
                <h4>User Information</h4>
            </div>
            <div class="card-body">
               <?php 
                    $sql = "SELECT 
                    accounts_fname, accounts_lname, accounts_username, accounts_email, accounts_password FROM accounts
                    WHERE accounts_username='materials_engineer';";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_row($result);
                ?>
                <form class="form" action="../server.php" method="POST">
                    <div class="row form-group">
                        <label class="col-lg-2 col-form-label ">First name</label>
                        <div class="col-lg-4">
                            <input class="form-control" type="text" value="<?php echo $row[0]?>" name="firstName">
                        </div>
                        <label class="col-lg-2 col-form-label">Last name</label>
                        <div class="col-lg-4">
                            <input class="form-control" type="text" value="<?php echo $row[1]?>" name="lastName">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-lg-2 col-form-label">Username</label>
                        <div class="col-lg-4">
                            <input class="form-control" type="text" value="<?php echo $row[2]?>" name="username">
                        </div>
                        <label class="col-lg-2 col-form-label ">Email Address</label>
                        <div class="col-lg-4">
                            <input class="form-control" type="email" value="<?php echo $row[3]?>" name="email">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-lg-2 col-form-label">Password</label>
                        <div class="col-lg-4">
                            <input class="form-control" type="password" value="<?php echo $row[4]?>" name="password">
                        </div>
           <!--             <label class="col-lg-2 col-form-label">Confirm Password</label>
                        <div class="col-lg-4">
                            <input class="form-control" type="password" name="">
                        </div>-->
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-3">
                            <input type="submit" class="btn btn-primary" name="update_account" value="Save Changes">
                            <input type="reset" class="btn btn-danger" value="Cancel">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>