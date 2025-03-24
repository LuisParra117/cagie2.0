<?php
    include("../controlador/conexionBdd.php");

    $query1 = "SELECT * FROM licenciaturas;";
    $result1 = mysqli_query(conectar(), $query1);
?>

<!DOCTYPE html>

<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Catalogo Coordinaciones</title>
        <link rel = "stylesheet" href = "/cagie/css/styleCatCoordinaciones.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" type = "text/javascript"></script>
        <script src="/cagie/js/jquery.js" type = "text/javascript"></script>
    </head>

    <body>
        
        <div class = "window">

            <div class = "catalog">
                <input type = "button" name = "btnCerrarCoordinacion" class = "btnCerrarCoordinacion" value = "Cerrar" onclick = "window.location.href = '../vistas/home.php'">        

                <form id = "frmCatCoordinaciones" method = "POST">
                    <h1 style = "text-align: center; color: black; margin: 20px;">CATALOGO DE </h1>
                    <h1 style = "text-align: center; color: black; margin: 20px;">COORDINACIONES</h1>

                    <div class = "form-group">
                        <input type = "text" id = "txtClaveCoordinacion" name = "txtClaveCoordinacion" placeholder="Coordincion" required >
                        <button type = "button" class = "btnBuscarCoordinacion" name = "btnBuscarCoordinacion" id = "btnBuscarCoordinacion">Aceptar</button>
                    </div>

                    <div class = "cmbLicenciatura">
                        <label class = "lblLicenciatura">Licenciatura</label>

                        <select name = "licenciaturas" class = "licenciaturas" id = "licenciaturas" disabled>
                            <option value="0">Selecciona una opcion</option>
                            
                            <?php
                        
                                while($valores = mysqli_fetch_array($result1)){
                                    echo '<option>'.$valores['idLicenciatura'].'.-'.$valores['licenciatura'].'</option>';
                                }

                            ?>
                            
                        </select>
                        
                    </div>

                    <br>
                    <button type = "submit" class = "btnGrabarCoordinacion" name = "btnGrabarCoordinacion" id = "btnGrabarCoordinacion" disabled>Grabar</button>
                    <button type = "submit" class = "btnVerListaCoordinacion" name = "btnVerListaCoordinacion" id = "btnVerListaCoordinacion" onclick="cargaContenido('listaCoordinaciones.php')">Ver Lista</button>
                    <p></p>
                </form>

            </div>
        
        </div>
       

    </body>

</html>

<script type = "text/javascript">
    var nuevaCoordinacion;

    $(function(){    

        $(document).ready(function() {
            
            $('#txtClaveCoordinacion').on('keypress', function(event) {
                
                if (event.which == 13) {
                    event.preventDefault();

                    $('#btnBuscarCoordinacion').click();
                }

            });
            
        });

        $('#btnBuscarCoordinacion').click(function(e){
            e.preventDefault();

            if($('#txtClaveCoordinacion').val() != ''){

                $.post('../controlador/controladorCoordinacion.php', {coordinacion:$('#txtClaveCoordinacion').val(), accion:'buscar'}, function(resp){

                    if(resp != 0){
                        $('#licenciaturas').prop('selectedIndex', resp);
                        document.getElementById("licenciaturas").disabled = false;
                        document.getElementById("txtClaveCoordinacion").disabled = true;
                        document.getElementById("btnGrabarCoordinacion").disabled = false;
                        nuevaCoordinacion = false;
                    }else{

                        Swal.fire({
                            title: "Coordinacion no encontrada, ¿deseas registrarla?",
                            showDenyButton: true,
                            icon: 'question',
                            confirmButtonText: "Si",
                            backdrop: false,
                            denyButtonText: `No`
                            }).then((result) => {

                            if (result.isConfirmed) {
                                document.getElementById("licenciaturas").disabled = false;
                                document.getElementById("btnGrabarCoordinacion").disabled = false;
                                nuevaCoordinacion = true;
                            } else if (result.isDenied) {
                                $('#txtClaveCoordinacion').val('');
                                document.getElementById("licenciaturas").disabled = true;
                            }

                        });

                    }

                });

            }else{
                Swal.fire({
                    icon: "error",
                    title: "No dejes el campo de coordinacion vacio",
                    showConfirmButton: false,
                    backdrop: false,
                    timer: 1500
                });
            }

        });

        $('#btnGrabarCoordinacion').click(function(e){
            e.preventDefault();
            var obj = {
                coordinacion:$('#txtClaveCoordinacion').val(),
                licenciatura:$('#licenciaturas').prop("selectedIndex"),
                nuevaCoordinacion:nuevaCoordinacion, //variable de control para actualizar o registrar una nueva coordinacion
                accion:'grabar'
            };

            $.post('../controlador/controladorCoordinacion.php', obj, function(resp){

                if(resp == 'success'){

                    Swal.fire({
                        icon: "success",
                        title: "Coordinacion grabada correctamente",
                        showConfirmButton: false,
                        backdrop: false,
                        timer: 1500
                    });

                    $('#txtClaveCoordinacion').val('');
                    $('#licenciaturas').prop('selectedIndex', 0);
                    document.getElementById("licenciaturas").disabled = true;
                    document.getElementById("btnGrabarCoordinacion").disabled = true;
                    document.getElementById("txtClaveCoordinacion").disabled = false;
                }else{

                    Swal.fire({
                        icon: "error",
                        title: "Error al grabar la coordinacion en la base de datos",
                        showConfirmButton: false,
                        backdrop: false,
                        timer: 1500
                    });

                }

            });

        });

    });

    function cargaContenido(url){

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'html',

            success: function(data) {
                $('#contenido').html(data);
            },

            error: function(xhr, status, error) {
                console.error('Error al cargar la página:', error);
            }

        });

    }

</script>