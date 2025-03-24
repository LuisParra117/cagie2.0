<?php
    include("../controlador/conexionBdd.php");

    $query1 = "SELECT * FROM planteles;";
    $result1 = mysqli_query(conectar(), $query1);
    
    $query2 = "SELECT * FROM licenciaturas;";
    $result2 = mysqli_query(conectar(), $query2);
    
    $query3 = "SELECT * FROM aulas;";
    $result3 = mysqli_query(conectar(), $query3);
?>

<!DOCTYPE html>

<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reporte Movimientos</title>
        <link rel = "stylesheet" href = "/cagie/css/styleRptMovimientos.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" type = "text/javascript"></script>
        <script src="/cagie/js/jquery.js" type = "text/javascript"></script>
    </head>

    <body>
        
        <div class = "window">

            <div class = "catalog">
                <input type = "button" name = "btnCerrarRptMovimientos" class = "btnCerrarRptMovimientos" value = "Cerrar" onclick = "window.location.href = '../vistas/home.php'">

                <form id = "frmRptMovimientos" method = "POST">
                    <h1 style = "text-align: center; color: black; margin: 20px;">REPORTE DE MOVIMIENTOS</h1>

                    <div class = "fechas">
                        <label class = "lblFechaInicial" for = "fechaInicial">Fecha Inicial:</label>
                        <input class = "fechaInicial" type="date" id="fechaInicial" name="fechaInicial" min="2024-01-01"/>
                        <label class = "lblFechaFinal" for = "fechaFinal">Fecha Final:</label>
                        <input class = "fechaFinal" type="date" id="fechaFinal" name="fechaFinal" min="2024-01-01"/>
                    </div>

                    <div class = "cmbPlantel">
                        <label class = "lblPlantel">Plantel</label>

                        <select name = "planteles" class = "planteles" id = "planteles">
                            <option value="0">Selecciona una opcion</option>
                            
                            <?php
                        
                                while($valores = mysqli_fetch_array($result1)){
                                    echo '<option>'.$valores['idPlantel'].'.-'.$valores['clavePlantel'].'</option>';
                                }

                            ?>
                                
                        </select>

                    </div>

                    <div class = "cmbLicenciatura">
                        <label class = "lblLicenciatura">Licenciatura</label>

                        <select name = "licenciaturas" class = "licenciaturas" id = "licenciaturas">
                            <option value="0">Selecciona una opcion</option>
                            
                            <?php
                        
                                while($valores = mysqli_fetch_array($result2)){
                                    echo '<option>'.$valores['idLicenciatura'].'.-'.$valores['licenciatura'].'</option>';
                                }

                            ?>
                                
                        </select>

                    </div>

                    <div class = "cmbAula">
                        <label class = "lblAula">Aula</label>

                        <select name = "aulas" class = "aulas" id = "aulas" >
                            <option value="0">Selecciona una opcion</option>
                            
                            <?php
                        
                                while($valores = mysqli_fetch_array($result3)){
                                    echo '<option>'.$valores['idAula'].'.-'.$valores['aula'].'</option>';
                                }

                            ?>
                                
                        </select>

                    </div>

                    <fieldset>
                        <legend>Generar el reporte</legend>
                        <input type = "button" class = "btnAceptarRptMovimientos" name = "btnAceptarRptMovimientos" value = "Aceptar" onclick="muestraReporte('../reportes/reporteMovimientos.php')">
                    </fieldset>
                    
                </form>

            </div>
        </div>
        

    </body>

</html>


<script type = "text/javascript">

    function setFechas() {
        // Fecha actual
        var today = new Date();
        var day = String(today.getDate()).padStart(2, '0');
        var month = String(today.getMonth() + 1).padStart(2, '0');
        var year = today.getFullYear();
        var currentDate = year + '-' + month + '-' + day;

        // Establecer la fecha en el campo de fecha final
        $("#fechaFinal").val(currentDate);

        // Restar 7 días para la fecha inicial
        today.setDate(today.getDate() - 7);  // Restar 7 días
        var initDay = String(today.getDate()).padStart(2, '0');
        var initMonth = String(today.getMonth() + 1).padStart(2, '0'); // Los meses son de 0-11
        var initYear = today.getFullYear();
        var initialDate = initYear + '-' + initMonth + '-' + initDay;

        // Establecer la fecha en el campo de fecha inicial
        $("#fechaInicial").val(initialDate);
    }

    function muestraReporte(urlReporte) {
        var plantel = '';
        var licenciatura = '';
        var aula = '';
        var fechaInicial = $('#fechaInicial').val();
        var fechaFinal = $('#fechaFinal').val();
        
        if($('#planteles').prop("selectedIndex") != 0){
            plantel = $('#planteles').val().split(".-")[0]; // Extrae el número antes del ".-"
        }

        if($('#licenciaturas').prop("selectedIndex") != 0){
            licenciatura = $('#licenciaturas').val().split(".-")[0]; // Extrae el número antes del ".-"
        }

        if($('#aulas').prop("selectedIndex") != 0){
            aula = $('#aulas').val().split(".-")[0]; // Extrae el número antes del ".-"
        }

        urlReporte = urlReporte + "?plantel=" + encodeURIComponent(plantel) + "&licenciatura=" + encodeURIComponent(licenciatura) +
                        "&aula=" + encodeURIComponent(aula) + "&fechaInicial=" + encodeURIComponent(fechaInicial) +
                        "&fechaFinal=" + encodeURIComponent(fechaFinal);
        window.open(urlReporte, '_blank');
    }

    $('#planteles').change(function(){

        if($('#planteles').prop("selectedIndex") != 0 ){
            $('#aulas').prop('selectedIndex', 0);
            $('#licenciaturas').prop('selectedIndex', 0);
        }

    });

    $('#licenciaturas').change(function(){

        if($('#licenciaturas').prop("selectedIndex") != 0){
            $('#aulas').prop('selectedIndex', 0);
            $('#planteles').prop('selectedIndex', 0);
        }
        
    });

    $('#aulas').change(function(){

        if($('#aulas').prop("selectedIndex") != 0){
            $('#planteles').prop('selectedIndex', 0);
            $('#licenciaturas').prop('selectedIndex', 0);
        }
    });

</script>