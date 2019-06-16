<?php
    include '../fpdf/fpdf.php';
    include "../db_connection.php";
    session_start();
    $projects_id = $_SESSION['projects_id'];
    $lastmatinfo_month = $_SESSION['lastmatinfo_month'];
    $lastmatinfo_year = $_SESSION['lastmatinfo_year'];

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
    $pdf->Cell(0,26,'SUBJECT : INVENTORY REPORT AS OF '.strtoupper(date("F", mktime(0, 0, 0, $lastmatinfo_month, 10)))." ".$lastmatinfo_year,0,2);

    //SET TABLE BORDER COLOR
    $pdf->SetFont('Times','B',9);
    $pdf->SetFillColor(255,255,255);
    $pdf->SetDrawColor(0,0,0);
    
    //TABLE HEADER
    $pdf->MultiCell(50,26.67,'PARTTICULARS',1,'C',true);
    $pdf->SetXY($pdf->GetX()+50,$pdf->GetY()-26.67);
    $pdf->MultiCell(22,8.9,utf8_decode('PREVIOUS'.chr(10).'MATERIAL'.chr(10).'STOCK'),1,'C',true);
    $pdf->SetXY($pdf->GetX()+72,$pdf->GetY()-26.67);
    $pdf->MultiCell(22,6.67,utf8_decode('DELIVERED'.chr(10).'MATERIAL'.chr(10).'AS OF '.chr(10)).strtoupper(date("F", mktime(0, 0, 0, $lastmatinfo_month, 10)))." ".$lastmatinfo_year,1,'C',true);
    $pdf->SetXY($pdf->GetX()+94,$pdf->GetY()-26.67);
    $pdf->MultiCell(31,8.9,utf8_decode('MATERIAL'.chr(10).'PULLED OUT'.chr(10).'AS OF ').strtoupper(date("F", mktime(0, 0, 0, $lastmatinfo_month, 10)))." ".$lastmatinfo_year,1,'C',true);
    $pdf->SetXY($pdf->GetX()+125,$pdf->GetY()-26.67);
    $pdf->MultiCell(29,8.9,utf8_decode('ACCUMULATED'.chr(10).'MATERIALS'.chr(10).'DELIVERED'),1,'C',true);
    $pdf->SetXY($pdf->GetX()+154,$pdf->GetY()-26.67);
    $pdf->MultiCell(35,13.33,utf8_decode('MATERIALS ON SITE'.chr(10).'AS OF ').strtoupper(date("F", mktime(0, 0, 0, $lastmatinfo_month, 10)))." ".$lastmatinfo_year,1,'C',true);
  
    //TABLE CONTENT
    $sql_categ = "SELECT DISTINCT
                    categories_name
                FROM
                    lastmatinfo
                INNER JOIN
                    categories ON categories.categories_id = lastmatinfo.lastmatinfo_categ
                WHERE
                    lastmatinfo.lastmatinfo_project = $projects_id
                    AND
                        lastmatinfo.lastmatinfo_year = $lastmatinfo_year
                    AND
                        lastmatinfo.lastmatinfo_month = $lastmatinfo_month;";
    $result = mysqli_query($conn, $sql_categ);
    $categories = array();
    while($row_categ = mysqli_fetch_assoc($result)){
        $categories[] = $row_categ;
    }
    foreach($categories as $data) {
        $categ = $data['categories_name'];
        $sql = "SELECT
            materials.mat_name,
            lastmatinfo.lastmatinfo_prevStock,
            unit.unit_name,
            lastmatinfo.lastmatinfo_deliveredMat,
            lastmatinfo.lastmatinfo_matPulledOut,
            lastmatinfo.lastmatinfo_accumulatedMat,
            lastmatinfo.lastmatinfo_matOnSite
        FROM
            lastmatinfo
        INNER JOIN
            materials ON lastmatinfo.lastmatinfo_matname = materials.mat_id
        INNER JOIN
            categories ON lastmatinfo.lastmatinfo_categ = categories.categories_id
        INNER JOIN
            unit ON lastmatinfo.lastmatinfo_unit = unit.unit_id
        WHERE 
            lastmatinfo.lastmatinfo_project = $projects_id 
            AND
                lastmatinfo.lastmatinfo_year = $lastmatinfo_year
            AND
                lastmatinfo.lastmatinfo_month = $lastmatinfo_month
            AND
                categories.categories_name = '$categ' 
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
            $pdf->Cell(50,10,$row[0],1,0,'C',true);
            $pdf->Cell(12,10,$row[1],1,0,'C',true);
            $pdf->Cell(10,10,$row[2],1,0,'C',true);
            $pdf->Cell(22,10,$row[3],1,0,'C',true);
            $pdf->Cell(21,10,$row[4],1,0,'C',true);
            $pdf->Cell(10,10,$row[2],1,0,'C',true);
            $pdf->Cell(29,10,$row[5],1,0,'C',true);
            $pdf->Cell(25,10,$row[6],1,0,'C',true);
            $pdf->Cell(10,10,$row[2],1,0,'C',true);
            $pdf->Ln();
        }
    }

    //OUTPUT TO PDF
    $pdf->Output('D', "INVENTORY REPORT ".date("F", mktime(0, 0, 0, $lastmatinfo_month, 10))." ".$lastmatinfo_year.".pdf");
?>