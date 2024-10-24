<?php

    if (isset($_POST)!=null){

        $user = $_POST['username'];
        $pass = $_POST['password'];
        
        $query =   "SELECT usuario, contraseña, credencial, nombre, rol, licenciatura, coordinacion 
                    FROM `usuarios` AS u
                    JOIN credenciales AS c ON u.credencial = c.idCredencial
                    WHERE u.usuario = sha1('" . $user . "') AND u.contraseña = sha1('" . $pass . "');";
        
        include("conexionBdd.php");
        $result = mysqli_query(conectar(), $query);

        if($result -> num_rows > 0){
            session_start();

            while($row = mysqli_fetch_array($result)){
                $_SESSION['usuarioLogueado'] = $row['usuario'];
                $_SESSION['nombreUsuario'] = $row['nombre'];
                $_SESSION['credencialUsuario'] = $row['credencial'];
                $_SESSION['rolUsuario'] = $row['rol'];
                $_SESSION['licenciaturaUsuario'] = $row['licenciatura'];
                $_SESSION['coordinacionUsuario'] = $row['coordinacion'];
            }

            echo 'success';
        }else{
            echo 'error';
        }

    }