<?php
    include '../fpdf/fpdf.php';
    include "../db_connection.php";
    session_start();
    if (isset($_SESSION['matinfo_id'])) {
        $matinfo_id = $_SESSION['matinfo_id'];
    } else {
        header("Location:http://127.0.0.1/NGCBDC/Materials%20Engineer/viewinventory.php");  
    }
    

    //INITIALIZATION OF FPDF OBJECT
    $pdf = new FPDF();
    $pdf->AddPage();

    //PAGE TITLE
    $pdf->SetFont('Times','B',14);
    $pdf->Cell(0,10,'NEW GOLDEN CITY BUILDERS AND DEVELOPMENT CORPORATION',0,1,'C');
    $pdf->SetFont('Times','',12);
    $pdf->Ln();
    $pdf->SetXY($pdf->GetX()+6, $pdf->GetY()-12);
    $pdf->Cell(179,0," ",1,0,'C',true);
    $pdf->Ln();
    $pdf->SetFontSize(12);
    $pdf->SetXY($pdf->GetX(), $pdf->GetY()-1.5);
    $pdf->Cell(0,10,utf8_decode('CONTRACTORS '.chr(127).' ENGINEERS '.chr(127).' CONSULTANT'),0,2,'C');

    //PROJECT Details
    $projects_id = $_SESSION['projects_id'];
    $sql = "SELECT projects_name, projects_address FROM projects 
    WHERE projects_id = '$projects_id';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_row($result);
    $pdf->SetFont('Times','BI',12);
    $pdf->SetY($pdf->GetY()-5);
    $pdf->Cell(0,10,$row[0],0,1,'C');

    //CONTENT
    $pdf->SetFont('Times','B',13);
    $pdf->SetXY($pdf->GetX()+6, $pdf->GetY()+3);
    $pdf->SetFillColor(169, 169, 169);
    $pdf->Cell(179,6,"MATERIALS STOCK CARD",0,1,'C',true);
    $pdf->Ln();
    $pdf->SetFont('Times','',14);

    $sql_item = "SELECT materials.mat_name FROM materials INNER JOIN matinfo on matinfo.matinfo_matname = materials.mat_id WHERE matinfo.matinfo_id = $matinfo_id;";
    $result_item = mysqli_query($conn, $sql_item);
    $row_item = mysqli_fetch_row($result_item);

    $pdf->SetX($pdf->GetX()+6);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->Cell(15,6,"ITEM:",0,1,'C',true);
    $pdf->SetXY($pdf->GetX()+45,$pdf->GetY()-6);
    $pdf->Cell(15,6,strtoupper($row_item[0]),0,1,'C',true);
    $pdf->SetX($pdf->GetX()+32);
    $pdf->Cell(55,0," ",1,0,'C',true);
    $pdf->Ln();
    $pdf->SetXY($pdf->GetX()+8.3,$pdf->GetY()+2);
    $pdf->Cell(15,6,"BRAND:",0,1,'C',true);
    $pdf->SetX($pdf->GetX()+32);
    $pdf->Cell(55,0," ",1,0,'C',true);
    $pdf->Ln();

    
    $pdf->SetFillColor(169, 169, 169);
    
    $pdf->SetXY($pdf->GetX()+6, $pdf->GetY()+7);
    $pdf->Cell(175,12,"",0,1,'C',true);
    $pdf->SetFont('Times','B',11);
    $pdf->SetXY($pdf->GetX()+6, $pdf->GetY()-12);
    $pdf->MultiCell(62,6,'DELIVERY (IN)',1,'C',true);
    $pdf->SetXY($pdf->GetX()+70, $pdf->GetY()-6);
    $pdf->MultiCell(86,6,'USAGE (IN)',1,'C',true);
    $pdf->SetXY($pdf->GetX()+158, $pdf->GetY()-6);
    $pdf->MultiCell(26,6,'AVAILABLE STOCK',1,'C',true);
    $pdf->SetXY($pdf->GetX()+6, $pdf->GetY()-12);
    $pdf->Cell(175,0," ",1,0,'C',true);

    $pdf->SetFont('Times','',9);
    $pdf->SetXY($pdf->GetX()-175, $pdf->GetY()+6);
    $pdf->MultiCell(16,6,'Date',1,'C',true);
    $pdf->SetXY($pdf->GetX()+22, $pdf->GetY()-6);
    $pdf->MultiCell(12,6,'Qty',1,'C',true);
    $pdf->SetXY($pdf->GetX()+34, $pdf->GetY()-6);
    $pdf->MultiCell(12,6,'Unit',1,'C',true);
    $pdf->SetXY($pdf->GetX()+46, $pdf->GetY()-6);
    $pdf->MultiCell(22,6,'Supplied by:',1,'C',true);

    $pdf->SetXY($pdf->GetX()+70, $pdf->GetY()-6);
    $pdf->MultiCell(16,6,'Date',1,'C',true);
    $pdf->SetXY($pdf->GetX()+86, $pdf->GetY()-6);
    $pdf->MultiCell(12,6,'Qty',1,'C',true);
    $pdf->SetXY($pdf->GetX()+98, $pdf->GetY()-6);
    $pdf->MultiCell(12,6,'Unit',1,'C',true);
    $pdf->SetXY($pdf->GetX()+110, $pdf->GetY()-6);
    $pdf->MultiCell(21,6,'Pull-out by:',1,'C',true);
    $pdf->SetXY($pdf->GetX()+131, $pdf->GetY()-6);
    $pdf->MultiCell(25,6,'Area of Usage',1,'C',true);

    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetXY($pdf->GetX()+6, $pdf->GetY());
    $pdf->Cell(62,0.5,"",1,1,'C',true);
    $pdf->SetXY($pdf->GetX()+70, $pdf->GetY()-0.5);
    $pdf->Cell(86,0.5,"",1,1,'C',true);
    $pdf->SetXY($pdf->GetX()+158, $pdf->GetY()-0.5);
    $pdf->Cell(26,0.5,"",1,1,'C',true);
    $pdf->Ln();

    $sql_mat = "SELECT
                    unit.unit_name
                FROM
                    materials
                INNER JOIN
                    unit ON unit.unit_id = materials.mat_unit
                INNER JOIN
                    matinfo ON matinfo.matinfo_matname = materials.mat_id
                WHERE
                    matinfo.matinfo_id = $matinfo_id;";
    $result_mat = mysqli_query($conn, $sql_mat);
    $mat_count_del = 0;
    $ctr_del = 0;
    while ($row_mat = mysqli_fetch_row($result_mat)) {
        $sql_del = "SELECT
                        deliveredin.deliveredin_date,
                        deliveredmat.deliveredmat_qty,
                        deliveredmat.suppliedBy,
                        deliveredin.deliveredin_remarks,
                        deliveredin.deliveredin_receiptno
                    FROM
                        deliveredmat
                    INNER JOIN
                        deliveredin ON deliveredin.deliveredin_id = deliveredmat.deliveredmat_deliveredin
                    INNER JOIN
                        matinfo ON deliveredmat.deliveredmat_materials = matinfo.matinfo_matname
                    WHERE
                        matinfo.matinfo_id = $matinfo_id
                        AND
                            deliveredin.deliveredin_project = $projects_id;";
        $result_del = mysqli_query($conn, $sql_del);
        while ($row_del = mysqli_fetch_row($result_del)) {
            $pdf->SetXY($pdf->GetX()+6,$pdf->GetY()-0.5);
            $pdf->Cell(16,6,$row_del[0],1,0,'C',true);
            $pdf->Cell(12,6,$row_del[1],1,0,'C',true);
            $pdf->Cell(12,6,$row_mat[0],1,0,'C',true);
            $pdf->Cell(22,6,$row_del[2],1,0,'C',true);
            $pdf->Ln();
            $ctr_del++;
            $mat_count_del =+ $row_del[1];
        }
    }
    while ($ctr_del <= 25) {
        $pdf->SetXY($pdf->GetX()+6,$pdf->GetY()-0.5);
        $pdf->Cell(16,6,"",1,0,'C',true);
        $pdf->Cell(12,6,"",1,0,'C',true);
        $pdf->Cell(12,6,"",1,0,'C',true);
        $pdf->Cell(22,6,"",1,0,'C',true);
        $pdf->Ln();
        $ctr_del++;
    }
    $pdf->SetX($pdf->GetX()+6);
    $pdf->Cell(28,6,"Running Total (in)",1,0,'C',true);
    $pdf->Cell(2,6," :","LTB",0,'C',true);
    if ($mat_count_del == 0) {
        
        $pdf->Cell(32,6,"","RTB",0,'L',true);
    } else {
        
        $pdf->Cell(32,6,$mat_count_del,"RTB",0,'L',true);
    }

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
    $ctr_use = 0;
    
    $pdf->SetXY($pdf->GetX()-68,$pdf->GetY()-143);
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
            $pdf->SetXY($pdf->GetX()+70,$pdf->GetY()-0.5);
            $pdf->Cell(16,6,$row_use[0],1,0,'C',true);
            $pdf->Cell(12,6,$row_use[1],1,0,'C',true);
            $pdf->Cell(12,6,$row_mat[0],1,0,'C',true);
            $pdf->Cell(21,6,$row_use[2],1,0,'C',true);
            $pdf->Cell(25,6,$row_use[3],1,0,'C',true);
            $pdf->Ln();
            $mat_count_use =+ $row_use[1];
            $ctr_use++;
        }   
    }

    while ($ctr_use <= 25) {
        $pdf->SetXY($pdf->GetX()+70,$pdf->GetY()-0.5);
        $pdf->Cell(16,6,"",1,0,'C',true);
        $pdf->Cell(12,6,"",1,0,'C',true);
        $pdf->Cell(12,6,"",1,0,'C',true);
        $pdf->Cell(21,6,"",1,0,'C',true);
        $pdf->Cell(25,6,"",1,0,'C',true);
        $pdf->Ln();
        $ctr_use++;
    }

    $pdf->SetX($pdf->GetX()+70);
    $pdf->Cell(28,6,"Running Total (in)",1,0,'C',true);
    $pdf->Cell(2,6," :","LTB",0,'C',true);
    if ($mat_count_use == 0) {
        
        $pdf->Cell(31,6,"","RTB",0,'L',true);
    } else {
        
        $pdf->Cell(31,6,$mat_count_use,"RTB",0,'L',true);
    }
    $pdf->Cell(25,6,"Present Stock",1,0,'L',true);

    $sql_stock = "SELECT currentQuantity FROM matinfo WHERE matinfo_id = $matinfo_id";
    $result_stock = mysqli_query($conn, $sql_stock);
    $row_stock = mysqli_fetch_row($result_stock);
    $currentQuantity = $row_stock[0];
    $ctr_stock = 0;
    
    $pdf->SetXY($pdf->GetX()-156,$pdf->GetY()-143);
    while ($ctr_stock <= 25) {
        $pdf->SetXY($pdf->GetX()+158,$pdf->GetY()-0.5);
        $pdf->Cell(26,6,"",1,0,'C',true);
        $pdf->Ln();
        $ctr_stock++;
    }
    
    $pdf->SetXY($pdf->GetX()+158,$pdf->GetY());
    $pdf->Cell(2,6," :","LTB",0,'C',true);
    if ($currentQuantity == 0) {
        
        $pdf->Cell(24,6,"","RTB",0,'L',true);
    } else {
        
        $pdf->Cell(24,6,$currentQuantity,"RTB",0,'L',true);
    }
    $pdf->Ln();
    $pdf->SetXY($pdf->GetX()+6,$pdf->GetY());
    $pdf->Cell(178,0,"",1,1,'C',true);
    $pdf->Ln();

    $pdf->SetXY($pdf->GetX()+6,$pdf->GetY()+35);
    $pdf->SetFont('Times','B',10);
    $pdf->Cell(64,10,'Prepared by: ',0,0,'L',true);
    $pdf->Cell(61,10,'Checked by: ',0,0,'L',true);
    $pdf->Cell(53,10,'Noted by: ',0,0,'L',true);

    //OUTPUT TO PDF
    $pdf->Output('D', "MATERIAL STOCKCARD OF ".strtoupper($row_item[0]).".pdf");
?>