<?php
    include("../controlador/conexionBdd.php");

    $accion = $_GET['accion'];

    if($accion == 'buscar'){
        $aula =  mysqli_real_escape_string(conectar(),$_GET['aula']);
        $query =   "SELECT plantel, licenciatura, coordinacion 
                    FROM aulas 
                    WHERE aula = '" . $aula . "';";
        $result = mysqli_query(conectar(),$query);
    
        if($row = mysqli_fetch_array($result)){
            
            $datosEncontrados = array(
                'plantel'      => $row['plantel'],
                'licenciatura' => $row['licenciatura'],
                'coordinacion' => $row['coordinacion']
            );
            
        }else{
            $datosEncontrados = null;
        }
    
        echo json_encode($datosEncontrados);
    }else{
        $aula =  mysqli_real_escape_string(conectar(),$_POST['aula']);
        $plantel =  mysqli_real_escape_string(conectar(),$_POST['plantel']);
        $licenciatura =  mysqli_real_escape_string(conectar(),$_POST['licenciatura']);
        $coordinacion =  mysqli_real_escape_string(conectar(),$_POST['coordinacion']);
        $nuevaAula = $_POST['nuevaAula']; //variable de control para actualizar o registrar una nueva aula
        
        if($nuevaAula == 'true'){ //Insert para nuevas aulas
            $query =   "INSERT INTO aulas (aula, plantel, licenciatura, estatus, coordinacion, ultimoMovimiento) 
                        VALUES('" . $aula . "','" . $plantel . "','" . $licenciatura . "', '0','" . $coordinacion . "', '0')";
        }else{ //Actualizacion de aulas existentes
            $query =   "UPDATE aulas 
                        SET plantel = '" . $plantel . "', licenciatura = '" . $licenciatura . "',
                        coordinacion = '" . $coordinacion . "' WHERE aula = '" . $aula . "';";
        }

        $result = mysqli_query(conectar(),$query);

        if($result){
            echo 'success';
        }

    }