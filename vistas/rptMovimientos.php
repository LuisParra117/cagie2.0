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

                    <script>

                        function setTodayDate() {
                            const today = new Date();
                            const year = today.getFullYear();
                            const month = String(today.getMonth() + 1).padStart(2, '0');
                            const day = String(today.getDate()).padStart(2, '0');
                            const formattedDate = `${year}-${month}-${day}`;
                            
                            const fechaInicial = document.getElementById('fechaInicial');
                            const fechaFinal = document.getElementById('fechaFinal');
                            
                            fechaInicial.setAttribute('value', formattedDate);
                            fechaFinal.setAttribute('value', formattedDate);
                            
                            fechaInicial.value = formattedDate;
                            fechaFinal.value = formattedDate;
                            fechaInicial.dispatchEvent(new Event('change', { bubbles: true }));
                            fechaFinal.dispatchEvent(new Event('change', { bubbles: true }));

                            fechaInicial.dispatchEvent(new Event('input', { bubbles: true }));
                            fechaFinal.dispatchEvent(new Event('input', { bubbles: true }));
                        }

                        window.onload = setTodayDate;
                    </script>

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

    function muestraReporte(urlReporte) {
        var plantel = '';
        var licenciatura = '';
        var aula = '';
        var fechaInicial = $('#fechaInicial').val();
        var fechaFinal = $('#fechaFinal').val();
        
        if($('#planteles').prop("selectedIndex") != 0 ){
            plantel = $('#planteles').prop("selectedIndex");
        }

        if($('#licenciaturas').prop("selectedIndex") != 0){
            licenciatura = $('#licenciaturas').prop("selectedIndex");
        }

        if($('#aulas').prop("selectedIndex") != 0){
            aula = $('#aulas').prop("selectedIndex");
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