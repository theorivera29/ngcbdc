<?php
    include "../db_connection.php";
?>

<!DOCTYPE html>

<html>

<head>
    <title>NGCBDC</title>
    <link rel="icon" type="image/png" href="Images/NGCB_logo.png">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</head>

<body>
    <div class="mx-auto mt-5 col-md-11">
        <div class="card">
            <div class="card-header">
                <h4>Create Account</h4>
            </div>
            <div class="card-body">
                <form>
                    <div class="form-group">
                        <label for="exampleInputEmail1">First Name</label>
                        <input name="firstName" type="email" class="form-control" placeholder="Enter first name">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Last Name</label>
                        <input name="lastName" type="text" class="form-control" placeholder="Enter last name">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Userame</label>
                        <input name="username" type="text" class="form-control" placeholder="Enter username">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Email</label>
                        <input name="email" type="email" class="form-control" placeholder="Enter email">
                    </div>
                    <span>Account Type:</span>
                    <div class="form-group custom-control custom-radio custom-control-inline">
                        <input type="radio" id="customRadioInline1" name="accountType"
                            class="custom-control-input">
                        <label class="custom-control-label" for="customRadioInline1">View Only</label>
                    </div>
                    <div class="form-group custom-control custom-radio custom-control-inline">
                        <input type="radio" id="customRadioInline2" name="accountType"
                            class="custom-control-input">
                        <label class="custom-control-label" for="customRadioInline2">Materials Engineer</label>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary" name="createAccount">Create an Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>