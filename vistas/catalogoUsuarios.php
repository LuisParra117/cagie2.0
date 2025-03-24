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
        
        <div class = "window">

            <div class = "catalog">
                <input type = "button" name = "btnCerrarUsuario" class = "btnCerrarUsuario" value = "Cerrar" onclick = "window.location.href = '../vistas/home.php'">

                <form id = "frmUsuarios" method = "POST">
                    <h1 style = "text-align: center; color: black; margin: 20px; top:-10px;">CATALOGO DE USUARIOS</h1>

                    <div class="form-group">
                        <input type = "text" id = "txtUsername" name = "txtUsername" id = "txtUsername" placeholder="Nombre de Usuario" required >
                        <button type = "submit" class = "btnBuscarUsuario" name = "btnBuscarUsuario" id ="btnBuscarUsuario">Aceptar</button>
                    </div>
                    
                    <input type = "password" id = "txtPassword" name = "txtPassword" id = "txtPassword" placeholder="Contraseña" disabled required >
                    <input type = "text" id = "txtCredencial" name = "txtCredencial" id = "txtCredencial" placeholder="Credencial" disabled required >

                    <button type = "submit" class = "btnGrabarUsuario" name = "btnGrabarUsuario" id = "btnGrabarUsuario" disabled>Grabar</button>
                </form>

            </div>

        </div>
        

    </body>

</html>

<script type = "text/javascript">
    var nuevoUsuario;

    $(function(){

        $('#btnBuscarUsuario').click(function(e){
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

        $('#btnGrabarUsuario').click(function(e){
            e.preventDefault();

            var obj = {
                usuario: $('#txtUsername').val(),
                password: $('#txtPassword').val(),
                credencial: $('#txtCredencial').val(),
                activo: $('#activo').val(),
                nuevoUsuario: nuevoUsuario,
                accion: 'grabar'
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