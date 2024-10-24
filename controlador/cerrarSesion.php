<?php
    session_start();
    
    if (isset($_SESSION['usuarioLogueado']) == true) {
        session_destroy();
        header('Location: ../index.php');
        die();
    }