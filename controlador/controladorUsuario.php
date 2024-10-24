<?php
    include("../controlador/conexionBdd.php");

    $accion = $_GET['accion'];

    if($accion == 'buscar'){
        $username = mysqli_real_escape_string(conectar(),$_GET['username']);
        $query =   "SELECT usuario, contraseña, c.identificacionCredencial
                    FROM usuarios AS u
                    JOIN credenciales AS c ON u.credencial = c.idCredencial
                    WHERE u.usuario = sha1('" . $username . "');";
        $result = mysqli_query(conectar(), $query);

        if($row = mysqli_fetch_array($result)){

            $datosEncontrados = array(
                'contraseña'    => $row['contraseña'],
                'credencial'    => $row['identificacionCredencial']
            );

        }else{
            $datosEncontrados = null;
        }

        echo json_encode($datosEncontrados);
    }else{
        
    }