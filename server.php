<?php
    include "db_connection.php";
    include "smtp_connection.php";

// <--System-->>
    if (isset($_POST['forgotPassword'])) {
        session_start();
        $request_username = mysqli_real_escape_string($conn, $_POST['inputUsername']);
        $stmt = $conn->prepare("SELECT accounts_id FROM accounts WHERE accounts_username = ?");
        $stmt->bind_param("s", $request_username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows === 0) {
            $_SESSION['user_not_exists'] = true;
        }
        $stmt->bind_result($accounts_id);
        $stmt->fetch();
        $stmt->close();
        $stmt = $conn->prepare("SELECT * FROM request WHERE req_username = ?");
        $stmt->bind_param("s", $accounts_id);
        $stmt->execute();
        $stmt->store_result();
        echo $stmt->num_rows;
        if ($stmt->num_rows === 0) {
            $stmt->close();
            $password_request_date = date("Y-m-d");
            $status = "pending";
            $stmt = $conn->prepare("INSERT INTO request (req_username, req_date, req_status) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $accounts_id, $password_request_date, $status);
            $stmt->execute();
            $stmt->close();
            $password_request_date_logs = date("Y-m-d G:i:s");
            $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
            $stmt->bind_param("ssi", $password_request_date_logs, $logs_message, $logs_of);
            $logs_message = 'Requested to reset password';
            $logs_of = $accounts_id;
            $stmt->execute();
        } else {
            $_SESSION['request_done'] = true;
        }
        $stmt->close();
        header("location: http://127.0.0.1/NGCBDC/index.php");
    }

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
        $_SESSION['account_id']= null;
        $_SESSION['loggedin' ] = null;
        $_SESSION['account_type'] = null;
        if (password_verify($password, $accounts_password)) {
            
            $_SESSION['account_id']= $accounts_id;
            $_SESSION['loggedin' ] = true;
            $_SESSION['account_type'] = $accounts_type;
            if (strcmp($accounts_type,"Admin") == 0) {
                header("location: http://127.0.0.1/NGCBDC/Admin/dashboard.php");
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
            $stmt->close();                
            header("location: http://127.0.0.1/NGCBDC/index.php");
        } 
    }

    if (isset($_POST['createAccount'])) {
        $ctr = 0;
        session_start();
        $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
        $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $accountType = mysqli_real_escape_string($conn, $_POST['accountType']);
        $stmt = $conn->prepare("SELECT COUNT(accounts_username ) FROM accounts WHERE accounts_username = ?;");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($count_username);
        $stmt->fetch();
        
        if ($count_username != 0) {
            $_SESSION['username_error'] = true;
            $ctr++;
        }

        $stmt = $conn->prepare("SELECT COUNT(accounts_email ) FROM accounts WHERE accounts_email = ?;");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($count_email);
        $stmt->fetch();

        if ($count_email != 0) {
            $_SESSION['email_error'] = true;
            $ctr++;
        }

        if ($ctr == 0) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $generated_password = substr(str_shuffle($characters), 0, 8);
            $password = password_hash($generated_password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO accounts (accounts_fname, accounts_lname, accounts_username, accounts_password, accounts_type, accounts_email, accounts_deletable, accounts_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?);");
            $stmt->bind_param("ssssssss", $firstName, $lastName, $username, $password, $accountType, $email, $accountsDeletable, $accountsStatus);
            $accountsDeletable = "yes";
            $accountsStatus = "active";
            $stmt->execute();
            try {
                $mail->addAddress($email, $firstname.' '.$lastname);                
                $mail->isHTML(true);                                  
                $mail->Subject = 'Welcome to your NGCBDC Inventory System Account!';
                $mail->Body    = 'Your account has been created. <br /> Please change your password after logging in. <br /> <br /> Username: <b>'.$username.'</b> <br /> Password: <b>'.$generated_password.'</b>';
                $mail->send();
            } catch (Exception $e) {}
            $create_date = date("Y-m-d G:i:s");
            $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
            $stmt->bind_param("ssi", $create_date, $logs_message, $logs_of);
            $logs_message = 'Created account of '.$firstName.' '.$lastName;
            $logs_of = 1;
            $stmt->execute();
            $stmt->close();
            $_SESSION['create_success'] = true;
        }
        header("location: http://127.0.0.1/NGCBDC/Admin/accountcreation.php");  
    }

// <--Admin-->
    if (isset($_POST['disableAccount'])) {
        $accounts_id = $_POST['accounts_id'];
        $accounts_username = $_POST['accounts_username'];
        $accounts_status = "inactive";
        $stmt = $conn->prepare("UPDATE accounts SET accounts_status = ? WHERE accounts_id = ?;");
        $stmt->bind_param("si", $accounts_status, $accounts_id);
        $stmt->execute();
        $stmt->close();

        $date_today = date("Y-m-d G:i:s");
        $logs_message = 'Disabled account '.$accounts_username;
        $logs_of = $account_id;
        $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
        $stmt->bind_param("ssi", $date_today, $logs_message, $logs_of);
        $stmt->execute();
        $stmt->close();
        header("Location:http://127.0.0.1/NGCBDC/Admin/listofaccounts.php");     
    }   

    if (isset($_POST['enableAccount'])) {
        $accounts_id = $_POST['accounts_id'];
        $accounts_username = $_POST['accounts_username'];
        $accounts_status = "active";
        $stmt = $conn->prepare("UPDATE accounts SET accounts_status = ? WHERE accounts_id = ?;");
        $stmt->bind_param("si", $accounts_status, $accounts_id);
        $stmt->execute();
        $stmt->close();

        $date_today = date("Y-m-d G:i:s");
        $logs_message = 'Enabled account '.$accounts_username;
        $logs_of = $account_id;
        $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
        $stmt->bind_param("ssi", $date_today, $logs_message, $logs_of);
        $stmt->execute();
        $stmt->close();
        header("Location:http://127.0.0.1/NGCBDC/Admin/listofaccounts.php");     
    }  

    if (isset($_POST['requestAccept'])) {
        $request_accountID = $_POST['accounts_id'];
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $generated_password = substr(str_shuffle($characters), 0, 8);
        $password = password_hash($generated_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("SELECT accounts_email, CONCAT(accounts_fname, ' ', accounts_lname) FROM accounts WHERE accounts_id = ?;");
        $stmt->bind_param("i", $request_accountID);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($request_email, $request_name); 
        $stmt->fetch();
        $stmt->close();
        $stmt = $conn->prepare("UPDATE accounts SET accounts_password = ? WHERE accounts_id = ?;");
        $stmt->bind_param("si", $password, $request_accountID);
        $stmt->execute();
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
        $stmt->bind_param("ssi", $accept_date, $logs_message, $logs_of);
        $accept_date = date("Y-m-d G:i:s");
        $logs_message = 'Accepted request to reset password of '.$request_name;
        $logs_of = 1;
        $stmt->execute();
        $stmt->close();
        $stmt = $conn->prepare("DELETE FROM request WHERE req_username = ?;");
        $stmt->bind_param("i", $request_accountID);
        $stmt->execute();
        $stmt->close();
        try {
            $mail->addAddress($request_email, $request_name);
            $mail->isHTML(true);                                  
            $mail->Subject = 'Password Reset';
            $mail->Body    = 'Hello '.$request_name.' Your request to reset your password has been approved. Please use the temporary password below to login.
                            Please change your password after logging in. <br /> <br /> Password: <b>'.$generated_password.'</b>';
            $mail->send();
        } catch (Exception $e) {}
        header("location: http://127.0.0.1/NGCBDC/Admin/passwordrequest.php");  
    }

    if (isset($_POST['delete_projmateng'])) {
        $mateng = $_POST['mateng'];
        $projects_id = mysqli_real_escape_string($conn, $_POST['project']);
        
        for($x = 0; $x < sizeof($mateng); $x++){
        
        $stmt = $conn->prepare("SELECT projmateng_id FROM projmateng WHERE  projmateng_project = ? AND projmateng_mateng = ?;");
        $stmt->bind_param("ii", $projects_id, $mateng[$x]);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($projmateng_id);
        $stmt->fetch();
        
        $stmt = $conn->prepare("DELETE FROM projmateng WHERE projmateng_id = ?;");
        $stmt->bind_param("i", $projmateng_id);
        $stmt->execute();
        $stmt->close();
        }
        
        header("Location:http://127.0.0.1/NGCBDC/Admin/projects.php");     
    }


    if (isset($_POST['requestReject'])) {
        $request_accountID = $_POST['accounts_id'];
        $stmt = $conn->prepare("SELECT CONCAT(accounts_fname, ' ', accounts_lname) FROM accounts WHERE accounts_id = ?;");
        $stmt->bind_param("i", $request_accountID);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($request_name);
        $stmt->fetch();
        $reject_date = date("Y-m-d G:i:s");        
        $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
        $stmt->bind_param("ssi", $reject_date, $logs_message, $logs_of);
        $logs_message = 'Rejected request to reset password of '.$request_name;
        $logs_of = 2;
        $stmt->execute();
        $stmt->close();
        $stmt = $conn->prepare("DELETE FROM request WHERE req_username = ?;");
        $stmt->bind_param("i", $request_accountID);
        $stmt->execute();
        $stmt->close();
        header("location: http://127.0.0.1/NGCBDC/Admin/passwordrequest.php");  
    }

    if (isset($_POST['close_project'])) {

        $projectName = mysqli_real_escape_string($conn, $_POST['projectName']);
        $projects_id = mysqli_real_escape_string($conn, $_POST['projects_id']);
        $stmt = $conn->prepare("UPDATE projects set projects_status = 'closed' WHERE projects_id = ?;");
        $stmt->bind_param("i", $projects_id);
        $stmt->execute();
        $stmt->fetch();
        $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?,?,?);");
        $close_date = date("Y-m-d G:i:s");
        $logs_message = 'Closed Project: '.$projectName;
        $logs_of = 2;
        $stmt->bind_param("ssi", $close_date, $logs_message, $logs_of);
        $stmt->execute();
        $stmt->close();
        header("Location:http://127.0.0.1/NGCBDC/Admin/projects.php");     
    }

    if (isset($_POST['reopen_project'])) {
        $projectName = mysqli_real_escape_string($conn, $_POST['projectName']);
        $projects_id = mysqli_real_escape_string($conn, $_POST['projects_id']);
        $stmt = $conn->prepare("UPDATE projects set projects_status = 'open' WHERE projects_id = ?;");
        $stmt->bind_param("i", $projects_id);
        $stmt->execute();
        $stmt->fetch();
        $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?,?,?);");
        $reopened_date = date("Y-m-d G:i:s");
        $logs_message = 'Re-Opened Project: '.$projectName;
        $logs_of = 2;
        $stmt->bind_param("ssi", $reopened_date, $logs_message, $logs_of);
        $stmt->execute();
        $stmt->close();
       header("Location:http://127.0.0.1/NGCBDC/Admin/projects.php");     
    }

    if (isset($_POST['delete_project'])) {
        
        $projectName = mysqli_real_escape_string($conn, $_POST['projectName']);
        $projects_id = mysqli_real_escape_string($conn, $_POST['projects_id']);
        
        $stmt = $conn->prepare("DELETE FROM projects WHERE projects_id = ?;");
        $stmt->bind_param("i", $projects_id);
        $stmt->execute();
        $stmt->fetch();
        $stmt->close();
        
        $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?,?,?);");
        $delete_date = date("Y-m-d G:i:s");
        $logs_message = 'Deleted Project: '.$projectName;
        $logs_of = 2;
        $stmt->bind_param("ssi", $delete_date, $logs_message, $logs_of);
        $stmt->execute();
        $stmt->close();
        header("Location:http://127.0.0.1/NGCBDC/Admin/projects.php");     
    }

    if (isset($_POST['create_project'])) {
        $projectName = mysqli_real_escape_string($conn, $_POST['projectName']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $startDate = mysqli_real_escape_string($conn, $_POST['startDate']);
        $endDate = mysqli_real_escape_string($conn, $_POST['endDate']);
        $projectStatus = 'open';
        $mateng = $_POST['mateng'];
        
        $stmt = $conn->prepare("INSERT INTO projects (projects_name, projects_address, projects_sdate, projects_edate, projects_status) VALUES (?, ?, ?, ?, ?);");
        $stmt->bind_param("sssss", $projectName, $address, $startDate, $endDate, $projectStatus);
        $stmt->execute();
        
        if ($stmt->error) {
            echo "di nagana sir!";
        } else {
            
            $stmt = $conn->prepare("SELECT projects_id FROM projects WHERE projects_name = ?;");
            $stmt->bind_param("s", $projectName);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($projects_id);
            $stmt->fetch();
        
            for($x = 0; $x < sizeof($mateng); $x++){
                
            $stmt = $conn->prepare("INSERT INTO projmateng (projmateng_project, projmateng_mateng) VALUES (?, ?);");
            $stmt->bind_param("ii", $projects_id, $mateng[$x]);
            $stmt->execute();
            $stmt->close();
                
            }
        
            $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?,?,?);");
            $create_proj_date = date("Y-m-d G:i:s");
            $logs_message = 'Created Project: '.$projectName;
            $logs_of = 2;
            $stmt->bind_param("ssi", $create_proj_date, $logs_message, $logs_of);
            $stmt->execute();
            $stmt->close();
           header("Location:http://127.0.0.1/NGCBDC/Admin/projects.php");  
        }
    }

