<?php
    session_start();
    include "../db_connection.php";

    $accounts_id = null;

    if (isset($_SESSION['account_id'])) {
        $accounts_id = $_SESSION['account_id'];
    }
?>