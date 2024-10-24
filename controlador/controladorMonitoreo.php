<?php
    include("conexionBdd.php");
    
    $aula =  mysqli_real_escape_string(conectar(),$_POST['aula']);
    $estAula =  mysqli_real_escape_string(conectar(),$_POST['estatus']);
    $credencial =  mysqli_real_escape_string(conectar(),$_POST['credencial']);

    $fecha = date("Y-m-d");
    $hora = date("H:i:s");

    if($estAula == '0'){
        $movimiento = "Apertura";
        $estatus = 1;
    }else{
        $movimiento = "Cierre";
        $estatus = 0;
    }
    
    $query1 = "SELECT idAula FROM aulas WHERE aula = '" . $aula . "';";
    $result1 = mysqli_query(conectar(), $query1);

    if($result1){
        $row1 = mysqli_fetch_assoc($result1);
        
        if($row1 > 0){    
            $idAula = $row1['idAula'];
        }

    }

    $query2 =  "INSERT INTO historialAccesos (aula, movimiento, fecha, hora, credencial) 
                VALUES ('" . $idAula . "','" . $movimiento . "','" . $fecha . "','" . $hora . "','" . $credencial . "');";
    $result2 = mysqli_query(conectar(), $query2);

    if($result2){

        $query3 = "SELECT MAX(idAcceso) AS id FROM historialAccesos;";
        $result3 = mysqli_query(conectar(), $query3);

        if($result3){
            $row3 = mysqli_fetch_assoc($result3);

            if($row3 > 0){
                $ultimoId = $row3['id'];
            }

            $query4 =  "UPDATE aulas 
                        SET estatus = '" . $estatus . "', ultimoMovimiento = '" . $ultimoId . "' 
                        WHERE aula = '" . $aula . "';";
            $result4 = mysqli_query(conectar(), $query4);

            if($result4 && $estatus == 1){
                $response = ejecutarScriptEnRaspberry();
                echo 'apertura';
            }else if($result4 && $estatus == 0){
                echo 'cierre';
            }

        }

    }
    function ejecutarScriptEnRaspberry() {
        $raspberryIp = '192.168.100.230';
        $username = 'pi';
        $password = 'maximiliano';
        $archivoPython = '/home/pi/pi-rfid/puerta.py';

        $rutaSshpass = '/usr/local/bin/sshpass'; // Se especifica la ruta de la libreria sshpass
        $rutaSsh = '/usr/bin/ssh'; // Se especifica la ruta de la libreria ssh

        // Comando ssh
        $comandoSSH = "$rutaSshpass -p '$password' $rutaSsh -o StrictHostKeyChecking=no $username@$raspberryIp '/home/pi/pi-rfid/env/bin/python3 $archivoPython'";

        $output = [];
        $return_var = 0;
        exec($comandoSSH, $output, $return_var);

        // Verificar si hubo un error al ejecutar el comando
        if ($return_var !== 0) {
            $error = error_get_last();
            return "Error al ejecutar el comando SSH. Código de retorno: $return_var. Error: " . ($error ? $error['message'] : 'No se pudo obtener el error');
        }

        return $output;
    }