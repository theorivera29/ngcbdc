<?php
    include "../db_connection.php";
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
    <script src="../JS/jquery/jquery-3.4.1.min.js"></script>
    <script src="../JS/popper/popper.min.js"></script>
    <script src="../bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="mx-auto mt-5 col-md-11">
        <div class="card">
            <div class="card-header">
                <h4>Create Account</h4>
            </div>
            <div class="card-body">
                <form class="needs-validation" novalidate>
                    <div class="form-group">
                        <label for="exampleInputEmail1">First Name</label>
                        <input name="firstName" type="email" class="form-control" placeholder="Enter first name"
                            required>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Last Name</label>
                        <input name="lastName" type="text" class="form-control" placeholder="Enter last name" required>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Userame</label>
                        <input name="username" type="text" class="form-control" placeholder="Enter username" required>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Email</label>
                        <input name="email" type="email" class="form-control" placeholder="Enter email" required>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <span>Account Type:</span>
                    <div class="form-group custom-control custom-radio custom-control-inline">
                        <input type="radio" id="customRadioInline1" name="accountType" class="custom-control-input"
                            required>
                        <label class="custom-control-label" for="customRadioInline1">View Only</label>
                    </div>
                    <div class="form-group custom-control custom-radio custom-control-inline">
                        <input type="radio" id="customRadioInline2" name="accountType" class="custom-control-input"
                            required>
                        <label class="custom-control-label" for="customRadioInline2">Materials Engineer</label>
                    </div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                    <div>
                        <button type="submit" class="btn btn-primary" name="createAccount">Create an Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

<script>
    $(function () {
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
</script>

</html>