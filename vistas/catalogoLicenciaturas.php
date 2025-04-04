<?php
    include("../controlador/conexionBdd.php");

    $query1 = "SELECT * FROM planteles;";
    $result1 = mysqli_query(conectar(), $query1);
?>

<!DOCTYPE html>

<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Catalogo Licenciaturas</title>
        <link rel = "stylesheet" href = "/cagie/css/styleCatLicenciaturas.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" type = "text/javascript"></script>
        <script src="/cagie/js/jquery.js" type = "text/javascript"></script>
    </head>

    <body>
        
        <div class = "window">

            <div class = "catalog">
                <input type = "button" name = "btnCerrarLicenciatura" class = "btnCerrarLicenciatura" value = "Cerrar" onclick = "window.location.href = '../vistas/home.php'">        

                <form id = "frmCatLicenciaturas" method = "POST">   
                    <h1 style = "text-align: center; color: black; margin: 20px;">CATALOGO DE </h1>
                    <h1 style = "text-align: center; color: black; margin: 20px;">LICENCIATURAS</h1>

                    <div class = "form-group">
                        <input type = "text" id = "txtClaveLicenciatura" name = "txtClaveLicenciatura" placeholder="Licenciatura" required >
                        <button type = "button" class = "btnBuscarLicenciatura" name = "btnBuscarLicenciatura" id = "btnBuscarLicenciatura">Aceptar</button>
                    </div>

                    

                    <div class = "cmbPlantel">
                        <label class = "lblPlantel">Plantel</label>

                        <select name = "planteles" class = "planteles" id = "planteles" disabled>
                            <option value="0">Selecciona una opcion</option>
                            
                            <?php
                        
                                while($valores = mysqli_fetch_array($result1)){
                                    echo '<option>'.$valores['idPlantel'].'.-'.$valores['clavePlantel'].'</option>';
                                }

                            ?>
                            
                        </select>
                        
                    </div>
                    
                    <br>
                    <button type = "submit" class = "btnGrabarLicenciatura" name = "btnGrabarLicenciatura" id = "btnGrabarLicenciatura" disabled>Grabar</button>
                    <button type = "submit" class = "btnVerListaLicenciatura" name = "btnVerListaLicenciatura" id = "btnVerListaLicenciatura" onclick="cargaContenido('listaLicenciaturas.php')">Ver Lista</button>
                    <p></p>
                </form>

            </div>
        </div>
        

    </body>

</html>

<script type = "text/javascript">
    var nuevaLicenciatura;

    $(function(){

        $(document).ready(function() {
            
            $('#txtClaveLicenciatura').on('keypress', function(event) {
                
                if (event.which == 13) {
                    event.preventDefault();

                    $('#btnBuscarLicenciatura').click();
                }

            });
            
        });

        $('#btnBuscarLicenciatura').click(function(e){
            e.preventDefault();

            if($('#txtClaveLicenciatura').val() != ''){

                $.post('../controlador/controladorLicenciatura.php', {licenciatura:$('#txtClaveLicenciatura').val(), accion:'buscar'}, function(resp){

                    if(resp != 0){
                        $('#planteles').prop('selectedIndex', resp);
                        document.getElementById("planteles").disabled = false;
                        document.getElementById("txtClaveLicenciatura").disabled = true;
                        document.getElementById("btnGrabarLicenciatura").disabled = false;
                        nuevaLicenciatura = false;
                    }else{

                        Swal.fire({
                            title: "Licenciatura no encontrada, ¿deseas registrarla?",
                            showDenyButton: true,
                            icon: 'question',
                            confirmButtonText: "Si",
                            backdrop: false,
                            denyButtonText: `No`
                            }).then((result) => {

                            if (result.isConfirmed) {
                                document.getElementById("planteles").disabled = false;
                                document.getElementById("btnGrabarLicenciatura").disabled = false;
                                nuevaLicenciatura = true;
                            } else if (result.isDenied) {
                                $('#txtClaveLicenciatura').val('');
                                document.getElementById("planteles").disabled = true;
                            }

                        });
                    }

                });

            }else{
                Swal.fire({
                    icon: "error",
                    title: "No dejes el campo de licenciatura vacio",
                    showConfirmButton: false,
                    backdrop: false,
                    timer: 1500
                });
            }

        });

        $('#btnGrabarLicenciatura').click(function(e){
            e.preventDefault();
            var obj = {
                licenciatura:$('#txtClaveLicenciatura').val(),
                plantel:$('#planteles').prop("selectedIndex"),
                nuevaLicenciatura:nuevaLicenciatura, //variable de control para actualizar o registrar una nueva licenciatura
                accion:'Grabar'
            };

            $.post('../controlador/controladorLicenciatura.php', obj, function(resp){

                if(resp == 'success'){

                    Swal.fire({
                        icon: "success",
                        title: "Licenciatura grabada correctamente",
                        showConfirmButton: false,
                        backdrop: false,
                        timer: 1500
                    });

                    $('#txtClaveLicenciatura').val('');
                    $('#planteles').prop('selectedIndex', 0);
                    document.getElementById("planteles").disabled = true;
                    document.getElementById("btnGrabarLicenciatura").disabled = true;
                    document.getElementById("txtClaveLicenciatura").disabled = false;
                }else{

                    Swal.fire({
                        icon: "error",
                        title: "Error al grabar la licenciatura en la base de datos",
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