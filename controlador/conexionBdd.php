<?php
    require '../vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();

    function conectar(){
        $cnn = mysqli_connect($_ENV['host'], $_ENV['user'], $_ENV['pwd'], $_ENV['bdd'],
                            $_ENV['port']);
        $cnn -> set_charset("utf8");

        if (!$cnn) {
            return false;
        }else{
            return $cnn;
        }

    }