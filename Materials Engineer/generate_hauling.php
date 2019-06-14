<?php
    include '../fpdf/fpdf.php';
    include "../db_connection.php";
    session_start();

    $hauling_no = $_SESSION['hauling_no'];
    $sql = "SELECT 
                hauling.hauling_no, 
                hauling.hauling_date, 
                hauling.hauling_deliverTo, 
                projects.projects_name, 
                hauling.hauling_requestedBy, 
                hauling.hauling_hauledBy, 
                hauling.hauling_warehouseman, 
                hauling.hauling_approvedBy, 
                hauling.hauling_truckDetailsType, 
                hauling.hauling_truckDetailsPLateNo, 
                hauling.hauling_truckDetailsPO, 
                hauling.hauling_truckDetailsHaulerDR 
            FROM 
                hauling
            INNER JOIN 
                projects ON projects.projects_id = hauling.hauling_hauledFrom
            WHERE 
                hauling.hauling_no = $hauling_no";
    $result = mysqli_query($conn, $sql);
    $array = mysqli_fetch_array($result);

    $pdf = new FPDF();
    $pdf->SetMargins(20,20,20);
    $pdf->AddPage();
    
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(0,8,'NEW GOLDEN CITY BUILDERS & DEV. CORP.',0,1,'C');
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(0,0,'1388 Icasiano St. Cor. Gernali St. Paco Manila',0,1,'C');
    $pdf->Cell(0,8,'Tels. 564-1921 to 25 Fax 563-6610',0,1,'C');
    
    $pdf->SetFont('Times','U',13);
    $pdf->Cell(0,20,'HAULING RECEIPT');
    $pdf->SetXY($pdf->GetX()-70,$pdf->GetY()+10);
    $pdf->SetFont('Times','I',13);
    $pdf->Cell(0,0,'Date:');
    $pdf->SetFont('Times','',12);
    $pdf->SetXY($pdf->GetX()-55,$pdf->GetY());
    $pdf->Cell(5,0,$array[1]);
    $pdf->SetXY($pdf->GetX()-6,$pdf->GetY()+3);
    $pdf->Cell(40,0,"",1,0,'L',true);
    $pdf->Ln();
    $pdf->SetY($pdf->GetY()-4);
    $pdf->SetFont('Times','I',13);
    $pdf->Cell(0,20,'Deliver to');
    $pdf->SetFont('Times','',12);
    $pdf->SetXY($pdf->GetX()-140,$pdf->GetY()+10);
    $pdf->Cell(5,0,$array[2]);
    $pdf->SetXY($pdf->GetX()-10,$pdf->GetY()+3);
    $pdf->Cell(75,0,"",1,0,'L',true);
    $pdf->Ln();

    $pdf->SetFont('Times','I',13);
    $pdf->Cell(0,15,'Hauled from');
    $pdf->SetFont('Times','',12);
    $pdf->SetXY($pdf->GetX()-135,$pdf->GetY()+8);
    $pdf->Cell(5,0,$array[3]);
    $pdf->SetXY($pdf->GetX()-10,$pdf->GetY()+3);
    $pdf->Cell(70,0,"",1,0,'L',true);
    $pdf->Ln();
    
    $pdf->SetFillColor(255,255,255);
    $pdf->SetDrawColor(0,0,0);

    $pdf->SetY($pdf->GetY()+7);
    $pdf->Cell(30,6,'Qty.',1,0,'C',true);
    $pdf->Cell(30,6,'Unit',1,0,'C',true);
    $pdf->Cell(107,6,'ARTICLES',1,0,'C',true);
    $pdf->Ln();

    $sql_table = "SELECT
                    haulingmat.haulingmat_qty,
                    unit.unit_name,
                    materials.mat_name
                FROM
                    haulingmat
                INNER JOIN
                    hauling ON hauling.hauling_id = haulingmat_haulingid
                INNER JOIN 
                    unit ON unit.unit_id = haulingmat.haulingmat_unit
                INNER JOIN 
                    materials ON materials.mat_id = haulingmat.haulingmat_matname
                WHERE
                    hauling.hauling_no = $hauling_no;";
    $result_table = mysqli_query($conn, $sql_table);

    $num_row = 0;
    while ($row_table = mysqli_fetch_row($result_table)) {
        $pdf->Cell(30,6,$row_table[0],1,0,'C',true);
        $pdf->Cell(30,6,$row_table[1],1,0,'C',true);
        $pdf->Cell(107,6,$row_table[2],1,0,'C',true);
        $pdf->Ln();
        $num_row++;
    }


    if($num_row <= 15 ) {
        for($ctr = 15 - $num_row; $ctr >= 0; $ctr--) {
            $pdf->Cell(30,6,'',1,0,'C',true);
            $pdf->Cell(30,6,'',1,0,'C',true);
            $pdf->Cell(107,6,'',1,0,'C',true);
            $pdf->Ln();
        }
    }

    
    $pdf->SetY($pdf->GetY()-2);
    
    $pdf->SetFont('Times','I',13);
    $pdf->Cell(0,20,'Requested:');
    $pdf->SetXY($pdf->GetX()-169,$pdf->GetY()+20);
    $pdf->Cell(80,0,$array[4],0,0,'C');
    $pdf->SetXY($pdf->GetX()-80,$pdf->GetY()+3);
    $pdf->Cell(80,0,"",1,0,'L',true);
    
    $pdf->SetXY($pdf->GetX()+5,$pdf->GetY()-23);
    $pdf->Cell(0,20,'Hauled by:');
    $pdf->SetXY($pdf->GetX()-83,$pdf->GetY()+20);
    $pdf->Cell(80,0,$array[5],0,0,'C');
    $pdf->SetXY($pdf->GetX()-80,$pdf->GetY()+3);
    $pdf->Cell(80,0,"",1,0,'L',true);
    $pdf->Ln();

    $pdf->Cell(0,20,'Warehouseman:');
    $pdf->SetXY($pdf->GetX()-169,$pdf->GetY()+20);
    $pdf->Cell(80,0,$array[6],0,0,'C');
    $pdf->SetXY($pdf->GetX()-80,$pdf->GetY()+3);
    $pdf->Cell(80,0,"",1,0,'L',true);
    $pdf->Ln();

    $pdf->Cell(0,20,'Approved by:');
    $pdf->SetXY($pdf->GetX()-169,$pdf->GetY()+20);
    $pdf->Cell(80,0,$array[7],0,0,'C');
    $pdf->SetXY($pdf->GetX()-80,$pdf->GetY()+3);
    $pdf->Cell(80,0,"",1,0,'L',true);
    $pdf->Ln();

    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(0,20,'No:');
    $pdf->SetFont('Times','',16);
    $pdf->SetTextColor(220,20,60);
    $pdf->SetXY($pdf->GetX()-155,$pdf->GetY()+10);
    $pdf->Cell(50,0,$array[0],0,0,'L');
    $pdf->Ln();

    $pdf->SetXY($pdf->GetX()+87,$pdf->GetY()-50);
    $pdf->SetFont('Arial','B',12);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(80,6,'Truck Details',1,1,'C',true);
    $pdf->SetFont('Arial','',9);

    $pdf->SetXY($pdf->GetX()+87,$pdf->GetY());
    $pdf->MultiCell(40,12,'',1,'L',true);
    $pdf->SetXY($pdf->GetX()+87,$pdf->GetY()-17);
    $pdf->Cell(40,15,'TYPE:',0,'L');

    $pdf->SetXY($pdf->GetX(),$pdf->GetY()+5);
    $pdf->MultiCell(40,12,'',1,'L',true);
    $pdf->SetXY($pdf->GetX()+127,$pdf->GetY()-17);
    $pdf->Cell(40,15,'PLATE #:',0,'L'); 

    $pdf->SetXY($pdf->GetX()-80,$pdf->GetY()+17);
    $pdf->MultiCell(40,13,'',1,'L',true);
    $pdf->SetXY($pdf->GetX()-123,$pdf->GetY()-17);
    $pdf->Cell(40,15,'P.O. / R.S. #:',0,'L');

    $pdf->SetXY($pdf->GetX(),$pdf->GetY()+4);
    $pdf->MultiCell(40,13,'',1,'L',true);
    $pdf->SetXY($pdf->GetX()+127,$pdf->GetY()-17);
    $pdf->Cell(40,15,'HAULED DR #:',0,'L');

    $pdf->SetFontSize(10);
    $pdf->SetXY($pdf->GetX()-80,$pdf->GetY()-4);
    $pdf->MultiCell(40,8,$array[8],0,'C');
    $pdf->SetXY($pdf->GetX()-83,$pdf->GetY()-8);
    $pdf->MultiCell(40,8,$array[9],0,'C');
    $pdf->SetXY($pdf->GetX()-123,$pdf->GetY()+5);
    $pdf->MultiCell(40,8,$array[10],0,'C');
    $pdf->SetXY($pdf->GetX()-83,$pdf->GetY()-8);
    $pdf->MultiCell(40,8,$array[11],0,'C');

    $pdf->SetFont('Times','I',12);
    $pdf->SetXY($pdf->GetX()+87,$pdf->GetY()-4);
    $pdf->Cell(0,20,'Received articles in good condition.',0,0,'C');
    $pdf->SetXY($pdf->GetX()-83,$pdf->GetY()+22);
    $pdf->Cell(80,0,"",1,0,'L',true);
    $pdf->Ln();
    $pdf->SetY($pdf->GetY()+7);
    $pdf->SetFont('Times','IB',11);
    $pdf->Cell(0,15,'NOTE: All Personnel Please Print Name & Sign',0,0,'C');

    //OUTPUT TO PDF
    $pdf->Output('D', "HAULING FORM NO ".$array[0].".pdf");
?>