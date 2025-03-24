<?php
    include("../controlador/conexionBdd.php");

    $accion = $_GET['accion'];

    if($accion == 'buscar'){
        $plantel = mysqli_real_escape_string(conectar(),$_GET['plantel']);
        $query =   "SELECT calle, numeroExterior, numeroInterior, codigoPostal, colonia, localidad, estado 
                    FROM planteles 
                    WHERE clavePlantel = '" . $plantel . "';";
        $result = mysqli_query(conectar(),$query);

        if($row = mysqli_fetch_array($result)){

            $datosEncontrados = array(
                'calle'             => $row['calle'],
                'numeroExterior'    => $row['numeroExterior'],
                'numeroInterior'    => $row['numeroInterior'],
                'codigoPostal'      => $row['codigoPostal'],
                'colonia'           => $row['colonia'],
                'localidad'         => $row['localidad'],
                'estado'            => $row['estado']
            );

        }else{
            $datosEncontrados = null;
        }

        echo json_encode($datosEncontrados);
    }else{
        $plantel =  mysqli_real_escape_string(conectar(),$_POST['plantel']);
        $calle =  mysqli_real_escape_string(conectar(),$_POST['calle']);
        $numeroExterior =  mysqli_real_escape_string(conectar(),$_POST['numeroExterior']);
        $numeroInterior =  mysqli_real_escape_string(conectar(),$_POST['numeroInterior']);
        $codigoPostal =  mysqli_real_escape_string(conectar(),$_POST['codigoPostal']);
        $colonia =  mysqli_real_escape_string(conectar(),$_POST['colonia']);
        $localidad =  mysqli_real_escape_string(conectar(),$_POST['localidad']);
        $estado =  mysqli_real_escape_string(conectar(),$_POST['estado']);
        $nuevoPlantel = $_POST['nuevoPlantel'];
    
        if ($nuevoPlantel == 'true') {
            $query = "INSERT INTO planteles (plantel, calle, numeroExterior, numeroInterior, codigoPostal, 
                        colonia, localidad, estado)
                        VALUES ('" . $plantel . "','" . $calle . "','" . $numeroExterior . 
                        "','" . $numeroInterior . "','" . $codigoPostal . "','" . $colonia . "','" . $localidad . 
                        "','" . $estado . "');";
        } else {
            $query = "UPDATE planteles 
                        SET calle = '" . $calle .
                        "', numeroExterior = '" . $numeroExterior . "', numeroInterior = '" . $numeroInterior . "', 
                        codigoPostal = '" . $codigoPostal . "', colonia = '" . $colonia . "', localidad = '" . $localidad . 
                        "', estado = '" . $estado . "' 
                        WHERE clavePlantel = '" . $plantel . "';";
        }        
    
        $result = mysqli_query(conectar(),$query);
    
        if($result){
            echo 'success';
        }

    }
    