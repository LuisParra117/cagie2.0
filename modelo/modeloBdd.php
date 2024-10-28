<?php

    class bdd{
        private $servidor = "localhost";
        private $usuario = "root";
        private $contraseña = "";
        private $bdd = "cagie";
        private $puerto = "3306";
        private $cnn;

        public function conectar(){
            $this->cnn = mysqli_connect($this->servidor, $this->usuario, $this->contraseña, $this->bdd, $this->puerto);
            $this->cnn -> set_charset("utf8");
    
            if (!$this->cnn) {
                die("Error de conexión: " . $this->cnn->connect_error);
            }else{
                return $this->cnn;
            }
    
        }

        public function desconectar(){
            mysqli_close($this->cnn);
        }
        
    }