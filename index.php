<?php
<<<<<<< HEAD
    include "db_connection.php";
    session_start();
?>

=======
    include "../db_connection.php";
?>
>>>>>>> 618de790a32c5462f8294539d49da581db38a452
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

<body class="login-wrapper">
    <div class="login-container">
        <form class="login-form" action="server.php" method="POST">
            <div class="form-group">
                <img src="Images/login.png" id="login-logo-image">
                <p id="login-text">USER LOGIN</p>
            </div>
            <div class="form-group">
                <label for="inputUsername">Username</label>
                <input type="text" class="form-control" id="inputUsername" name="inputUsername"placeholder="Enter your username">
            </div>
            <div class="form-group">
                <label for="inputPassword">Password</label>
                <input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="Enter your password">
            </div>
            <div>
                <p class="form-group forgot-password-link"><a href="#">Forgot your password?</a></p>
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
                <button type="submit" name="login" class="btn btn-primary login-btn">Login</button>
            </div>
        </form>
    </div>
</body>
</html>