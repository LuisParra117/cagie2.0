<?php
    include("../controlador/conexionBdd.php");

    $query1 =  "SELECT aula, clavePlantel AS plantel, l.licenciatura 
                FROM aulas AS a
                JOIN planteles AS p ON a.plantel = p.idPlantel
                JOIN licenciaturas AS l ON a.licenciatura = l.idLicenciatura;";
    $result1 = mysqli_query(conectar(), $query1);
?>

<!DOCTYPE html>

    <html lang="es">
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/styleListaAulas.css" rel="stylesheet" >
        <title>Lista Aulas</title>
    </head>

    <body>

    <div class = "listaAulas">
        <input type = "button" name = "btnCerrar" class = "btnCerrar" value = "Cerrar" onclick = "window.location.href = '../vistas/home.php'">        

        <form id = "frmListaAulas" method = "POST">
            <h1 style = "text-align: center; color: black; margin: 20px;">LISTA DE AULAS</h1>

            <table class="tablaAulas">

                <thead>
                    <tr>
                    <th scope="col">Aula</th>
                    <th scope="col">Plantel</th>
                    <th scope="col">Licenciatura</th>
                    </tr>
                </thead>

                <tbody>

                    <?php
                        while ($fila = mysqli_fetch_assoc($result1)) {
                            echo "<tr>";
                            echo "<td>" . $fila['aula'] . "</td>";
                            echo "<td>" . $fila['plantel'] . "</td>";
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