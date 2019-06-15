<?php
    include "db_connection.php";
    session_start();
?>

<!DOCTYPE html>

<html>

<head>
    <title>NGCBDC</title>
    <link rel="icon" type="image/png" href="Images/login2.png">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
        integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</head>

<body class="login-wrapper">
    <div class="login-container">
        <form class="login-form needs-validation" action="server.php" method="POST" novalidate>
            <div class="form-group">
                <img src="Images/login.png" id="login-logo-image">
                <p id="login-text">FORGOT PASSWORD</p>
            </div>
            <div class="form-group">
                <label for="inputUsername">Username</label>
                <input type="text" class="form-control" id="inputUsername" name="inputUsername"
                    placeholder="Enter your username" required>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div>
                <p>
                    <?php
                        if (isset($_SESSION['request_done'])) {
                            echo "Request to reset the password has already been made.";
                            unset($_SESSION['request_done']);
                        } 
                        if (isset($_SESSION['user_not_exists'])) {
                            echo "Username doesn't exists.";
                            unset($_SESSION['user_not_exists']);
                        }

                        
                    ?>
                </p>
            </div>
            <div>
                <p class="form-group forgot-password-link"><a href="index.php"><i class="fas fa-arrow-left"></i>Back to Login Page</a></p>
            </div>
            <div class="form-group">
                <p>
                    <?php
                        if(isset($_SESSION['login_error'])) {
                            echo "Incorrect username or password.";
                            unset($_SESSION['login_error']);
                        }
                    ?>
                </p>
                <button type="submit" name="forgotPassword" class="btn btn-primary login-btn">Send</button>
            </div>
        </form>
    </div>
    <script>
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
    </script>
</body>

</html>