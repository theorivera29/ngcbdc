<?php
    include "db_connection.php";
    include "smtp_connection.php";

// <--System-->>
    if (isset($_POST['login'])) {
        session_start();
        $username = mysqli_real_escape_string($conn, $_POST['inputUsername']);
        $password = mysqli_real_escape_string($conn, $_POST['inputPassword']); 
        $stmt = $conn->prepare("SELECT accounts_id, accounts_password, accounts_type FROM accounts WHERE accounts_username = ? AND accounts_status ='active';");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($accounts_id, $accounts_password, $accounts_type);
        $stmt->fetch();
        if (password_verify($password, $accounts_password)) {
            $_SESSION['account_id']= $accounts_id;
            $_SESSION['loggedin' ] = true;
            $_SESSION['account_type'] = $accounts_type;
            if (strcmp($accounts_type,"Admin") == 0) {
                header("location: http://127.0.0.1/NGCBDC/Admin/admindashboard.php");
                $stmt->close();                
            } else if (strcmp($accounts_type,"Materials Engineer") == 0) {
                header("location: http://127.0.0.1/NGCBDC/Materials%20Engineer/dashboard.php");    
                $stmt->close();                            
            } else {
                header("location: http://127.0.0.1/NGCBDC/View%20Only/projects.php");
                $stmt->close();                                
            }
        } else {
            $_SESSION['login_error'] = true;
            header("location: http://127.0.0.1/NGCBDC/index.php");
            $stmt->close();                
        } 
    }

// <--Admin-->

    
// <--Materials Engineer-->
    if (isset($_POST['create_todo'])) {
        session_start();
        $account_id = "";
        if(isset($_SESSION['account_id'])) {
            $account_id = $_SESSION['account_id'];
        }
        $todo_date = mysqli_real_escape_string($conn, $_POST['todo_date']);
        $todo_task = mysqli_real_escape_string($conn, $_POST['todo_task']);
        $todo_status = "in progress";
        $stmt = $conn->prepare("INSERT INTO todo (todo_date, todo_task, todo_status, todoOf) VALUES (?, ?, ?, ?);");
        $stmt->bind_param("sssi", $todo_date, $todo_task, $todo_status, $account_id);
        $stmt->execute();
        $stmt->close();
        $create_todo_date = date("Y-m-d G:i:s");
        $logs_message = 'Created todo task';
        $logs_of = $account_id;
        $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
        $stmt->bind_param("ssi", $create_todo_date, $logs_message, $logs_of);
        $stmt->execute();
        $stmt->close();
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/dashboard.php");     
    }

    if (isset($_POST['update_todo'])) {
        $todo_id = $_POST['todo_id'];
        $todo_status = $_POST['todo_status'];
        $todo_task = $_POST['todo_task'];
        session_start();
        $account_id = "";
        if(isset($_SESSION['account_id'])) {
            $account_id = $_SESSION['account_id'];
        }
        $update_todo_date = date("Y-m-d G:i:s");
        if (strcmp($todo_status, "in progress") == 0) {
            mysqli_query($conn, "UPDATE todo SET todo_status = 'done' WHERE todo_id = $todo_id");
            mysqli_query($conn, "INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES ('$update_todo_date', 'Updated todo task '.$todo_task.' to done', $account_id);");
        } else {
            mysqli_query($conn, "DELETE FROM todo WHERE todo_id = $todo_id");
            mysqli_query($conn, "INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES ('$update_todo_date', 'Cleared todo task '.$todo_task, $account_id);");
        }
        header("location: http://127.0.0.1/NGCBDC/Materials%20Engineer/dashboard.php");    
    }
    
    if (isset($_POST['create_hauling'])) {
        $hauling_no = mysqli_real_escape_string($conn, $_POST['formNumber']);
        $hauling_date = mysqli_real_escape_string($conn, $_POST['haulingDate']);
		$hauling_deliverTo = mysqli_real_escape_string($conn, $_POST['deliverTo']);
        $hauling_hauledFrom = mysqli_real_escape_string($conn, $_POST['hauledFrom']);
        $hauling_quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
        $hauling_unit = mysqli_real_escape_string($conn, $_POST['unit']);
        $hauling_matname = mysqli_real_escape_string($conn, $_POST['articles']);
        $hauling_hauledBy = mysqli_real_escape_string($conn, $_POST['hauledBy']);
        $hauling_requested = mysqli_real_escape_string($conn, $_POST['requestedBy']);
        $hauling_warehouseman = mysqli_real_escape_string($conn, $_POST['warehouseman']);
        $hauling_approvedBy = mysqli_real_escape_string($conn, $_POST['approvedBy']);
        $hauling_truckDetailsType = mysqli_real_escape_string($conn, $_POST['type']);
        $hauling_truckDetailsPlateNo = mysqli_real_escape_string($conn, $_POST['plateNo']);
        $hauling_truckDetailsPo = mysqli_real_escape_string($conn, $_POST['PORS']);
        $hauling_truckDetailsHaulerDr = mysqli_real_escape_string($conn, $_POST['haulerID']);
        $stmt = $conn->prepare("INSERT INTO hauling (hauling_no, hauling_date, hauling_deliverTo, hauling_hauledFrom, hauling_quantity, 
        hauling_unit, hauling_matname, hauling_hauledBy, hauling_requestedBy, hauling_warehouseman, hauling_approvedBy, hauling_truckDetailsType, 
        hauling_truckDetailsPlateNo, hauling_truckDetailsPo, hauling_truckDetailsHaulerDr)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
        $stmt->bind_param("isssiiissssssss", $hauling_no, $hauling_date, $hauling_deliverTo, $hauling_hauledFrom, $hauling_quantity, 
        $hauling_unit, $hauling_matname, $hauling_hauledBy, $hauling_requested, $hauling_warehouseman, $hauling_approvedBy, $hauling_truckDetailsType, 
        $hauling_truckDetailsPlateNo, $hauling_truckDetailsPo, $hauling_truckDetailsHaulerDr);
        $stmt->execute();
        $stmt->close();
        echo $hauling_unit;
        $stmt = $conn->prepare("SELECT currentQuantity FROM materials WHERE mat_name = ?;");
        $stmt->bind_param("s", $hauling_matname);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($currentQuantity);
        $stmt->fetch();
        $newQuantity = $currentQuantity-$hauling_quantity;
        $stmt = $conn->prepare("UPDATE materials SET currentQuantity = ? WHERE mat_name = ?;");
        $stmt->bind_param("is", $newQuantity, $hauling_matname);
        $stmt->execute();
        $stmt->close();
        $account_id = "";
        session_start();
        if (isset($_SESSION['account_id'])) {
            $account_id = $_SESSION['account_id'];
        }
        $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
        $stmt->bind_param("ssi", $create_haul_date, $logs_message, $logs_of);
        $create_haul_date = date("Y-m-d G:i:s");
        $logs_message = 'Added Hauling No. '.$hauling_no;
        $logs_of = $account_id;
        $stmt->execute();
        $stmt->close();
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/hauleditems.php");        
    }

    
// <--View Only-->
?>