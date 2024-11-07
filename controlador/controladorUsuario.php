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
        $usuario =  mysqli_real_escape_string(conectar(),$_POST['username']);
        $contraseña =  mysqli_real_escape_string(conectar(),$_POST['password']);
        $credencial =  mysqli_real_escape_string(conectar(),$_POST['credencial']);
        $activo =  mysqli_real_escape_string(conectar(),"1");
        $nuevoUsuario = $_POST['nuevoUsuario'];

        if($nuevoUsuario == 'true'){
            $query =   "INSERT INTO usuarios (usuario, contraseña, credencia, activo)
                        VALUES (sha1('" . $usuario . "'), sha1('" . $contraseña . "') ,'" . $credencial . "','" . $activo . "');";

        }else{
            $query =   "UPDATE usuarios
                        SET contraseña = '" . $contraseña . "', credencial = '" . $credencial . "', activo = '" . $activo . "'
                        WHERE usuaario = '" . $usuario . "';";
        }

        $result = mysqli_query(conectar(), $query);

        if($result){
            echo 'success';
        }

    }