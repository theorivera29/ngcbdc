<?php
    include "db_connection.php";
    include "smtp_connection.php";

<--Admin-->

    
<--Materials Engineer-->
    
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
        if(isset($_SESSION['account_id'])) {
            $account_id = $_SESSION['account_id'];
        }
        $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
        $stmt->bind_param("ssi", $create_haul_date, $logs_message, $logs_of);
        $create_haul_date = date("Y-m-d G:i:s");
        $logs_message = 'Added Hauling No. '.$hauling_no;
        $logs_of = $account_id;
        $stmt->execute();
        $stmt->close();
        header("Location:http://127.0.0.1/NGCB/Materials%20Engineer/hauleditems.php");        
    }

    
<--View Only-->
?>