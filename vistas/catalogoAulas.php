<?php
    include("../controlador/conexionBdd.php");

    $query1 = "SELECT * FROM planteles;";
    $result1 = mysqli_query(conectar(), $query1);
    
    $query2 = "SELECT * FROM licenciaturas;";
    $result2 = mysqli_query(conectar(), $query2);
    
    $query3 = "SELECT * FROM coordinaciones;";
    $result3 = mysqli_query(conectar(), $query3);
?>

<!DOCTYPE html>

<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Catalogo de Aulas</title>
        <link rel = "stylesheet" href = "/cagie/css/styleCatAulas.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" type = "text/javascript"></script>
        <script src="/cagie/js/jquery.js" type = "text/javascript"></script>
        <script src="/cagie/js/sweetalert.js" type = "text/javascript"></script>
    </head>

    <body>
        
        <div class = "window">

            <div class = "catalog">
                <input type = "button" name = "btnCerrarAula" class = "btnCerrarAula" value = "Cerrar" onclick = "window.location.href = '../vistas/home.php'">        
                
                <form id = "frmCatAulas" method = "POST">    
                    <h1 style = "text-align: center; color: black; margin: 20px;">CATALOGO DE AULAS</h1>
                    
                    <div class="form-group">
                        <input type = "text" id = "txtClaveAula" name = "txtClaveAula" placeholder="Aula" required >
                        <button type = "button" class = "btnBuscarAula" name = "btnBuscarAula" id = "btnBuscarAula">Aceptar</button>
                    </div>
                    

                    <div class = "cmbPlantel">
                        <label class ="lblPlantel" >Plantel</label>

                        <select name = "planteles" class = "planteles" id ="planteles" disabled>
                            <option value="0">Selecciona una opcion</option>
                            
                            <?php
                        
                                while($valores = mysqli_fetch_array($result1)){
                                    echo '<option>'.$valores['idPlantel'].'.-'.$valores['clavePlantel'].'</option>';
                                }

                            ?>
                            
                        </select>

                    </div>
                    
                    <br>

                    <div class = "cmbLicenciatura">
                        <label class ="lblLicenciatura">Licenciatura</label>
                        
                        <select name = "licenciaturas" class= "licenciaturas" id = "licenciaturas" disabled>
                            <option value="0">Selecciona una opcion</option>
                            
                            <?php

                                while($valores = mysqli_fetch_array($result2)){
                                    echo '<option>'.$valores['idLicenciatura'].'.-'.$valores['licenciatura'].'</option>';
                                }

                            ?>

                        </select>

                    </div>

                    <br>

                    <div class = "cmbCoordinacion">
                        <label class ="lblCoordinacion">Coordinacion</label>

                        <select name = "coordinaciones" class = "coordinaciones" id = "coordinaciones" disabled>
                            <option value="0">Selecciona una opcion</option>
                            
                            <?php

                                while($valores = mysqli_fetch_array($result3)){
                                    echo '<option>'.$valores['idCoordinacion'].'.-'.$valores['coordinacion'].'</option>';
                                }

                            ?>

                        </select>

                    </div>
                    
                    <br>

                    <button type = "submit" class = "btnGrabarAula" name = "btnGrabarAula" id = "btnGrabarAula" disabled>Grabar</button>
                    <button type = "submit" class = "btnVerListaAula" name = "btnVerListaAula" id = "btnVerListaAula" onclick="cargaContenido('listaAulas.php')">Ver Lista</button>
                    <p></p>

                    <div id="contenido" class = "contenido">
                    <!-- Aquí se cargará el contenido de la página -->
                    </div>

                </form>  

            </div>

        </div>

    </body>

</html>

<script type = "text/javascript">
    var nuevaAula;

    $(function(){

        $('#btnBuscarAula').click(function(e){
            e.preventDefault();

            if($('#txtClaveAula').val() != ''){

                $.getJSON('../controlador/controladorAula.php', {aula:$('#txtClaveAula').val(), accion:'buscar'}, function(resp){
                
                    if(resp != null){
                        document.getElementById("planteles").disabled = false;
                        document.getElementById("licenciaturas").disabled = false;
                        document.getElementById("coordinaciones").disabled = false;
                        document.getElementById("btnBuscarAula").disabled = true;
                        document.getElementById("btnGrabarAula").disabled = false;
                        document.getElementById("txtClaveAula").disabled = true;
                        $('#planteles').prop('selectedIndex', resp.plantel);
                        $('#licenciaturas').prop('selectedIndex', resp.licenciatura);
                        $('#coordinaciones').prop('selectedIndex', resp.coordinacion);
                        nuevaAula = false;
                    }else{

                        Swal.fire({
                            title: "Aula no encontrada, ¿deseas registrarla?",
                            showDenyButton: true,
                            icon: 'question',
                            confirmButtonText: "Si",
                            backdrop: false,
                            denyButtonText: `No`
                            }).then((result) => {

                            if (result.isConfirmed) {
                                document.getElementById("planteles").disabled = false;
                                document.getElementById("licenciaturas").disabled = false;
                                document.getElementById("coordinaciones").disabled = false;
                                nuevaAula = true;
                            } else if (result.isDenied) {
                                $('#txtClaveAula').val('');
                                document.getElementById("planteles").disabled = true;
                                document.getElementById("licenciaturas").disabled = true;
                                document.getElementById("coordinaciones").disabled = true;
                            }

                        });

                        $('#planteles').prop('selectedIndex', 0);
                        $('#licenciaturas').prop('selectedIndex', 0);
                        $('#coordinaciones').prop('selectedIndex', 0);                    
                    }
                    
                });

            }else{

                Swal.fire({
                    icon: "error",
                    title: "No dejes el campo de aula vacio",
                    showConfirmButton: false,
                    backdrop: false,
                    timer: 1500
                });

            }            

        });

        $('#btnGrabarAula').click(function(e){
            e.preventDefault();

            var objAula = {
                aula:$('#txtClaveAula').val(),
                plantel:$('#planteles').prop("selectedIndex"),
                licenciatura:$('#licenciaturas').prop("selectedIndex"),
                coordinacion:$('#coordinaciones').prop("selectedIndex"),
                nuevaAula:nuevaAula, //variable de control para actualizar o registrar una nueva aula
                accion:'grabar'
            };

            $.post('../controlador/controladorAula.php', objAula, function(resp){
                
                if(resp == 'success'){

                    Swal.fire({
                        icon: "success",
                        title: "Aula grabada correctamente",
                        showConfirmButton: false,
                        backdrop: false,
                        timer: 1500
                    });

                    $('#txtClaveAula').val('');
                    $('#planteles').prop('selectedIndex', 0);
                    $('#licenciaturas').prop('selectedIndex', 0);
                    $('#coordinaciones').prop('selectedIndex', 0);  
                    document.getElementById("planteles").disabled = true;
                    document.getElementById("licenciaturas").disabled = true;
                    document.getElementById("coordinaciones").disabled = true;
                    document.getElementById("btnBuscarAula").disabled = false;
                    document.getElementById("btnGrabarAula").disabled = true;
                    document.getElementById("txtClaveAula").disabled = false;
                }else{
                    
                    Swal.fire({
                        icon: "error",
                        title: "Error al grabar el aula en la base de datos",
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