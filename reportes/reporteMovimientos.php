<?php
    require ('fpdf/fpdf.php');
    include("../controlador/conexionBdd.php");

    $plantel = $_GET['plantel'];
    $licenciatura = $_GET['licenciatura'];
    $aula = $_GET['aula'];
    $fechaInicial = $_GET['fechaInicial'];
    $fechaFinal = $_GET['fechaFinal'];

    class PDF extends FPDF{

        function Header(){
            $this->Image('../img/cagieGrande.png',260,0,33);
            $this->Image('../img/logoGrandeUnedl.png',5,7,45);
            $this->SetFont('Arial','B',20);
            $this->Cell(125);
            $this->Cell(30,10,'Reporte de Movimientos',0,0,'C');
            $this->Ln(20);
            $fecha_generacion = date('Y-m-d');
            $this->SetFont('Arial','',10);
            $this->Cell(0, 5, 'Fecha de generacion del reporte: ' . $fecha_generacion, 0, 1);
            $this->Cell(0, 10, "Informacion generada del " . $_GET['fechaInicial'] . " al " . $_GET['fechaFinal'] . "" , 0, 1);
            $this->SetFont('Arial','B',12);
            $this->Cell(50,10,'Fecha',0,0,'c',0);
            $this->Cell(20,10,'Aula',0,0,'c',0);
            $this->Cell(20,10,'Plantel',0,0,'c',0);
            $this->Cell(45,10,'Licenciatura',0,0,'c',0);
            $this->Cell(45,10,utf8_decode('Coordinación'),0,0,'c',0);
            $this->Cell(30,10,'Movimiento',0,0,'c',0);
            $this->Cell(50,10,'Nombre',0,0,'c',0);
            $this->Cell(40,10,'Rol',0,1,'c',0);
            $this->SetLineWidth(1);
            $this->Line(10, $this->GetY(), 290, $this->GetY());
        }
        
        function Footer(){
            $this->SetY(-15);
            $this->SetFont('Arial','I',8);
            $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
        }

    }

    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('L');
    $pdf->SetFont('Times','',12);
    
    $query = "SELECT historialAccesos.idAcceso AS idAcceso,
                    aulas.aula,
                    planteles.clavePlantel AS plantel,
                    licenciaturas.licenciatura AS licenciatura,
                    coordinaciones.coordinacion AS coordinacion,
                    historialAccesos.movimiento AS movimiento,
                    historialAccesos.fecha AS fecha,
                    historialAccesos.hora AS hora,
                    credenciales.nombre AS nombre,
                    roles.rol AS rol
                FROM historialAccesos
                JOIN aulas ON historialAccesos.aula = aulas.idAula
                JOIN planteles ON aulas.plantel = planteles.idPlantel
                JOIN licenciaturas ON aulas.licenciatura = licenciaturas.idLicenciatura
                JOIN credenciales ON historialAccesos.credencial = credenciales.idCredencial
                JOIN coordinaciones ON credenciales.coordinacion = coordinaciones.idCoordinacion
                JOIN roles ON credenciales.rol = roles.idRol";
    
    $ordenamiento = " ORDER BY idAcceso ASC;";
    $fechas = " WHERE fecha BETWEEN '" . $fechaInicial ."' and '" . $fechaFinal . "'";
    $condicion = '';

    if($plantel != '' && $licenciatura == '' && $aula == ''){ //Filtro plantel
        $condicion = " AND idPlantel = '" . $plantel . "'";
    }else if($plantel == '' && $licenciatura != '' && $aula == ''){ //Filtro licenciatura
        $condicion = " AND idLicenciatura = '" . $licenciatura . "'";
    }else if($plantel == '' && $licenciatura == '' && $aula != ''){ //Filtro aula
        $condicion = " AND idAula = '" . $aula . "'";
    }else if($plantel != '' && $licenciatura != '' && $aula != ''){ //Filtro aula, plantel y licenciatura
        $condicion = " AND idAula = '" . $aula . "'";
    }else if($plantel != '' && $licenciatura != ''){ //Filtro plantel y licenciatura
        $condicion = " AND idPlantel = '" . $plantel . "' and idLicenciatura = '" . $licenciatura . "'";
    }else if($plantel != '' && $aula != ''){ //Filtro plantel y aula
        $condicion = " AND idPlantel = '" . $plantel . "' and idAula = '" . $aula . "'";
    }else if($licenciatura != '' && $aula != '' && $plantel == ''){ //Filtro licenciatura y aula
        $condicion = " AND idLicenciatura = '" . $licenciatura . "' and idAula = '" . $aula . "'";
    } //Falta reporte con filtro de fechas
    
    $queryFinal = $query . $fechas . $condicion . $ordenamiento;
    // echo $queryFinal;
    $result = mysqli_query(conectar(), $queryFinal);

    while($row = $result->fetch_assoc()){
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(25,10,$row['fecha'],0,0,'c',0);
        $pdf->Cell(25,10,$row['hora'],0,0,'c',0);
        $pdf->Cell(20,10,$row['aula'],0,0,'c',0);
        $pdf->Cell(20,10,$row['plantel'],0,0,'c',0);
        $pdf->Cell(45,10,utf8_decode($row['licenciatura']),0,0,'c',0);
        $pdf->Cell(45,10,utf8_decode($row['coordinacion']),0,0,'c',0);
        $pdf->Cell(30,10,$row['movimiento'],0,0,'c',0);
        $pdf->Cell(50,10,utf8_decode($row['nombre']),0,0,'c',0);
        $pdf->Cell(40,10,$row['rol'],0,1,'c',0);
        $pdf->SetLineWidth(0.05);
        $pdf->Line(10, $pdf->GetY(), 290, $pdf->GetY());
    }

    $pdf->Output();