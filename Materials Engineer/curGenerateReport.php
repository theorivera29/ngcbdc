<?php
    include '../fpdf/fpdf.php';
    include "../db_connection.php";
    session_start();

    //INITIALIZATION OF FPDF OBJECT
    $pdf = new FPDF();
    $pdf->AddPage();
    
    //PAGE TITLE
    $pdf->SetFont('Times','B',16);
    $pdf->Cell(0,10,'NEW GOLDEN CITY BUILDERS AND DEVELOPMENT',0,1,'C');
    $pdf->Cell(0,3,'CORPORATION',0,1,'C');
    $pdf->SetFont('Times','',12);
    $pdf->Cell(0,10,utf8_decode('CONTRACTORS '.chr(127).' ENGINEERS '.chr(127).' CONSULTANT'),0,2,'C');

    //PROJECT Details
    $projects_id = $_SESSION['projects_id'];
    $sql = "SELECT projects_name, projects_address FROM projects 
    WHERE projects_id = '$projects_id';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_row($result);
    $pdf->SetFont('Times','',12);
    $pdf->Cell(0,25,'PROJECT : '.strtoupper($row[0]),0,2);
    $pdf->Cell(0,-16,'LOCATION : '.strtoupper($row[1]),0,2);
    $pdf->Cell(0,26,'SUBJECT : INVENTORY REPORT AS OF '.date("F Y"),0,2);

    //SET TABLE BORDER COLOR
    $pdf->SetFont('Times','B',9);
    $pdf->SetFillColor(255,255,255);
    $pdf->SetDrawColor(0,0,0);
    
    //TABLE HEADER
    $pdf->MultiCell(50,26.67,'PARTTICULARS',1,'C',true);
    $pdf->SetXY($pdf->GetX()+50,$pdf->GetY()-26.67);
    $pdf->MultiCell(22,8.9,utf8_decode('PREVIOUS'.chr(10).'MATERIAL'.chr(10).'STOCK'),1,'C',true);
    $pdf->SetXY($pdf->GetX()+72,$pdf->GetY()-26.67);
    $pdf->MultiCell(22,6.67,utf8_decode('DELIVERED'.chr(10).'MATERIAL'.chr(10).'AS OF'.chr(10).date("F Y")),1,'C',true);
    $pdf->SetXY($pdf->GetX()+94,$pdf->GetY()-26.67);
    $pdf->MultiCell(31,8.9,utf8_decode('MATERIAL'.chr(10).'PULLED OUT'.chr(10).'AS OF '.date("F Y")),1,'C',true);
    $pdf->SetXY($pdf->GetX()+125,$pdf->GetY()-26.67);
    $pdf->MultiCell(29,8.9,utf8_decode('ACCUMULATED'.chr(10).'MATERIALS'.chr(10).'DELIVERED'),1,'C',true);
    $pdf->SetXY($pdf->GetX()+154,$pdf->GetY()-26.67);
    $pdf->MultiCell(35,13.33,utf8_decode('MATERIALS ON SITE'.chr(10).'AS OF '.date("F Y")),1,'C',true);
  
    //TABLE CONTENT
    $sql_categ = "SELECT DISTINCT
                    categories_name
                FROM
                    materials
                INNER JOIN
                    categories ON categories.categories_id = materials.mat_categ
                INNER JOIN
                    matinfo ON materials.mat_id = matinfo.matinfo_matname
                WHERE
                    matinfo.matinfo_project = $projects_id;";
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
        ORDER BY 1;";
        $pdf->SetFont('Times','B',9);
        $pdf->Cell(189,0.75," ",1,0,'L',true);
        $pdf->Ln();
        $pdf->Cell(189,10,strtoupper($categ).":",1,0,'L',true);
        $pdf->Ln();
        $pdf->Cell(189,0.75," ",1,0,'L',true);
        $pdf->Ln();
        $result = mysqli_query($conn, $sql);
        $pdf->SetFont('Times','',9);
        while($row = mysqli_fetch_row($result)){
            $matinfo_id = $row[6];  
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
            }
            $pdf->Cell(50,10,$row[1],1,0,'C',true);
            $pdf->Cell(12,10,$row[3],1,0,'C',true);
            $pdf->Cell(10,10,$row[4],1,0,'C',true);
            if($row1[0] == null) {
                $pdf->Cell(22,10,0,1,0,'C',true);
            } else {                
                $pdf->Cell(22,10,$row1[0],1,0,'C',true);
            }             
            $pdf->Cell(21,10,$mat_count_use,1,0,'C',true);
            $pdf->Cell(10,10,$row[4],1,0,'C',true);
            if ($row1[0] == 0) {
                $pdf->Cell(29,10,0,1,0,'C',true);
            } else {
                $pdf->Cell(29,10,$row1[0],1,0,'C',true);
            }
            $pdf->Cell(25,10,$row[5],1,0,'C',true);
            $pdf->Cell(10,10,$row[4],1,0,'C',true);
            $pdf->Ln();
        }
    }
    $preparedBy = $_SESSION['preparedBy'];
    $checkedBy = $_SESSION['checkedBy'];
    $notedBy = $_SESSION['notedBy'];
    $pdf->SetFontSize(13);
    $pdf->Ln();
    $pdf->SetXY($pdf->GetX(),$pdf->GetY()+10);
    $pdf->Cell(63,10,$preparedBy,0,0,'C',true);
    $pdf->Cell(63,10,$checkedBy,0,0,'C',true);
    $pdf->Cell(63,10,$notedBy,0,0,'C',true);
    
    $pdf->Ln();
    
    
    $pdf->SetY($pdf->GetY()-3);
    $pdf->SetFont('Times','B',11);
    $pdf->Cell(63,10,'Prepared by: ',0,0,'C',true);
    $pdf->Cell(63,10,'Checked by: ',0,0,'C',true);
    $pdf->Cell(63,10,'Noted by: ',0,0,'C',true);

    $pdf->Ln();
    $pdf->SetXY($pdf->GetX()+4, $pdf->GetY()-9);
    $pdf->Cell(55,0.1," ",1,0,'C',true);
    $pdf->SetX($pdf->GetX()+8);
    $pdf->Cell(55,0.1," ",1,0,'C',true);
    $pdf->SetX($pdf->GetX()+8);
    $pdf->Cell(55,0.1," ",1,0,'C',true);
    
    $pdf->Ln();
    //OUTPUT TO PDF
    $pdf->Output('D', "INVENTORY REPORT ".date("F Y").".pdf");
?>