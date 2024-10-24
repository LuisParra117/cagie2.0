<?php
    include("../controlador/conexionBdd.php");

    $accion = $_POST['accion'];

    if($accion == 'buscar'){
        $licenciatura = mysqli_real_escape_string(conectar(),$_POST['licenciatura']);
        $query =   "SELECT plantel 
                    FROM licenciaturas 
                    WHERE licenciatura = '" . $licenciatura . "';";
        $result = mysqli_query(conectar(),$query);

        if($result){
            $row = mysqli_fetch_assoc($result);
            
            if($row > 0){    
                echo $row['plantel'];
            }else{
                echo 0;
            }

        }

    }else{
        $licenciatura =  mysqli_real_escape_string(conectar(),$_POST['licenciatura']);
        $plantel =  mysqli_real_escape_string(conectar(),$_POST['plantel']);
        $nuevaLicenciatura = $_POST['nuevaLicenciatura'];

        if($nuevaLicenciatura == 'true'){
            $query =   "INSERT INTO licenciaturas (licenciatura, plantel) 
                        VALUES ('" . $licenciatura . "','" . $plantel . "');";
        }else{
            $query =   "UPDATE licenciaturas 
                        SET plantel = '" . $plantel . "' WHERE licenciatura = '" . $licenciatura . "';";
        }

        $result = mysqli_query(conectar(),$query);

        if($result){
            echo 'success';
        }
        
    }
    