if (isset($_POST['edit_project'])) {
        $edit_project_date = date("Y-m-d G:i:s");
        $mateng = null;
        $newProjectName = mysqli_real_escape_string($conn, $_POST['newProjectName']);
        $newAddress = mysqli_real_escape_string($conn, $_POST['newAddress']);
        $newStartDate = mysqli_real_escape_string($conn, $_POST['newStartDate']);
        $newEndDate = mysqli_real_escape_string($conn, $_POST['newEndDate']);
        $projects_id = mysqli_real_escape_string($conn, $_POST['projects_id']);
        $account_id = "";
        session_start();
        if(isset($_SESSION['account_id'])) {
            $account_id = $_SESSION['account_id'];
        }
        if (isset($_POST['newProjectName'])) {
            $newProjectName = mysqli_real_escape_string($conn, $_POST['newProjectName']);
            $stmt = $conn->prepare("UPDATE projects SET projects_name = ? WHERE projects_id = ?;");
            $stmt->bind_param("si", $newProjectName, $projects_id);
            $stmt->execute();
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
            $stmt->bind_param("ssi", $edit_project_date, $logs_message, $logs_of);
            $edit_project_name = date("Y-m-d G:i:s");
            $logs_message = 'Changed Project Name to: '.$newProjectName;
            $logs_of = $account_id;
            $stmt->execute();
            $stmt->close();
        }
        if (isset($_POST['newAddress'])) {
            $newAddress = mysqli_real_escape_string($conn, $_POST['newAddress']);
            $stmt = $conn->prepare("UPDATE projects SET projects_address = ? WHERE projects_id = ?;");
            $stmt->bind_param("si", $newAddress, $projects_id);
            $stmt->execute();
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
            $stmt->bind_param("ssi", $edit_project_date, $logs_message, $logs_of);
            $logs_message = 'Change first name to '.$account_id;
            $logs_of = $account_id;
            $stmt->execute();
            $stmt->close();
        }

        if (isset($_POST['newStartDate'])) {
            $newStartDate = mysqli_real_escape_string($conn, $_POST['newStartDate']);
            $stmt = $conn->prepare("UPDATE projects SET projects_sdate = ? WHERE projects_id = ?;");
            $stmt->bind_param("si", $newStartDate, $projects_id);
            $stmt->execute();
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
            $stmt->bind_param("ssi", $edit_project_date, $logs_message, $logs_of);
            $logs_message = 'Change Start date to '.$newStartDate;
            $logs_of = $account_id;
            $stmt->execute();
            $stmt->close();
        }

        if (isset($_POST['newEndDate'])) {
            $newEndDate = mysqli_real_escape_string($conn, $_POST['newEndDate']);
            $stmt = $conn->prepare("UPDATE projects SET projects_edate = ? WHERE projects_id = ?;");
            $stmt->bind_param("si", $newEndDate, $projects_id);
            $stmt->execute();
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
            $stmt->bind_param("ssi", $edit_project_date, $logs_message, $logs_of);
            $logs_message = 'Change End date to '.$newEndDate;
            $logs_of = $account_id;
            $stmt->execute();
            $stmt->close();
        }

        if (isset($_POST['mateng'])) {
            $mateng = $_POST['mateng'];
    
         for($x = 0; $x < sizeof($mateng); $x++){
                $stmt = $conn->prepare("INSERT INTO projmateng (projmateng_project, projmateng_mateng)
                    VALUES (?, ?);");
                $stmt->bind_param("ii", $projects_id, $mateng[$x]);
                $stmt->execute();
                $stmt->close();
            }
        }
        header("location: http://127.0.0.1/NGCBDC/Admin/projects.php");        
    }

// <--Materials Engineer-->

    if (isset($_POST['curGenerateReport'])) {
        $preparedBy = mysqli_real_escape_string($conn, $_POST['preparedBy']);
        $checkedBy = mysqli_real_escape_string($conn, $_POST['checkedBy']);
        $notedBy = mysqli_real_escape_string($conn, $_POST['notedBy']);
        session_start();
        $_SESSION['preparedBy'] = $preparedBy;
        $_SESSION['checkedBy'] = $checkedBy;
        $_SESSION['notedBy'] = $notedBy;
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/curGenerateReport.php");  
    }

    if (isset($_POST['viewStockCard'])) {
        session_start();
        $matinfo_id = $_POST['matinfo_id'];
        if (isset($_POST['projects_id'])) {
            $projects_id = $_POST['projects_id'];
            $_SESSION['projects_id'] = $projects_id;
        }
        $_SESSION['matinfo_id'] = $matinfo_id;
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/stockcard.php");  

    }

    if (isset($_POST['reconciliation_edit'])) {
        session_start();
        $_SESSION['edit_clicked'] = true;
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/reconciliation.php");  
    }

    if (isset($_POST['reconciliation_reconcile'])) {
        $difference = $_POST['difference'];
        $matinfo_id = $_POST['matinfo_id'];
        $systemCount = $_POST['system_Count'];
        session_start();
        $projects_id = $_SESSION['projects_id'];

        $matt = array();
        $diff = array();
        $sysC = array();

        foreach ($matinfo_id as $m) {
            array_push($matt, $m);
        }
        foreach ($difference as $d) {
            array_push($diff, $d);
        }
        foreach ($systemCount as $s) {
            array_push($sysC, $s);
        }
        for ($ctr = 0; $ctr < sizeof($difference) ; $ctr++) {
            $mat = $matt[$ctr];
            $dif = $diff[$ctr];
            $sys = $sysC[$ctr];
            $phys = $sys-$dif;
            $sql_categ = "SELECT DISTINCT
                            categories_name
                        FROM
                            materials
                        INNER JOIN
                            categories ON categories.categories_id = materials.mat_categ
                        INNER JOIN
                            matinfo ON materials.mat_id = matinfo.matinfo_matname
                        WHERE
                            matinfo.matinfo_id = $mat;";
            $result = mysqli_query($conn, $sql_categ);
            $categories = array();
            while($row_categ = mysqli_fetch_assoc($result)){
                $categories[] = $row_categ;
            }
            foreach($categories as $data) {
                $categ = $data['categories_name'];

                $sql = "SELECT 
                            materials.mat_id,
                            materials.mat_name,
                            categories.categories_name,
                            matinfo.matinfo_prevStock,
                            unit.unit_name,
                            matinfo.currentQuantity,
                            categories.categories_id,
                            unit.unit_id,
                            matinfo.matinfo_id
                        FROM
                            materials
                        INNER JOIN 
                            categories ON materials.mat_categ = categories.categories_id
                        INNER JOIN 
                            unit ON materials.mat_unit = unit.unit_id
                        INNER JOIN
                            matinfo ON materials.mat_id = matinfo.matinfo_matname
                        WHERE 
                            categories.categories_name = '$categ' 
                        AND 
                            matinfo.matinfo_project = '$projects_id'
                        AND 
                            matinfo.matinfo_id = $mat
                        ORDER BY 1;";
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_row($result)){
                    $matinfo_id = $row[8];
                    echo "Matinfo_id: ".$matinfo_id."<br />";
                    $sql1 = "SELECT 
                                SUM(deliveredmat.deliveredmat_qty) 
                            FROM 
                                deliveredmat
                            WHERE 
                                deliveredmat.deliveredmat_materials = '$row[0]';";
                    $result1 = mysqli_query($conn, $sql1);
                    $row1 = mysqli_fetch_row($result1);
                    $sql_mat = "SELECT
                                    unit.unit_name,
                                    materials.mat_id
                                FROM
                                    materials
                                INNER JOIN
                                    unit ON unit.unit_id = materials.mat_unit
                                INNER JOIN
                                    matinfo ON matinfo.matinfo_matname = materials.mat_id
                                WHERE
                                    matinfo.matinfo_id = $matinfo_id;";
                    $result_mat = mysqli_query($conn, $sql_mat);
                    $mat_count_use = 0;
                    while ($row_mat = mysqli_fetch_row($result_mat)) {
                        
                        $sql_use = "SELECT
                                        requisition.requisition_date,
                                        reqmaterial.reqmaterial_qty,
                                        requisition.requisition_reqBy,
                                        reqmaterial.reqmaterial_areaOfUsage,
                                        requisition.requisition_remarks
                                    FROM
                                        requisition
                                    INNER JOIN
                                        reqmaterial ON reqmaterial.reqmaterial_requisition = requisition.requisition_id
                                    WHERE
                                        reqmaterial.reqmaterial_material = $row_mat[1];";
                        $result_use = mysqli_query($conn, $sql_use);
                        while ($row_use = mysqli_fetch_row($result_use)) {
                        $mat_count_use = $mat_count_use + $row_use[1];
                            }
                        $sql_use = "SELECT
                                        hauling.hauling_date,
                                        haulingmat.haulingmat_qty,
                                        hauling.hauling_requestedBy,
                                        hauling.hauling_deliverTo,
                                        hauling.hauling_status
                                    FROM
                                        hauling
                                    INNER JOIN
                                        haulingmat ON hauling.hauling_id = haulingmat.haulingmat_haulingid
                                    WHERE
                                        haulingmat.haulingmat_matname = $row_mat[1];";
                        $result_use = mysqli_query($conn, $sql_use);
                        while ($row_use = mysqli_fetch_row($result_use)) {
                        $mat_count_use = $mat_count_use + $row_use[1];
                            }
                    $mat_id = $row_mat[1];
                    $categ_id = $row[6];
                    $prev = $row[3];
                    $unit_id = $row[7];
                    $delivered = 0;
                    if ($row1[0] == NULL) {
                        $delivered = 0;
                    } else {
                        $delivered = $row1[0];
                    }
                    $use = $mat_count_use;
                    $accu = $delivered;
                    $qty = $phys;
                    $year = date("Y");
                    $month = date("n");

                    $stmt = $conn->prepare("INSERT INTO lastmatinfo (
                        lastmatinfo_matname, lastmatinfo_categ, lastmatinfo_prevStock, lastmatinfo_unit, 
                        lastmatinfo_deliveredMat, lastmatinfo_matPulledOut, lastmatinfo_accumulatedMat, 
                        lastmatinfo_matOnSite, lastmatinfo_project, lastmatinfo_year, lastmatinfo_month) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
                    $stmt->bind_param("iiiiiiiiiii", 
                    $mat_id, $categ_id, $prev, $unit_id, 
                    $delivered, $use, $accu, 
                    $qty, $projects_id, $year, $month);
                    $stmt->execute();
                    $stmt->close();
                    $stmt = $conn->prepare("UPDATE matinfo SET matinfo_prevStock = ?, currentQuantity = ? WHERE matinfo_id = ?;");
                    $stmt->bind_param("iii", $qty, $qty, $mat);
                    $stmt->execute();
                    $stmt->close();

                    $stmt = $conn->prepare("DELETE FROM reconciliation WHERE reconciliation_matinfo = ?");
                    $stmt->bind_param("i", $mat);
                    $stmt->execute();
                    $stmt->close();
                    }
                }
            }
        }
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/reconciliation.php");  
    }

    if (isset($_POST['reconciliation_save'])) {
        session_start();
        $difference = $_POST['difference'];
        $matinfo_id = $_POST['matinfo_id'];
        $systemCount = $_POST['system_Count'];
        $remarks = array();
        $x = 0;
        if (isset($_POST['remarks'])) {
            $remarks = $_POST['remarks'];
        }
        for ($ctr = 0; $ctr <= sizeof($difference)-1; $ctr++) {
            $dif = $difference[$ctr];
            $mat = $matinfo_id[$ctr];
            $sys = $systemCount[$ctr];
            $phys = $sys-$dif;
            $stmt = $conn->prepare("DELETE FROM reconciliation WHERE reconciliation_matinfo = ?");
            $stmt->bind_param("i", $mat);
            $stmt->execute();
            $stmt->close();

            if ($dif != 0) {
                $rem = $remarks[$x];
                $stmt = $conn->prepare("INSERT INTO reconciliation (reconciliation_physCount, reconciliation_matinfo, reconciliation_remarks) VALUES (?, ?, ?);");
                $stmt->bind_param("iis", $phys, $mat, $rem);
                $stmt->execute();
                $stmt->close();
                $x++;
            } else {
                $stmt = $conn->prepare("INSERT INTO reconciliation (reconciliation_physCount, reconciliation_matinfo) VALUES (?, ?);");
                $stmt->bind_param("ii", $phys, $mat);
                $stmt->execute();
                $stmt->close();
            }
        }
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/reconciliation.php");  
    }

    if (isset($_POST['reconciliation'])) {
        session_start();
        $projects_id = $_POST['projects_id'];
        $_SESSION['projects_id'] = $projects_id;
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/reconciliation.php");  
    }

    if (isset($_POST['create_disposalSlip'])) {
        $date = mysqli_real_escape_string($conn, $_POST['date']);
        $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
        $unit = mysqli_real_escape_string($conn, $_POST['unit']);
        $articles = mysqli_real_escape_string($conn, $_POST['articles']);
        $remarks = mysqli_real_escape_string($conn, $_POST['remarks']);

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

        $account_id = "";
        session_start();
        if(isset($_SESSION['account_id'])) {
            $account_id = $_SESSION['account_id'];
        }

        $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?,?,?);");
        $create_disp_date = date("Y-m-d G:i:s");
        $logs_message = 'Created Disposal Slip';
        $logs_of = $account_id;
        $stmt->bind_param("ssi", $create_disp_date, $logs_message, $logs_of);
        $stmt->execute();
        $stmt->close();
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/disposalslip.php");     
    }

    if (isset($_POST['create_category'])) {
        $categoryName = mysqli_real_escape_string($conn, $_POST['categoryName']);
        $category = $_POST['category'];

            for($x = 0; $x < sizeof($category); $x++){
                $stmt = $conn->prepare("INSERT INTO categories (categories_name)
                    VALUES (?);");
                $stmt->bind_param("s", $category[$x]);
                $stmt->execute();
                $stmt->close();
                
                }
            $account_id = "";
            session_start();
            if(isset($_SESSION['account_id'])) {
                $account_id = $_SESSION['account_id'];
            }
            $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?,?,?);");
            $create_categ_date = date("Y-m-d G:i:s");
            $logs_message = 'Created Category: '.$categoryName;
            $logs_of = $account_id;
            $stmt->bind_param("ssi", $create_categ_date, $logs_message, $logs_of);
            $stmt->execute();
            $stmt->close();
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/addingOfNewMaterials.php");     
    }

    if (isset($_POST['create_unit'])) {
        $unitName = mysqli_real_escape_string($conn, $_POST['unitName']);
        $units = $_POST['units'];

            for($x = 0; $x < sizeof($units); $x++){
                $stmt = $conn->prepare("INSERT INTO unit (unit_name)
                    VALUES (?);");
                $stmt->bind_param("s", $units[$x]);
                $stmt->execute();
                $stmt->close();
                
                }
            $account_id = "";
            session_start();
            if(isset($_SESSION['account_id'])) {
                $account_id = $_SESSION['account_id'];
            }
            $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?,?,?);");
            $create_unit_date = date("Y-m-d G:i:s");
            $logs_message = 'Created Unit: '.$unitName;
            $logs_of = $account_id;
            $stmt->bind_param("ssi", $create_unit_date, $logs_message, $logs_of);
            $stmt->execute();
            $stmt->close();
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/addingOfNewMaterials.php");     
    }

    if (isset($_POST['create_materials'])) {
        $categ = $_POST['categ'];
        $materials = $_POST['material'];
        $threshold = $_POST['threshold'];
        $unit = $_POST['unit'];
        $prevStock = 0;
        $proj = 1;
        $currentQuantity = 0;
        
        for($x = 0; $x < sizeof($materials); $x++){

            $stmt = $conn->prepare("SELECT categories_id FROM categories WHERE categories_name = ?;");
            $stmt->bind_param("s", $categ[$x]);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($categ_id[$x]);
            $stmt->fetch();
            
            $stmt = $conn->prepare("SELECT unit_id FROM unit WHERE unit_name = ?;");
            $stmt->bind_param("s", $unit[$x]);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($unit_id[$x]);
            $stmt->fetch();
                
            $stmt = $conn->prepare("INSERT INTO materials (mat_name, mat_categ, mat_unit)VALUES (?, ?, ?);");
            $stmt->bind_param("sii", $materials[$x], $categ_id[$x], $unit_id[$x]);
            $stmt->execute();
            $stmt->close();
            
            $stmt = $conn->prepare("SELECT mat_id FROM materials WHERE mat_name = ?;");
            $stmt->bind_param("s", $materials[$x]);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($mat_id[$x]);
            $stmt->fetch();
            
           $stmt = $conn->prepare("INSERT INTO matinfo (matinfo_prevStock, matinfo_project, matinfo_notif, currentQuantity, matinfo_matname)VALUES (?, ?, ?, ?, ?);");
            $stmt->bind_param("iiiii", $prevStock, $proj, $threshold[$x], $currentQuantity, $mat_id[$x]);
            $stmt->execute();
            $stmt->close(); 
        }
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/addingOfNewMaterials.php");     
    }

    if (isset($_POST['create_requisitionSlip'])) {
        $projName = mysqli_real_escape_string($conn, $_POST['projectName']);
        $reqNo = mysqli_real_escape_string($conn, $_POST['reqNo']);
        $date = mysqli_real_escape_string($conn, $_POST['date']);
        $remarks = mysqli_real_escape_string($conn, $_POST['remarks']);
        $quantity = $_POST['quantity'];
        $unit = $_POST['unit'];
        $particulars = $_POST['particulars'];
        $location = $_POST['location'];
        $requestedBy = mysqli_real_escape_string($conn, $_POST['requestedBy']);
        $approvedBy = mysqli_real_escape_string($conn, $_POST['approvedBy']);
        
        
        $stmt = $conn->prepare("INSERT INTO requisition (requisition_no, requisition_date, requisition_remarks, requisition_reqBy, requisition_approvedBy, requisition_project) VALUES (?, ?, ?, ?, ?, ?);");
        $stmt->bind_param("issssi", $reqNo, $date, $remarks, $requestedBy, $approvedBy, $projName);
        $stmt->execute();
        $stmt->close();
        
        $stmt = $conn->prepare("SELECT requisition_id FROM requisition WHERE requisition_no = ?;");
        $stmt->bind_param("i", $reqNo);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($requisition_id);
        $stmt->fetch();
        
        for($x = 0; $x < sizeof($particulars); $x++){
        $stmt = $conn->prepare("INSERT INTO reqmaterial (reqmaterial_requisition, reqmaterial_material, reqmaterial_qty, reqmaterial_areaOfUsage) VALUES (?, ?, ?, ?);");
        $stmt->bind_param("iiis", $requisition_id, $particulars[$x], $quantity[$x], $location[$x]);
        $stmt->execute();
        $stmt->close();

        $stmt = $conn->prepare("SELECT currentQuantity FROM matinfo WHERE matinfo_project = ? AND matinfo_matname = ?;");
        $stmt->bind_param("ii", $projName, $particulars[$x]);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($currentQuantity);
        $stmt->fetch();
        
        $newQuantity = $currentQuantity - $quantity[$x];

        $stmt = $conn->prepare("UPDATE matinfo SET currentQuantity= ? WHERE matinfo_project = ? AND matinfo_matname = ?;");
        $stmt->bind_param("iii", $newQuantity, $projName, $particulars[$x]);
        $stmt->execute();
        $stmt->close();
        }
        
        $account_id = "";
        session_start();
        if(isset($_SESSION['account_id'])) {
            $account_id = $_SESSION['account_id'];
        }

        $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?,?,?);");
        $create_requisition_date = date("Y-m-d G:i:s");
        $logs_message = 'Created Requisition Slip';
        $logs_of = $account_id;
        $stmt->bind_param("ssi", $create_requisition_date, $logs_message, $logs_of);
        $stmt->execute();
        $stmt->close();
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/viewTransactions.php");     
    }

    if (isset($_POST['create_hauling'])) {
        $formNo = mysqli_real_escape_string($conn, $_POST['formNo']);
        $date = mysqli_real_escape_string($conn, $_POST['date']);
        $deliverTo = mysqli_real_escape_string($conn, $_POST['deliverTo']);
        $hauledFrom = mysqli_real_escape_string($conn, $_POST['projectName']);
        $requestedBy = mysqli_real_escape_string($conn, $_POST['requestedBy']);
        $hauledBy = mysqli_real_escape_string($conn, $_POST['hauledBy']);
        $warehouseman = mysqli_real_escape_string($conn, $_POST['warehouseman']);
        $approvedBy = mysqli_real_escape_string($conn, $_POST['approvedBy']);
        $type = mysqli_real_escape_string($conn, $_POST['type']);
        $plateNo = mysqli_real_escape_string($conn, $_POST['plateNo']);
        $PORS = mysqli_real_escape_string($conn, $_POST['PORS']);
        $haulerID = mysqli_real_escape_string($conn, $_POST['haulerID']);
        $quantity = $_POST['quantity'];
        $unit = $_POST['unit'];
        $articles = $_POST['articles'];
        $status = mysqli_real_escape_string($conn, $_POST['status']);
            
        $stmt = $conn->prepare("INSERT INTO hauling (hauling_no, hauling_date, hauling_deliverTo, hauling_hauledFrom, hauling_hauledBy, hauling_requestedBy, hauling_warehouseman, hauling_approvedBy, hauling_truckDetailsType, hauling_truckDetailsPlateNo, hauling_truckDetailsPO, hauling_truckDetailsHaulerDR, hauling_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
        $stmt->bind_param("isssssssssiis", $formNo, $date, $deliverTo, $hauledFrom, $hauledBy, $requestedBy, $warehouseman, $approvedBy, $type, $plateNo, $PORS, $haulerID, $status);
        $stmt->execute();
        $stmt->close();
                            
        $stmt = $conn->prepare("SELECT unit_id FROM unit WHERE unit_name = ?;");
        $stmt->bind_param("i", $unit);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($unit_id);
        $stmt->fetch();
        
        $stmt = $conn->prepare("SELECT hauling_id FROM hauling WHERE hauling_no = ?;");
        $stmt->bind_param("i", $formNo);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($hauling_id);
        $stmt->fetch();
        
        for($x = 0; $x < sizeof($articles); $x++){
            $stmt = $conn->prepare("INSERT INTO haulingmat (haulingmat_haulingid, haulingmat_matname, haulingmat_qty, haulingmat_unit) VALUES (?, ?, ?, ?);");
            $stmt->bind_param("iiii", $hauling_id, $articles[$x], $quantity[$x], $unit[$x]);
            $stmt->execute();
            $stmt->close();
                
            $stmt = $conn->prepare("SELECT hauling_hauledFrom FROM hauling WHERE hauling_id = ?;");
            $stmt->bind_param("i", $hauling_id);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($project_id);
            $stmt->fetch();
            
            $stmt = $conn->prepare("SELECT currentQuantity FROM matinfo WHERE matinfo_project = ? AND matinfo_matname = ?;");
            $stmt->bind_param("ii", $project_id, $articles[$x]);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($currentQuantity);
            $stmt->fetch();
            
            $newQuantity = $currentQuantity - $quantity[$x];

            $stmt = $conn->prepare("UPDATE matinfo SET currentQuantity= ? WHERE matinfo_project = ? AND matinfo_matname = ?;");
            $stmt->bind_param("iii", $newQuantity, $project_id, $articles[$x]);
            $stmt->execute();
            $stmt->close();

            if (strcmp($status, "To be returned" ) == 0 ) {
                $returns_status = "Incomplete";
                $stmt = $conn->prepare("INSERT INTO returns (returns_hauling_no, returns_matname, returns_status) VALUES (?, ?, ?);");
                $stmt->bind_param("iis", $formNo, $articles[$x], $returns_status);
                $stmt->execute();
                $stmt->close();
            }
        }
        
        $account_id = "";
        session_start();
        if(isset($_SESSION['account_id'])) {
            $account_id = $_SESSION['account_id'];
        }
        
        $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?,?,?);");
        $create_haulingtobereturn_date = date("Y-m-d G:i:s");
        $logs_message = 'Created Hauling Form (To be Returned)';
        $logs_of = $account_id;
        $stmt->bind_param("ssi", $create_haulingtobereturn_date, $logs_message, $logs_of);
        $stmt->execute();
        $stmt->close();
        
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/hauleditems.php");
    }

    if (isset($_POST['update_account'])) {
        $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
        $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['confpass']);
        $edit_account_date = date("Y-m-d G:i:s");
        $account_id = "";
        session_start();
        if(isset($_SESSION['account_id'])) {
            $account_id = $_SESSION['account_id'];
        }

        if (isset($_POST['firstName']) && $_POST['firstName'] != null) {
            $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
            $stmt = $conn->prepare("UPDATE accounts SET accounts_fname = ? WHERE accounts_id = 1;");
            $stmt->bind_param("s", $firstName);
            $stmt->execute();
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
            $stmt->bind_param("ssi", $edit_account_date, $logs_message, $logs_of);
            $logs_message = 'Change first name to '.$firstName;
            $logs_of = $account_id;
            $stmt->execute();
            $stmt->close();
        }
        if (isset($_POST['lastName']) && $_POST['lastName'] != null) {
            $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
            $stmt = $conn->prepare("UPDATE accounts SET accounts_lname= ? WHERE accounts_id = 1;");
            $stmt->bind_param("s", $lastName);
            $stmt->execute();
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
            $stmt->bind_param("ssi", $edit_account_date, $logs_message, $logs_of);
            $logs_message = 'Change last name to '.$lastName;
            $logs_of = $account_id;
            $stmt->execute();
            $stmt->close();
        }
        if (isset($_POST['username']) && $_POST['username'] != null) {
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $stmt = $conn->prepare("UPDATE accounts SET accounts_username = ? WHERE accounts_id = 1;");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->close();
           $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
            $stmt->bind_param("ssi", $edit_account_date, $logs_message, $logs_of);
            $logs_message = 'Change username to '.$username;
            $logs_of = $account_id;
            $stmt->execute();
            $stmt->close();
        }
        if (isset($_POST['email']) && $_POST['email'] != null) {
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $stmt = $conn->prepare("UPDATE accounts SET accounts_email = ? WHERE accounts_id = 1;");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
            $stmt->bind_param("ssi", $edit_account_date, $logs_message, $logs_of);
            $logs_message = 'Change email to '.$email;
            $logs_of = $account_id;
            $stmt->execute();
            $stmt->close();
        }
        
        if (isset($_POST['confpass']) && $_POST['confpass'] != null) {
            $password = mysqli_real_escape_string($conn, $_POST['confpass']);
            $hash_password = password_hash($password, PASSWORD_DEFAULT);
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
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/account.php");     
    }

    if (isset($_POST['edit_category'])) {
        $newCategName = mysqli_real_escape_string($conn, $_POST['newCategName']);
        $categ_id = mysqli_real_escape_string($conn, $_POST['categ_id']);
        
        $stmt = $conn->prepare("UPDATE categories SET categories_name = ? WHERE categories_id = ?;");
        $stmt->bind_param("si", $newCategName, $categ_id);
        $stmt->execute();
        $stmt->close();
        
        $edit_categ_date = date("Y-m-d G:i:s");
        $account_id = "";
        session_start();
        if(isset($_SESSION['account_id'])) {
            $account_id = $_SESSION['account_id'];
        }
        $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
        $stmt->bind_param("ssi", $edit_categ_date, $logs_message, $logs_of);
        $logs_message = 'Edited category to '.$newCategName;
        $logs_of = $account_id;
        $stmt->execute();
        $stmt->close();
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/addingOfNewMaterials.php");     
    }

    if (isset($_POST['edit_unit'])) {
        $unit_name = mysqli_real_escape_string($conn, $_POST['unit_name']);
        $unit_id = mysqli_real_escape_string($conn, $_POST['unit_id']);
        
        $stmt = $conn->prepare("UPDATE unit SET unit_name = ? WHERE unit_id = ?;");
        $stmt->bind_param("si", $unit_name, $unit_id);
        $stmt->execute();
        $stmt->close();
    
        $edit_unit_date = date("Y-m-d G:i:s");
        $account_id = "";
        session_start();
        if(isset($_SESSION['account_id'])) {
            $account_id = $_SESSION['account_id'];
        }
        $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
        $stmt->bind_param("ssi", $edit_unit_date, $logs_message, $logs_of);
        $logs_message = 'Edited unit to '.$unit_name;
        $logs_of = $account_id;
        $stmt->execute();
        $stmt->close();
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/addingOfNewMaterials.php");     
    }

    if (isset($_POST['edit_threshold'])) {
        $matinfo_id = mysqli_real_escape_string($conn, $_POST['matinfo_id']);
        $threshold = mysqli_real_escape_string($conn, $_POST['threshold']);
        $proj_id = mysqli_real_escape_string($conn, $_POST['proj_id']);
        
        
        $stmt = $conn->prepare("UPDATE matinfo SET matinfo_notif = ? WHERE matinfo_id = ?;");
        $stmt->bind_param("ii", $threshold, $matinfo_id);
        $stmt->execute();
        $stmt->close();
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/addMaterials.php");     
    }

    if (isset($_POST['edit_material'])) {
            $newCategory = mysqli_real_escape_string($conn, $_POST['newCategory']);
            $newMatName = mysqli_real_escape_string($conn, $_POST['newMatName']);
            $newUnit = mysqli_real_escape_string($conn, $_POST['newUnit']);
            $mat_id = mysqli_real_escape_string($conn, $_POST['mat_id']);  
        
            if(isset($_POST['newCategory'])) {
            $stmt = $conn->prepare("UPDATE materials SET mat_categ = ? WHERE mat_id = ?;");
            $stmt->bind_param("si", $newCategory, $mat_id);
            $stmt->execute();
            $stmt->close();
            }
        
            if(isset($_POST['newUnit'])) {
            $stmt = $conn->prepare("UPDATE materials SET mat_unit = ? WHERE mat_id = ?;");
            $stmt->bind_param("si", $newUnit, $mat_id);
            $stmt->execute();
            $stmt->close();
            }
        
            if(isset($_POST['newMatName'])) {
            $stmt = $conn->prepare("UPDATE materials SET mat_name = ? WHERE mat_id = ?;");
            $stmt->bind_param("si", $newMatName, $mat_id);
            $stmt->execute();
            $stmt->close();
            }

        
/*         $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
            $stmt->bind_param("ssi", $edit_account_date, $logs_message, $logs_of);
            $logs_message = 'Change email to '.$newemail;
            $logs_of = $account_id;
            $stmt->execute();
            $stmt->close();*/
       header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/addingOfNewMaterials.php");     
    }

    if (isset($_POST['create_deliveredin'])) {
        $projectName = mysqli_real_escape_string($conn, $_POST['projectName']);
        $date = mysqli_real_escape_string($conn, $_POST['deliveredDate']);
        $remarks = mysqli_real_escape_string($conn, $_POST['remarks']);
        $receiptNo = mysqli_real_escape_string($conn, $_POST['resibo']);
        $quantity = $_POST['quantity'];
        $unit = $_POST['unit'];
        $articles = $_POST['articles'];
        $suppliedBy = $_POST['suppliedBy'];
        echo $receiptNo;

        $stmt = $conn->prepare("INSERT INTO deliveredin (deliveredin_date, deliveredin_remarks, deliveredin_receiptno, deliveredin_project) VALUES (?, ?, ?, ?);");
        $stmt->bind_param("sssi", $date, $remarks, $receiptNo, $projectName);
        $stmt->execute();
        $stmt->close();  
        
        $stmt = $conn->prepare("SELECT deliveredin_id FROM deliveredin WHERE deliveredin_receiptno = ?;");
        $stmt->bind_param("i", $receiptNo);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($deliveredin_id);
        $stmt->fetch();
        
        for($x = 0; $x < sizeof($articles); $x++){
                
        $stmt = $conn->prepare("INSERT INTO deliveredmat (deliveredmat_deliveredin, deliveredmat_materials, deliveredmat_qty, suppliedBy) VALUES (?, ?, ?, ?);");
        $stmt->bind_param("iiis", $deliveredin_id, $articles[$x], $quantity[$x], $suppliedBy[$x]);
        $stmt->execute();
        $stmt->close();
            
        $stmt = $conn->prepare("SELECT currentQuantity FROM matinfo WHERE matinfo_project = ? AND  matinfo_matname = ?;");
        $stmt->bind_param("ii", $projectName, $articles[$x]);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($currentQuantity);
        $stmt->fetch();
            
        $newQuantity = $currentQuantity + $quantity[$x];
            
        $stmt = $conn->prepare("UPDATE matinfo SET currentQuantity = ? WHERE matinfo_project = ? AND  matinfo_matname = ?;");
        $stmt->bind_param("iii", $newQuantity, $projectName, $articles[$x]);
        $stmt->execute();
        $stmt->close();
            
        }

        $account_id = "";
        session_start();
        if(isset($_SESSION['account_id'])) {
            $account_id = $_SESSION['account_id'];
        }

        $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?,?,?);");
        $create_deliveredin_date = date("Y-m-d G:i:s");
        $logs_message = 'Created Delivered-In';
        $logs_of = $account_id;
        $stmt->bind_param("ssi", $create_deliveredin_date, $logs_message, $logs_of);
        $stmt->execute();
        $stmt->close();
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/viewTransactions.php");   
    }

    if (isset($_POST['create_todo'])) {
        session_start();
        $account_id = "";
        if (isset($_SESSION['account_id'])) {
            $account_id = $_SESSION['account_id'];
        }
        $todo_date = mysqli_real_escape_string($conn, $_POST['todo_date']);
        $todo_task = mysqli_real_escape_string($conn, $_POST['todo_task']);
        echo $todo_task;
        $todo_status = "in progress";
        $stmt = $conn->prepare("INSERT INTO todo (todo_date, todo_task, todo_status, todoOf) VALUES (?, ?, ?, ?);");
        $stmt->bind_param("sssi", $todo_date, $todo_task, $todo_status, $account_id);
        $stmt->execute();
        $stmt->close();

        $create_todo_date = date("Y-m-d G:i:s");
        $logs_message = 'Created todo task'.$todo_task;
        $logs_of = $account_id;
        $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
        $stmt->bind_param("ssi", $create_todo_date, $logs_message, $logs_of);
        $stmt->execute();
        $stmt->close();
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/dashboard.php");     
    }

    if (isset($_POST['open_returns'])) {
        $hauling_no = mysqli_real_escape_string($conn, $_POST['hauling_no']);
        session_start();
        $_SESSION['hauling_no'] = $hauling_no;
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/returnHauledMaterial.php");     
    }

    if (isset($_POST['view_hauling'])) {
        $hauling_no = mysqli_real_escape_string($conn, $_POST['hauling_no']);
        session_start();
        $_SESSION['hauling_no'] = $hauling_no;
        echo $_SESSION['hauling_no'];
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/viewhaulingreceipt.php");     
    }

    if (isset($_POST['open_deliveredin'])) {
        $delivered_id = mysqli_real_escape_string($conn, $_POST['delivered_id']);
        $receipt_no = mysqli_real_escape_string($conn, $_POST['receipt_no']);
        session_start();
        $_SESSION['delivered_id'] = $delivered_id;
        $_SESSION['receipt_no'] = $receipt_no;
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/viewdeliveredin.php");     
    }

    if (isset($_POST['open_requisition'])) {
        $req_no = mysqli_real_escape_string($conn, $_POST['req_no']);
        $req_id = mysqli_real_escape_string($conn, $_POST['req_id']);
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/viewrequisitionslip.php?requisition_no=$req_no&requisition_id=$req_id");     
    }


    if (isset($_POST['adding_materials'])) {

        $matName = $_POST['matName'];
        $prevStock = 0;
        $notif = 0;
        $currentQuantity = 0;
        $project = mysqli_real_escape_string($conn, $_POST['proj_id']);;
        
   
        for($x = 0; $x < sizeof($matName); $x++){
            
            $stmt = $conn->prepare("INSERT INTO matinfo (matinfo_prevStock, matinfo_project, matinfo_notif, currentQuantity, matinfo_matname) VALUES (?, ?, ?, ?, ?);");
            $stmt->bind_param("iiiii", $prevStock, $project, $notif, $currentQuantity, $matName[$x]);
            $stmt->execute();
            $stmt->close();
        }
        
        
/*        $account_id = "";
        session_start();
        if(isset($_SESSION['account_id'])) {
            $account_id = $_SESSION['account_id'];
        }
        $materialName = mysqli_real_escape_string($conn, $_POST['materialName']);
        $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?,?,?);");
        $create_mat_date = date("Y-m-d G:i:s");
        $logs_message = 'Created Material: '.$materialName;
        $logs_of = $account_id;
        $stmt->bind_param("ssi", $create_mat_date, $logs_message, $logs_of);
        $stmt->execute();
        $stmt->close();*/
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/addmaterials.php?projects_id=$project");
    }

    if (isset($_POST['update_todo'])) {
        $todo_id = $_POST['todo_id'];
        $todo_status = $_POST['todo_status'];
        $todo_task = $_POST['todo_task'];
        session_start();
        $account_id = "";
        if (isset($_SESSION['account_id'])) {
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

    if (isset($_POST['update_todo_all'])) {
        $todo_id = $_POST['todo_id'];
        $todo_status = $_POST['todo_status'];
        $todo_task = $_POST['todo_task'];
        session_start();
        $account_id = "";
        echo $todo_id;
        if (isset($_SESSION['account_id'])) {
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
        header("location: http://127.0.0.1/NGCBDC/Materials%20Engineer/viewalltasks.php");    
    }

    if (isset($_POST['edit_account'])) {
        $username = mysqli_real_escape_string($conn, $_POST['userid']);
        session_start();
        $account_id = "";
        if (isset($_SESSION['account_id'])) {
            $account_id = $_SESSION['account_id'];
        }
        $edit_account_date = date("Y-m-d G:i:s");
        if (isset($_POST['newusername']) && $_POST['newusername'] != null) {
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
        if (isset($_POST['newfname']) && $_POST['newfname'] != null) {
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

        if (isset($_POST['newlname']) && $_POST['newlname'] != null) {
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

        if (isset($_POST['newemail']) && $_POST['newemail'] != null) {
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
        
        if (isset($_POST['newpassword']) && $_POST['newpassword'] != null) {
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
        header("location: http://127.0.0.1/NGCBDC/Materials%20Engineer/account.php");        
    }

    if (isset($_POST['viewInventory'])) {
        $projects_id = $_POST['projects_id'];
        session_start();
        $_SESSION['projects_id'] = $projects_id;
        $accounts_id = $_SESSION['account_id'];   
        $sql = "SELECT
                    accounts_type
                FROM
                    accounts
                WHERE 
                    accounts_id = $accounts_id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_row($result);
        
        if (strcmp($row[0], "Materials Engineer") == 0) {
            header("location: http://127.0.0.1/NGCBDC/Materials%20Engineer/viewinventory.php");    
        } else {
            header("location: http://127.0.0.1/NGCBDC/View%20Only/viewinventory.php");    
        }
    }

    if (isset($_POST['addMaterials'])) {
        $projects_id = $_POST['projects_id'];
        session_start();
        $_SESSION['projects_id'] = $projects_id;
        $accounts_id = $_SESSION['account_id'];   
        $sql = "SELECT
                    accounts_type
                FROM
                    accounts
                WHERE 
                    accounts_id = $accounts_id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_row($result);
        
        if (strcmp($row[0], "Materials Engineer") == 0) {
            header("location: http://127.0.0.1/NGCBDC/Materials%20Engineer/addMaterials.php");    
        } else {
            header("location: http://127.0.0.1/NGCBDC/View%20Only/addMaterials.php");    
        }
    }

    if (isset($_POST['prevViewInventory'])) {
        $projects_id = $_POST['projects_id'];
        session_start();
        $_SESSION['projects_id'] = $projects_id;
        header("location: http://127.0.0.1/NGCBDC/Materials%20Engineer/previousReportsPage.php");    
    }

    if (isset($_POST['viewPrevReport'])) {
        $projects_id = $_POST['projects_id'];
        $lastmatinfo_month = $_POST['lastmatinfo_month'];
        $lastmatinfo_year = $_POST['lastmatinfo_year'];
        session_start();
        $_SESSION['lastmatinfo_month'] = $lastmatinfo_month;
        $_SESSION['lastmatinfo_year'] = $lastmatinfo_year;
        header("location: http://127.0.0.1/NGCBDC/Materials%20Engineer/viewPreviousReport.php");    
    }
    

    if (isset($_POST['curViewInventory'])) {
        $projects_id = $_POST['projects_id'];
        session_start();
        $_SESSION['projects_id'] = $projects_id;
        header("location: http://127.0.0.1/NGCBDC/Materials%20Engineer/currentReportPage.php");    
    }
    
    if (isset($_POST['return_hauling'])) {
        
        session_start();
        $hauling_no = $_SESSION['hauling_no'];
        $returningQuantity = mysqli_real_escape_string($conn, $_POST['returningQuantity']);
        $returns_id = $_POST['returns_id']; 
        $date_today = date("Y-m-d");
        $stmt = $conn->prepare("INSERT INTO returnhistory (returns_id, returnhistory_date, returnhistory_returningqty) VALUES (?, ?, ?);");
        $stmt->bind_param("isi", $returns_id, $date_today, $returningQuantity);
        $stmt->execute();
        $stmt->close();
        

        $stmt = $conn->prepare("SELECT hauling.hauling_hauledFrom, returns.returns_matname, hauling.hauling_id FROM returns INNER JOIN hauling ON returns.returns_hauling_no = hauling.hauling_no WHERE returns.returns_id = ?");
        $stmt->bind_param("i", $hauling_no);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($hauling_hauledFrom, $returns_matname, $hauling_id);
        $stmt->fetch();

        $stmt = $conn->prepare("SELECT currentQuantity FROM matinfo WHERE matinfo_project = ? AND matinfo_matname = ?;");
        $stmt->bind_param("ii", $hauling_hauledFrom, $returns_matname);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($currentQuantity);
        $stmt->fetch();
        
        $currentQuantity = $currentQuantity +$returningQuantity;

        $stmt = $conn->prepare("UPDATE matinfo SET currentQuantity= ? WHERE matinfo_project = ? AND matinfo_matname = ?;");
        $stmt->bind_param("iii", $currentQuantity, $hauling_hauledFrom, $returns_matname);
        $stmt->execute();
        $stmt->close();

        $stmt = $conn->prepare("SELECT haulingmat.haulingmat_qty FROM hauling INNER JOIN haulingmat ON hauling.hauling_id = haulingmat.haulingmat_haulingid WHERE hauling.hauling_no = ?");
        $stmt->bind_param("i", $hauling_no);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($haulingmat_qty);
        $stmt->fetch();

        $stmt = $conn->prepare("SELECT SUM(returnhistory_returningqty) FROM returnhistory WHERE returns_id = ?");
        $stmt->bind_param("i", $returns_id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($returnhistory_returningqty);
        $stmt->fetch();

        echo $haulingmat_qty."<br />";   
        echo $returnhistory_returningqty."<br />";   
        
        if ($haulingmat_qty <= $returnhistory_returningqty) {
            $returns_status = "Complete";
            $stmt = $conn->prepare("UPDATE returns SET returns_status= ? WHERE returns_hauling_no = ?;");
            $stmt->bind_param("si", $returns_status, $hauling_no);
            $s = $stmt->execute();
            $stmt->close();
        }

        // header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/returnHauledMaterial.php");     
    }

    if (isset($_POST['materialCategories'])) {
        $categories_id = $_POST['categories_id'];

        session_start();

        $_SESSION['categories_id'] = $categories_id;
        $accounts_id = $_SESSION['account_id'];   
        $sql = "SELECT
                    accounts_type
                FROM
                    accounts
                WHERE 
                    accounts_id = $accounts_id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_row($result);
        
        if (strcmp($row[0], "Materials Engineer") == 0) {
            header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/materialCategories.php");  
        } else {
            header("location: http://127.0.0.1/NGCBDC/View%20Only/materialCategories.php");  
        }    
    }

    // API
    header("Access-Control-Allow-Origin: *");
    if (isset($_GET['mat_name'])) {
        $name = $_GET['mat_name'];
        $sql = "SELECT unit.unit_id, unit.unit_name FROM materials INNER JOIN unit ON materials.mat_unit = unit.unit_id WHERE mat_id = '$name'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_all($result);
        echo json_encode($row);
    }


    if (isset($_GET['project_id'])) {
        $id = $_GET['project_id'];
        $sql = "SELECT matinfo.matinfo_matname, materials.mat_name FROM matinfo INNER JOIN materials ON matinfo_matname = materials.mat_id WHERE matinfo_project = $id;";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_all($result);
        echo json_encode($row);
    }


    if (isset($_GET['projects_id'])) {
        $id = $_GET['projects_id'];
        $sql = "SELECT projects_address FROM projects WHERE projects_id= $id;";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_all($result);
        echo json_encode($row);
    }

     

// <--View Only-->
?>
