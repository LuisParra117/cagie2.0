<?php
    include("../controlador/conexionBdd.php");

    $query1 =  "SELECT c.coordinacion, l.licenciatura AS licenciatura
                FROM coordinaciones AS c
                JOIN licenciaturas AS l ON c.licenciatura = l.idLicenciatura
                ORDER BY idLicenciatura;";
    $result1 = mysqli_query(conectar(), $query1);
?>

<!DOCTYPE html>

    <html lang="es">
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/styleListaCoordinaciones.css" rel="stylesheet" >
        <title>Lista Coordinaciones</title>
    </head>

    <body>

    <div class = "listaCoordinaciones">
        <input type = "button" name = "btnCerrar" class = "btnCerrar" value = "Cerrar" onclick = "window.location.href = '../vistas/home.php'">        

        <form id = "frmListaCoordinaciones" method = "POST">
            <h1 style = "text-align: center; color: black; margin: 20px;">LISTA DE COORDINACIONES</h1>

            <table class="tablaCoordinaciones">

                <thead>
                    <tr>
                    <th scope="col">Coordinacion</th>
                    <th scope="col">Licenciatura</th>
                    </tr>
                </thead>

                <tbody>

                    <?php
                        while ($fila = mysqli_fetch_assoc($result1)) {
                            echo "<tr>";
                            echo "<td>" . $fila['coordinacion'] . "</td>";
                            echo "<td>" . $fila['licenciatura'] . "</td>";
                            echo "</tr>";
                        }
                    ?>

                </tbody>

            </table>

        </form>

    </div>
        
    </body>

</html>