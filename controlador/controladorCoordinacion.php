<?php
    include("../controlador/conexionBdd.php");

    $accion = $_POST['accion'];

    if($accion == 'buscar'){
        $coordinacion = mysqli_real_escape_string(conectar(),$_POST['coordinacion']);
        $query =   "SELECT licenciatura 
                    FROM coordinaciones 
                    WHERE coordinacion = '" . $coordinacion . "';";
        $result = mysqli_query(conectar(),$query);

        if($result){
            $row = mysqli_fetch_assoc($result);
            
            if($row > 0){    
                echo $row['licenciatura'];
            }else{
                echo 0;
            }

        }
        
    }else{
        $coordinacion =  mysqli_real_escape_string(conectar(),$_POST['coordinacion']);
        $licenciatura =  mysqli_real_escape_string(conectar(),$_POST['licenciatura']);
        $nuevaCoordinacion = $_POST['nuevaCoordinacion'];

        if($nuevaCoordinacion == 'true'){
            $query =   "INSERT INTO coordinaciones (coordinacion, licenciatura) 
                        VALUES ('" . $coordinacion . "','" . $licenciatura . "');";
        }else{
            $query =   "UPDATE coordinaciones 
                        SET licenciatura = '" . $licenciatura . "' 
                        WHERE coordinacion = '" . $coordinacion . "';";
        }

        $result = mysqli_query(conectar(),$query);

        if($result){
            echo 'success';
        }
        
    }
    