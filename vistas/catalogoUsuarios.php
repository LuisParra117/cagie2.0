<?php

?>

<!DOCTYPE html>

<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Usuarios</title>
        <link rel = "stylesheet" href = "/cagie/css/styleCatUsuarios.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" type = "text/javascript"></script>
        <script src="/cagie/js/jquery.js" type = "text/javascript"></script>
    </head>

    <body>
        
        <div class = "catalogo">
            <input type = "button" name = "btnCerrar" class = "btnCerrar" value = "Cerrar" onclick = "window.location.href = '../vistas/home.php'">

            <form id = "frmUsuarios" method = "POST">
                <h1 style = "text-align: center; color: black; margin: 20px; top:-10px;">CATALOGO DE USUARIOS</h1>

                <div class = "txtUsername">
                    <input type = "text" id = "txtUsername" name = "txtUsername" id = "txtUsername" required >
                    <label id = "lblUsername">Nombre de Usuario</label>
                </div>

                <div class = "txtPassword">
                    <input type = "password" id = "txtPassword" name = "txtPassword" id = "txtPassword" required >
                    <label id = "lblPassword">Contraseña</label>
                </div>

                <div class = "txtCredencial">
                    <input type = "text" id = "txtCredencial" name = "txtCredencial" id = "txtCredencial" required >
                    <label id = "lblCredencial">Credencial</label>
                </div>

                <button type = "submit" class = "btnAceptar" name = "btnAceptar" id ="btnAceptar">Aceptar</button>
                <button type = "submit" class = "btnGrabar" name = "btnGrabar" id = "btnGrabar" disabled>Grabar</button>

            </form>

        </div>

    </body>

</html>

<script type = "text/javascript">
    var nuevoUsuario;

    $(function(){

        $('#btnAceptar').click(function(e){
            e.preventDefault();

            if($('#txtUsername').val() != ''){
                
                $.getJSON('../controlador/controladorUsuario.php',{username:$('#txtUsername').val(), accion:'buscar'}, function(resp){

                    if(resp != null){
                        $('#txtPassword').val(resp.contraseña);
                        $('#txtCredencial').val(resp.credencial);
                        nuevoUsuario = false;
                    }else{

                        Swal.fire({
                            title: "Usuario no encontrado, ¿deseas registrarlo?",
                            showDenyButton: true,
                            icon: 'question',
                            confirmButtonText: "Si",
                            backdrop: false,
                            denyButtonText: `No`
                            }).then((result) => {

                            if (result.isConfirmed) {
                                nuevoUsuario = true;
                            } else if (result.isDenied) {
                                $('#txtUsername').val('');
                            }

                        });

                    }

                });
                
            }else{

                Swal.fire({
                    icon: "error",
                    title: "No dejes el campo de nombre de usuario vacio",
                    showConfirmButton: false,
                    backdrop: false,
                    timer: 1500
                });

            }

        });

        $('#btnGrabar').click(function(e){
            e.preventDefault();

            var obj = {
                usuario:$('txtUsername').val(),
                password:$('txtPassword').val(),
                credencial:('txtCredencial').val(),
                activo:$('activo').val();
                nuevoUsuario:nuevoUsuario,
                accion:'grabar'
            };

            $.post('../controlador/controladorUsuario.php', obj, function(resp){

                if(resp == 'success'){
                    
                    Swal.fire({
                        icon: "success",
                        title: "Usuario grabado correctamente",
                        showConfirmButton: false,
                        backdrop: false,
                        timer: 1500
                    });

                }else{
                    
                    Swal.fire({
                        icon: "error",
                        title: "Error al grabar el usuario en la base de datos",
                        showConfirmButton: false,
                        backdrop: false,
                        timer: 1500
                    });

                }

            });

        });

    });

</script>