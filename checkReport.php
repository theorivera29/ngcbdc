<?php
    $sql = "SELECT
                CONCAT(lastmatinfo_month, lastmatinfo_year)
            FROM
                lastmatinfo;";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_row($result);
    $date = $row[0];
    $date_today = date("nY");
    if ($date != $date_today) {
        if ($date < $date_today) {
        // $sql_project = "SELECT DISTINCT
        //                 projects_id
        //             FROM
        //                 projects;";
        // $result = mysqli_query($conn, $sql_project);
        // $project = array(); 
        // while($row_project = mysqli_fetch_assoc($result)){
        //     $project[] = $row_project;
        // }
        // foreach($project as $data_proj) {
        //     $projects_id = $data_proj['projects_id'];

        //     $sql_categ = "SELECT DISTINCT
        //                     categories_name
        //                 FROM
        //                     materials
        //                 INNER JOIN
        //                     categories ON categories.categories_id = materials.mat_categ
        //                 INNER JOIN
        //                     matinfo ON materials.mat_id = matinfo.matinfo_matname
        //                 WHERE
        //                     matinfo.matinfo_project = $projects_id;";
        //     $result = mysqli_query($conn, $sql_categ);
        //     $categories = array();
        //     while($row_categ = mysqli_fetch_assoc($result)){
        //         $categories[] = $row_categ;
        //     }
        //     foreach($categories as $data) {
        //         $categ = $data['categories_name'];
        //         $sql = "SELECT 
        //                     materials.mat_id,
        //                     materials.mat_name,
        //                     categories.categories_id,
        //                     matinfo.matinfo_prevStock,
        //                     unit.unit_id
        //                 FROM
        //                     materials
        //                 INNER JOIN 
        //                     categories ON materials.mat_categ = categories.categories_id
        //                 INNER JOIN 
        //                     unit ON materials.mat_unit = unit.unit_id
        //                 INNER JOIN
        //                     matinfo ON materials.mat_id = matinfo.matinfo_matname
        //                 WHERE 
        //                     categories.categories_name = '$categ' 
        //                 AND 
        //                 matinfo.matinfo_project = '$projects_id'
        //                 ORDER BY 1;";
        //         $result = mysqli_query($conn, $sql);
        //         while($row = mysqli_fetch_row($result)){
        //             $sql1 = "SELECT 
        //                         SUM(deliveredin.deliveredin_quantity) FROM deliveredin
        //                     INNER JOIN 
        //                         matinfo ON deliveredin.deliveredin_matname = matinfo.matinfo_matname
        //                     WHERE 
        //                         matinfo.matinfo_matname = '$row[0]';";
        //             $result1 = mysqli_query($conn, $sql1);
        //             $row1 = mysqli_fetch_row($result1);
        //             $sql2 = "SELECT 
        //                         SUM(usagein.usagein_quantity) FROM usagein
        //                         INNER JOIN 
        //                         matinfo ON usagein.usagein_matname = matinfo.matinfo_matname
        //                     WHERE 
        //                         matinfo.matinfo_matname = '$row[0]';";
        //             $result2 = mysqli_query($conn, $sql2);
        //             $row2 = mysqli_fetch_row($result2);
        //             $sql3 = "SELECT 
        //                         projects_id FROM projects
        //                         INNER JOIN 
        //                         matinfo ON matinfo.matinfo_project = projects.projects_id
        //                     WHERE 
        //                         matinfo.matinfo_matname = '$row[0]';";
        //             $result3 = mysqli_query($conn, $sql3);
        //             $row3 = mysqli_fetch_row($result3);

        //             $mat_name = $row[0];
        //             $mat_categ = $row[2];
        //             $matinfo_prevStock = $row[3];
        //             $unit_name = $row[4];
        //             if($row1[0] == null ){
        //                         $deliveredin_quantity = 0;
        //                     } else {
        //                         $deliveredin_quantity = $row1[0];
        //                     }
        //             if($row2[0] == null ){
        //                         $usagein_quantity = 0;
        //                     } else {
        //                         $usagein_quantity = $row2[0];
        //                     }
        //             $accumulated = $row[3]+$row1[0];
        //             $mat_on_site = $row[3]+$row1[0]-$row2[0];
        //             $project = $row3[0];
        //             $year = date("Y");
        //             $month = date("n");
                    
        //             $stmt = $conn->prepare("INSERT INTO lastmatinfo (lastmatinfo_matname, lastmatinfo_categ, lastmatinfo_prevStock, lastmatinfo_unit, lastmatinfo_deliveredMat, lastmatinfo_matPulledOut, lastmatinfo_accumulatedMat, lastmatinfo_matOnSite, lastmatinfo_project, lastmatinfo_year, lastmatinfo_month) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
        //             $stmt->bind_param("iiiiiiiiiii", $mat_name, $mat_categ, $matinfo_prevStock, $unit_name, $deliveredin_quantity, $usagein_quantity, $accumulated, $mat_on_site, $project, $year, $month);
        //             $stmt->execute();
        //         }
        //     }
        // }
        }
    }
?>