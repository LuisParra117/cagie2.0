<?php
    require ('fpdf/fpdf.php');
    include("../controlador/conexionBdd.php");

    $plantel = $_GET['plantel'];

    class PDF extends FPDF{

        function Header(){
            $this->Image('../img/cagieGrande.png',170,0,33);
            $this->Image('../img/logoGrandeUnedl.png',5,7,45);
            $this->SetFont('Arial','B',20);
            $this->Cell(80);
            $this->Cell(30,10,'Reporte de Licenciaturas',0,0,'C');
            $this->Ln(20);
            $fecha_generacion = date('Y-m-d');
            $this->SetFont('Arial','',10);
            $this->Cell(0, 10, 'Fecha de generacion del reporte: ' . $fecha_generacion, 0, 1);
            $this->SetFont('Arial','B',15);
            $this->Cell(70,10,'Licenciatura',0,0,'c',0);
            $this->Cell(40,10,'Plantel',0,1,'c',0);
            $this->SetLineWidth(1);
            $this->Line(10, $this->GetY(), 200, $this->GetY());
        }
        
        function Footer(){
            $this->SetY(-15);
            $this->SetFont('Arial','I',8);
            $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
        }

    }

    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Times','',12);

    $query = "SELECT licenciaturas.idLicenciatura AS idLicenciatura,
                    licenciaturas.licenciatura,
                    planteles.clavePlantel AS plantel
                FROM licenciaturas
                JOIN planteles ON licenciaturas.plantel = planteles.idPlantel";
    
    $ordenamiento = " ORDER BY plantel DESC;";
    $condicion = '';

    if($plantel != ''){
        $condicion = " WHERE plantel = '" . $plantel . "'";
    }

    $queryFinal = $query . $condicion . $ordenamiento;
    $result = mysqli_query(conectar(), $queryFinal);

    while($row = $result->fetch_assoc()){
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(70,10,utf8_decode($row['licenciatura']),0,0,'c',0);
        $pdf->Cell(40,10,$row['plantel'],0,1,'c',0);
        $pdf->SetLineWidth(0.05);
        $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
    }

    $pdf->Output();