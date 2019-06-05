<?php
    include "../db_connection.php";
    session_start();

    $accounts_id = null;

    if (isset($_SESSION['account_id'])) {
        $accounts_id = $_SESSION['account_id'];
    }
?>