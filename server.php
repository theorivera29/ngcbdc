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
    if (isset($_POST['create_disposalSlip'])) {
        $date = mysqli_real_escape_string($conn, $_POST['date']);
        $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
        $unit = mysqli_real_escape_string($conn, $_POST['unit']);
        $articles = mysqli_real_escape_string($conn, $_POST['articles']);
        $remarks = mysqli_real_escape_string($conn, $_POST['remarks']);
        $todo_status = "in progress";
        
        $stmt = $conn->prepare("SELECT unit_id FROM unit WHERE unit_name = ?;");
        $stmt->bind_param("s", $unit);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($unit_id);
        $stmt->fetch();
        
        $stmt = $conn->prepare("SELECT mat_id FROM materials WHERE mat_name = ?;");
        $stmt->bind_param("s", $articles);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($mat_id);
        $stmt->fetch();
        
        $stmt = $conn->prepare("INSERT INTO disposal (disposal_date, disposal_qty, disposal_unit, disposal_matname, disposal_remarks) VALUES (?, ?, ?, ?, ?);");
        $stmt->bind_param("siiis", $date, $quantity, $unit_id, $mat_id, $remarks);
        $stmt->execute();
        $stmt->close();
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/disposalslip.php");     
    }

    if (isset($_POST['create_requisitionSlip'])) {
        $date = mysqli_real_escape_string($conn, $_POST['date']);
        $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
        $unit = mysqli_real_escape_string($conn, $_POST['unit']);
        $particulars = mysqli_real_escape_string($conn, $_POST['particulars']);
        $location = mysqli_real_escape_string($conn, $_POST['location']);
        $remarks = mysqli_real_escape_string($conn, $_POST['remarks']);
        $requestedBy = mysqli_real_escape_string($conn, $_POST['requestedBy']);
        $approvedBy = mysqli_real_escape_string($conn, $_POST['approvedBy']);
        
        $stmt = $conn->prepare("SELECT unit_id FROM unit WHERE unit_name = ?;");
        $stmt->bind_param("s", $unit);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($unit_id);
        $stmt->fetch();
        
        $stmt = $conn->prepare("SELECT mat_id FROM materials WHERE mat_name = ?;");
        $stmt->bind_param("s", $particulars);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($mat_id);
        $stmt->fetch();
        
        $stmt = $conn->prepare("INSERT INTO requisition (requisition_date, requisition_qty, requisition_unit, requisition_matname, requisition_areaOfUsage, requisition_remarks, requisition_reqBy, requisition_approvedBy) VALUES (?, ?, ?, ?, ?, ?, ?, ?);");
        $stmt->bind_param("siiissss", $date, $quantity, $unit_id, $mat_id, $location, $remarks, $requestedBy, $approvedBy);
        $stmt->execute();
        $stmt->close();
        //header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/requisitionslip.php");     
    }

    if (isset($_POST['create_hauling'])) {
        $formNo = mysqli_real_escape_string($conn, $_POST['formNo']);
        $date = mysqli_real_escape_string($conn, $_POST['date']);
        $deliverTo = mysqli_real_escape_string($conn, $_POST['deliverTo']);
        $hauledFrom = mysqli_real_escape_string($conn, $_POST['hauledFrom']);
        $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
        $unit = mysqli_real_escape_string($conn, $_POST['unit']);
        $articles = mysqli_real_escape_string($conn, $_POST['articles']);
        $requestedBy = mysqli_real_escape_string($conn, $_POST['requestedBy']);
        $hauledBy = mysqli_real_escape_string($conn, $_POST['hauledBy']);
        $warehouseman = mysqli_real_escape_string($conn, $_POST['warehouseman']);
        $approvedBy = mysqli_real_escape_string($conn, $_POST['approvedBy']);
        $type = mysqli_real_escape_string($conn, $_POST['type']);
        $plateNo = mysqli_real_escape_string($conn, $_POST['plateNo']);
        $PORS = mysqli_real_escape_string($conn, $_POST['PORS']);
        $haulerID = mysqli_real_escape_string($conn, $_POST['haulerID']);
                            
        $stmt = $conn->prepare("SELECT unit_id FROM unit WHERE unit_name = ?;");
        $stmt->bind_param("s", $unit);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($unit_id);
        $stmt->fetch();
        
        $stmt = $conn->prepare("SELECT mat_id FROM materials WHERE mat_name = ?;");
        $stmt->bind_param("s", $articles);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($mat_id);
        $stmt->fetch();
            
        $stmt = $conn->prepare("INSERT INTO hauling (hauling_no, hauling_date, hauling_deliverTo, hauling_hauledFrom, hauling_quantity, hauling_unit, hauling_matname, hauling_hauledBy, hauling_requestedBy, hauling_warehouseman, hauling_approvedBy, hauling_truckDetailsType, hauling_truckDetailsPlateNo, hauling_truckDetailsPO, hauling_truckDetailsHaulerDR) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
        $stmt->bind_param("isssiiissssssii", $formNo, $date, $deliverTo, $hauledFrom, $quantity, $unit_id, $mat_id, $hauledBy, $requestedBy, $warehouseman, $approvedBy, $type, $plateNo, $PORS, $haulerID);
        $stmt->execute();
        $stmt->close();
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/fillouthauling.php");     
    }

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


    
// <--View Only-->
?>