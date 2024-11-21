<?php
session_start();

if (isset($_SESSION['usuarioLogueado']) == true) {
    //redireccionamos a la pagina principal
    header('Location:/cagie/vistas/home.php');
    die();
}else{
    ?>

    <!DOCTYPE html>

    <html lang = "es">

        <head>
            <meta charset = "UTF-8">
            <meta name = "viewport" content = "width = device-width, initial-scale = 1.0">
            <title>Login</title>
            <link rel = "stylesheet" href = "/cagie/css/styleLogin.css">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
            <script src="/cagie/css/sweetalert.css"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
            <script src="/cagie/js/sweetalert.js" type = "text/javascript"></script>
            <link rel="apple-touch-icon" sizes="57x57" href="/cagie/img/favicon/apple-icon-57x57.png">
            <link rel="apple-touch-icon" sizes="60x60" href="/cagie/img/favicon/apple-icon-60x60.png">
            <link rel="apple-touch-icon" sizes="72x72" href="/cagie/img/favicon/apple-icon-72x72.png">
            <link rel="apple-touch-icon" sizes="76x76" href="/cagie/img/favicon/apple-icon-76x76.png">
            <link rel="apple-touch-icon" sizes="114x114" href="/cagie/img/favicon/apple-icon-114x114.png">
            <link rel="apple-touch-icon" sizes="120x120" href="/cagie/img/favicon/apple-icon-120x120.png">
            <link rel="apple-touch-icon" sizes="144x144" href="/cagie/img/favicon/apple-icon-144x144.png">
            <link rel="apple-touch-icon" sizes="152x152" href="/cagie/img/favicon/apple-icon-152x152.png">
            <link rel="apple-touch-icon" sizes="180x180" href="/cagie/img/favicon/apple-icon-180x180.png">
            <link rel="icon" type="image/png" sizes="192x192"  href="/cagie/img/favicon/android-icon-192x192.png">
            <link rel="icon" type="image/png" sizes="32x32" href="/cagie/img/favicon/favicon-32x32.png">
            <link rel="icon" type="image/png" sizes="96x96" href="/cagie/img/favicon/favicon-96x96.png">
            <link rel="icon" type="image/png" sizes="16x16" href="/cagie/img/favicon/favicon-16x16.png">
            <link rel="manifest" href="/cagie/img/favicon/manifest.json">
            <meta name="msapplication-TileColor" content="#ffffff">
            <meta name="msapplication-TileImage" content="/cagie/img/favicon/ms-icon-144x144.png">
            <meta name="theme-color" content="#ffffff">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" type = "text/javascript"></script>
            <script src="/cagie/js/jquery.js" type = "text/javascript"></script>
            
            <meta name = "viewport" content="width=device-width, initial-scale=1.0">
            <meta name = "author" content="Luis Parra, Maximiliano Ramirez">
        </head>

        <body>
            
            <div class = "formulario" id = "formulario">
                
                <form method = "POST" id = "frmLogin" >

                    <div  class = "container">
                        <img src  = "/cagie/img/logoGrandeUnedl.png" alt = "Logo unedl" width = "225" height = "100">
                        <img src  = "/cagie/img/cagieGrande.png" alt = "Logo cagie" width = "100" height = "100">
                    </div>   

                    <div class = "username">
                        <input type = "text" id = "username" name = "username" required >
                        <label>Nombre de Usuario</label>
                    </div>

                    <div class = "password">
                        <input type = "password" id = "password" name = "password" required >
                        <label>Contraseña</label>
                    </div>

                    <button  id = "btnLogin" type = "submit" class = "btnLogin" name = "btnLogin">Iniciar Sesión</button>    
                    <p></p>
                </form>

            </div>

        </body>

    </html>

    <script>

        $(document).ready(function(){

            $('#btnLogin').click(function (e){
                e.preventDefault();

                var objLogin = {
                    username:$('#username').val(),
                    password:$('#password').val()
                };

                $.post("/cagie/controlador/login.php", objLogin, function (resp){
                    
                    switch(resp){
                        case 'success':
                            window.location.reload();
                            break;
                        case 'error':
                            mensajeError('Datos de usuario incorrectos');
                            break;
                        case 'Error de conexion':
                            mensajeError("No hay conexion con el servidor");
                            break;
                    }

                });

            });

        });

        function mensajeError(mensaje){

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: mensaje,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                backdrop: false,
                timer: 4000
            });

        }

    </script>

    <?php
}

?>