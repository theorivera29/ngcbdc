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
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/requisitionslip.php");     
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

    if(isset($_POST['edit_account'])) {
        $username = mysqli_real_escape_string($conn, $_POST['userid']);
        session_start();
        $account_id = "";
        if(isset($_SESSION['account_id'])) {
            $account_id = $_SESSION['account_id'];
        }
        $edit_account_date = date("Y-m-d G:i:s");
        if(isset($_POST['newusername']) && $_POST['newusername'] != null) {
            $newusername = $_POST['newusername'];
            $stmt = $conn->prepare("UPDATE accounts SET accounts_username = ? WHERE accounts_id = ?;");
            $stmt->bind_param("si", $newusername, $account_id);
            $stmt->execute();
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
            $stmt->bind_param("ssi", $edit_account_date, $logs_message, $logs_of);
            $logs_message = 'Change account username to '.$newusername;
            $logs_of = $account_id;
            $stmt->execute();
            $stmt->close();
            $_SESSION['username'] = $newusername; 
        }
        if(isset($_POST['newfname']) && $_POST['newfname'] != null) {
            $newfname = mysqli_real_escape_string($conn, $_POST['newfname']);
            $stmt = $conn->prepare("UPDATE accounts SET accounts_fname = ? WHERE accounts_id = ?;");
            $stmt->bind_param("si", $newfname, $account_id);
            $stmt->execute();
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
            $stmt->bind_param("ssi", $edit_account_date, $logs_message, $logs_of);
            $logs_message = 'Change first name to '.$account_id;
            $logs_of = $account_id;
            $stmt->execute();
            $stmt->close();
        }

        if(isset($_POST['newlname']) && $_POST['newlname'] != null) {
            $newlname = mysqli_real_escape_string($conn, $_POST['newlname']);
            $stmt = $conn->prepare("UPDATE accounts SET accounts_lname = ? WHERE accounts_id = ?;");
            $stmt->bind_param("si", $newlname, $account_id);
            $stmt->execute();
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
            $stmt->bind_param("ssi", $edit_account_date, $logs_message, $logs_of);
            $logs_message = 'Change last name to '.$newlname;
            $logs_of = $account_id;
            $stmt->execute();
            $stmt->close();
        }

        if(isset($_POST['newemail']) && $_POST['newemail'] != null) {
            $newemail = mysqli_real_escape_string($conn, $_POST['newemail']);
            $stmt = $conn->prepare("UPDATE accounts SET accounts_email = ? WHERE accounts_id = ?;");
            $stmt->bind_param("si", $newemail, $account_id);
            $stmt->execute();
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
            $stmt->bind_param("ssi", $edit_account_date, $logs_message, $logs_of);
            $logs_message = 'Change email to '.$newemail;
            $logs_of = $account_id;
            $stmt->execute();
            $stmt->close();
        }
        
        if(isset($_POST['newpassword']) && $_POST['newpassword'] != null) {
            $newpassword = mysqli_real_escape_string($conn, $_POST['newpassword']);
            $hash_password = password_hash($newpassword, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE accounts SET accounts_password = ? WHERE accounts_id = ?;");
            $stmt->bind_param("si", $hash_password, $account_id);
            $stmt->execute();
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
            $stmt->bind_param("ssi", $edit_account_date, $logs_message, $logs_of);
            $logs_message = 'Change account password ';
            $logs_of = $account_id;
            $stmt->execute();
            $stmt->close();
        }
        header("location: http://127.0.0.1/NGCB/Materials%20Engineer/account.php");        
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