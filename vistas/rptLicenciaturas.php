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
        
        <div class = "catalogo">
            <input type = "button" name = "btnCerrar" class = "btnCerrar" value = "Cerrar" onclick = "window.location.href = '../vistas/home.php'">

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
                <p></p>

                <fieldset>
                    <legend>Generar el reporte</legend>
                    <p></p>
                    <p></p>
                    <!-- <label>
                        <input class = "rdPantalla" type ="radio" id="pantalla" name ="reporte" value = "Pantalla">Pantalla
                    </label>

                    <label>
                        <input class = "rdExcel" type ="radio" id="excel" name ="reporte" value = "Excel">Excel
                    </label>

                    <label>
                        <input class = "rdPdf" type ="radio" id="pdf" name ="reporte" value = "Pdf">Pdf
                    </label> -->
                    
                    <input type = "button" class = "btnAceptar" name = "btnAceptar" value = "Aceptar" onclick = "muestraReporte('../reportes/reporteLicenciaturas.php')">
                </fieldset>
                
                <p></p>

            </form>

        </div>

    </body>

</html>