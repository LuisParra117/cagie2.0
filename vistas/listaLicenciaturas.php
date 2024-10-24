<?php
    include("../controlador/conexionBdd.php");

    $query1 =  "SELECT l.licenciatura, clavePlantel AS plantel
                FROM licenciaturas AS l
                JOIN planteles AS p ON l.plantel = p.idPlantel
                ORDER BY plantel desc;";
    $result1 = mysqli_query(conectar(), $query1);
?>

<!DOCTYPE html>

    <html lang="es">
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/styleListaLicenciaturas.css" rel="stylesheet" >
        <title>Lista Licenciaturas</title>
    </head>

    <body>

    <div class = "listaLicenciaturas">
        <input type = "button" name = "btnCerrar" class = "btnCerrar" value = "Cerrar" onclick = "window.location.href = '../vistas/home.php'">        

        <form id = "frmListaLicenciaturas" method = "POST">
            <h1 style = "text-align: center; color: black; margin: 20px;">LISTA DE LICENCIATURAS</h1>

            <table class="tablaLicenciaturas">

                <thead>
                    <tr>
                    <th scope="col">Licenciatura</th>
                    <th scope="col">Plantel</th>
                    </tr>
                </thead>

                <tbody>

                    <?php
                        while ($fila = mysqli_fetch_assoc($result1)) {
                            echo "<tr>";
                            echo "<td>" . $fila['licenciatura'] . "</td>";
                            echo "<td>" . $fila['plantel'] . "</td>";
                            echo "</tr>";
                        }
                    ?>

                </tbody>

            </table>

        </form>

    </div>
        
    </body>

</html>