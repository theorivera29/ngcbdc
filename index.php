<?php
    include "db_connection.php";
    session_start();
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

<<<<<<< HEAD
<body>
    <div class="">
        <form action="server.php" method="POST">
=======
<body class="login-wrapper">
    <div class="login-container">
        <form class="login-form">
            <div class="form-group">
                <img src="Images/login.png" id="login-logo-image">
                <p id="login-text">USER LOGIN</p>
            </div>
>>>>>>> 8331c2dc7196e5ffeb624e6ca8acdf3fabe800ec
            <div class="form-group">
                <label for="inputUsername">Username</label>
                <input type="text" class="form-control" id="inputUsername" name="inputUsername"placeholder="Enter your username">
            </div>
            <div class="form-group">
                <label for="inputPassword">Password</label>
                <input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="Enter your password">
            </div>
<<<<<<< HEAD
            <button type="submit" name="login" class="btn btn-primary">Login</button>
=======
            <div>
                <p class="form-group forgot-password-link"><a href="#">Forgot your password?</a></p>
            </div>
            <div class="form-group">
                <p>Username does not exist</p>
                <button type="submit" class="btn btn-primary login-btn">Login</button>
            </div>
>>>>>>> 8331c2dc7196e5ffeb624e6ca8acdf3fabe800ec
        </form>
    </div>
</body>
</html>