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
            $stmt->bind_param("ssssssss", $firstName, $lastName, $username, $generated_password, $accountType, $email, $accountsDeletable, $accountsStatus);
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
        $accept_date = date("Y-m-d G:i:s");
        $stmt = $conn->prepare("UPDATE accounts SET accounts_password = ? WHERE accounts_id = ?;");
        $stmt->bind_param("si", $password, $request_accountID);
        $stmt->execute();
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
        $stmt->bind_param("ssi", $accept_date, $logs_message, $logs_of);
        $logs_message = 'Accepted request to reset password of '.$request_name;
        $logs_of = 2;
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
            $projects_id = mysqli_real_escape_string($conn, $_POST['projects_id']);
            $stmt = $conn->prepare("DELETE FROM projmateng WHERE projmateng_project = ?;");
            $stmt->bind_param("i", $projects_id);
            $stmt->execute();
            $stmt->close();
            
            echo var_dump($mateng);
    
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
        $reqNo = mysqli_real_escape_string($conn, $_POST['reqNo']);
        $date = mysqli_real_escape_string($conn, $_POST['date']);
        $remarks = mysqli_real_escape_string($conn, $_POST['remarks']);
        $quantity = $_POST['quantity'];
        $unit = $_POST['unit'];
        $particulars = $_POST['particulars'];
        $location = $_POST['location'];
        $requestedBy = mysqli_real_escape_string($conn, $_POST['requestedBy']);
        $approvedBy = mysqli_real_escape_string($conn, $_POST['approvedBy']);
        
        
        $stmt = $conn->prepare("INSERT INTO requisition (requisition_no, requisition_date, requisition_remarks, requisition_reqBy, requisition_approvedBy) VALUES (?, ?, ?, ?, ?);");
        $stmt->bind_param("issss", $reqNo, $date, $remarks, $requestedBy, $approvedBy);
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
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/requisitionslip.php");     
    }

    if (isset($_POST['create_toBeReturnedHauling'])) {
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
        $status = "To be returned";
                            
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
            
        $stmt = $conn->prepare("INSERT INTO hauling (hauling_no, hauling_date, hauling_deliverTo, hauling_hauledFrom, hauling_quantity, hauling_unit, hauling_matname, hauling_hauledBy, hauling_requestedBy, hauling_warehouseman, hauling_approvedBy, hauling_truckDetailsType, hauling_truckDetailsPlateNo, hauling_truckDetailsPO, hauling_truckDetailsHaulerDR, hauling_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
        $stmt->bind_param("isssiiissssssiis", $formNo, $date, $deliverTo, $hauledFrom, $quantity, $unit_id, $mat_id, $hauledBy, $requestedBy, $warehouseman, $approvedBy, $type, $plateNo, $PORS, $haulerID, $status);
        $stmt->execute();
        $stmt->close();

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
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/fillouthauling.php");
    }

    if (isset($_POST['create_permanentHauling'])) {
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
        $status = "Permanently Hauled";
                            
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
            
        $stmt = $conn->prepare("INSERT INTO hauling (hauling_no, hauling_date, hauling_deliverTo, hauling_hauledFrom, hauling_quantity, hauling_unit, hauling_matname, hauling_hauledBy, hauling_requestedBy, hauling_warehouseman, hauling_approvedBy, hauling_truckDetailsType, hauling_truckDetailsPlateNo, hauling_truckDetailsPO, hauling_truckDetailsHaulerDR, hauling_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
        $stmt->bind_param("isssiiissssssiis", $formNo, $date, $deliverTo, $hauledFrom, $quantity, $unit_id, $mat_id, $hauledBy, $requestedBy, $warehouseman, $approvedBy, $type, $plateNo, $PORS, $haulerID, $status);
        $stmt->execute();
        $stmt->close();

        $account_id = "";
        session_start();
        if(isset($_SESSION['account_id'])) {
            $account_id = $_SESSION['account_id'];
        }

        $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?,?,?);");
        $create_haulingpermanent_date = date("Y-m-d G:i:s");
        $logs_message = 'Created Hauling Form (Permanently Hauled)';
        $logs_of = $account_id;
        $stmt->bind_param("ssi", $create_haulingpermanent_date, $logs_message, $logs_of);
        $stmt->execute();
        $stmt->close();
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/fillouthauling.php");     
    }

    if (isset($_POST['update_account'])) {
        $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
        $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
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
        
        if (isset($_POST['password']) && $_POST['password'] != null) {
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $hash_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE accounts SET accounts_password = ? WHERE accounts_id = 1;");
            $stmt->bind_param("s", $hash_password);
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

    if (isset($_POST['edit_material'])) {
            $newCategory = mysqli_real_escape_string($conn, $_POST['newCategory']);
            $newMatName = mysqli_real_escape_string($conn, $_POST['newMatName']);
            $newThreshold = mysqli_real_escape_string($conn, $_POST['newThreshold']);
            $newUnit = mysqli_real_escape_string($conn, $_POST['newUnit']);
            $matinfo_id = mysqli_real_escape_string($conn, $_POST['matinfo_id']);
            
            $stmt = $conn->prepare("UPDATE materials SET mat_categ = ? WHERE mat_id = ?;");
            $stmt->bind_param("si", $newCategory, $mat_id);
            $stmt->execute();
            $stmt->close();
        
            $stmt = $conn->prepare("UPDATE materials SET mat_unit = ? WHERE mat_id = ?;");
            $stmt->bind_param("si", $newUnit, $mat_id);
            $stmt->execute();
            $stmt->close();
        
            $stmt = $conn->prepare("UPDATE materials SET mat_name = ? WHERE mat_id = ?;");
            $stmt->bind_param("si", $newMatName, $mat_id);
            $stmt->execute();
            $stmt->close();


            $stmt = $conn->prepare("UPDATE matinfo SET matinfo_notif = ? WHERE matinfo_id = ?;");
            $stmt->bind_param("si", $newThreshold, $matinfo_id);
            $stmt->execute();
            $stmt->close();
        
/*         $stmt = $conn->prepare("INSERT INTO logs (logs_datetime, logs_activity, logs_logsOf) VALUES (?, ?, ?);");
            $stmt->bind_param("ssi", $edit_account_date, $logs_message, $logs_of);
            $logs_message = 'Change email to '.$newemail;
            $logs_of = $account_id;
            $stmt->execute();
            $stmt->close();*/
       header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/addingOfNewMaterials.php");     
    }

    if (isset($_POST['create_deliveredin'])) {
        $date = mysqli_real_escape_string($conn, $_POST['deliveredDate']);
        $remarks = mysqli_real_escape_string($conn, $_POST['remarks']);
        $receiptNo = mysqli_real_escape_string($conn, $_POST['resibo']);
        $quantity = $_POST['quantity'];
        $unit = $_POST['unit'];
        $articles = $_POST['articles'];
        $suppliedBy = $_POST['suppliedBy'];

        $stmt = $conn->prepare("INSERT INTO deliveredin (deliveredin_date, deliveredin_remarks, deliveredin_receiptno) VALUES (?, ?, ?);");
        $stmt->bind_param("ssi", $date, $remarks, $receiptNo);
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
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/deliveredin.php");   
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
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/returnHauledMaterial.php?hauling_no=$hauling_no");     
    }

    if (isset($_POST['adding_materials'])) {

        $matName = $_POST['matName'];
        $prevStock = 0;
        $notif = 50;
        $currentQuantity = 0;
        $project = 1;
        
        for($x = 0; $x < sizeof($matName); $x++){
            
            $stmt = $conn->prepare("INSERT INTO matinfo (matinfo_prevStock, matinfo_project, matinfo_notif, currentQuantity, matinfo_matname)   VALUES (?, ?, ?, ?, ?);");
            $stmt->bind_param("iiiii", $prevStock, $project, $notif, $currentQuantity, $matName[$x]);
            $stmt->execute();
            $stmt->close();
        }
        $account_id = "";
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
        $stmt->close();
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/addmaterials.php");
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
            header("location: http://127.0.0.1/NGCBDC/Materials%20Engineer/viewinventory.php?projects_id=$projects_id");    
        } else {
            header("location: http://127.0.0.1/NGCBDC/View%20Only/viewinventory.php?projects_id=$projects_id");    
        }
    }

    if (isset($_POST['prevViewInventory'])) {
        $projects_id = $_POST['projects_id'];
        session_start();
        $_SESSION['prevProjects'] = $projects_id;
        header("location: http://127.0.0.1/NGCBDC/Materials%20Engineer/previousReportsPage.php");    
    }

    if (isset($_POST['viewPrevReport'])) {
        $projects_id = $_POST['projects_id'];
        $lastmatinfo_month = $_POST['lastmatinfo_month'];
        $lastmatinfo_year = $_POST['lastmatinfo_year'];
        header("location: http://127.0.0.1/NGCBDC/Materials%20Engineer/viewPreviousReport.php?projects_id=$projects_id&lastmatinfo_month=$lastmatinfo_month&lastmatinfo_year=$lastmatinfo_year");    
    }
    

    if (isset($_POST['curViewInventory'])) {
        $projects_id = $_POST['projects_id'];
        header("location: http://127.0.0.1/NGCBDC/Materials%20Engineer/currentReportPage.php?projects_id=$projects_id");    
    }
    
    if (isset($_POST['return_hauling'])) {
        
        $returningQuantity = mysqli_real_escape_string($conn, $_POST['returningQuantity']);

        $stmt = $conn->prepare("SELECT return_returnedqty FROM returns WHERE return_id = 1;");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($currentReturnedQty);
        $stmt->fetch();
        $newQuantity = $returningQuantity+$currentReturnedQty;
        $stmt = $conn->prepare("UPDATE returns SET return_returnedqty = ? WHERE return_id = 1;");
        $stmt->bind_param("i", $newQuantity);
        $stmt->execute();
        $stmt->close();
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/returns.php");     
    }

    if (isset($_POST['materialCategories'])) {
        $categories_id = $_POST['categories_id'];
        $projects_id = $_POST['projects_id'];

        session_start();

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
            header("location: http://127.0.0.1/NGCBDC/Materials%20Engineer/materialCategories.php?projects_id=$projects_id&categories_id=$categories_id"); 
        } else {
            header("location: http://127.0.0.1/NGCBDC/View%20Only/materialCategories.php?projects_id=$projects_id&categories_id=$categories_id");  
        }    
    }

// <--View Only-->
?>
