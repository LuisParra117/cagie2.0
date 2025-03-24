<?php
    include("../controlador/conexionBdd.php");

    $query1 = "SELECT * FROM planteles;";
    $result1 = mysqli_query(conectar(), $query1);
?>

<script type = "text/javascript">

    function muestraReporte(urlReporte) {
        var plantel = '';
        
        if($('#planteles').prop("selectedIndex") != 0){
            plantel = $('#planteles').prop("selectedIndex");
        }

        urlReporte = urlReporte + "?plantel=" + encodeURIComponent(plantel);
        window.open(urlReporte, '_blank');
    }

</script>

<!DOCTYPE html>

<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reporte Licenciaturas</title>
        <link rel = "stylesheet" href = "/cagie/css/styleRptLicenciaturas.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" type = "text/javascript"></script>
        <script src="/cagie/js/jquery.js" type = "text/javascript"></script>
    </head>

    <body>
        
        <div class = "window">

            <div class = "catalog">
                <input type = "button" name = "btnCerrarRptLicenciatura" class = "btnCerrarRptLicenciatura" value = "Cerrar" onclick = "window.location.href = '../vistas/home.php'">

                <form id = "frmRptLicenciaturas" method = "POST">
                    <h1 style = "text-align: center; color: black; margin: 20px;">REPORTE DE </h1>
                    <h1 style = "text-align: center; color: black; margin: 20px;">LICENCIATURAS</h1>

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

                    <fieldset>
                        <legend>Generar el reporte</legend>
                        <input type = "button" class = "btnAceptarRptLicenciatura" name = "btnAceptarRptLicenciatura" value = "Aceptar" onclick = "muestraReporte('../reportes/reporteLicenciaturas.php')">
                    </fieldset>

                </form>

            </div>

        </div>
        

    </body>

</html>