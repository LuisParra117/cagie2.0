<?php

    function conectar(){
        $cnn = mysqli_connect("localhost", "root", "", "cagie", "3306");
        $cnn -> set_charset("utf8");

        if (!$cnn) {
            die("Error de conexión: " . $cnn->connect_error);
        }else{
            return $cnn;            
        }

    }
     
