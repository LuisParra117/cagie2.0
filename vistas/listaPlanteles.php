<?php
    include("../controlador/conexionBdd.php");

    $query1 =  "SELECT clavePlantel
                FROM planteles;";
    $result1 = mysqli_query(conectar(), $query1);
?>

<!DOCTYPE html>

    <html lang="es">
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/styleListaPlanteles.css" rel="stylesheet" >
        <title>Lista Planteles</title>
    </head>

    <body>

    <div class = "listaPlanteles">
        <input type = "button" name = "btnCerrar" class = "btnCerrar" value = "Cerrar" onclick = "window.location.href = '../vistas/home.php'">        

        <form id = "frmListaPlanteles" method = "POST">
            <h1 style = "text-align: center; color: black; margin: 20px;">LISTA DE PLANTELES</h1>

            <table class="tablaPlanteles">

                <thead>
                    <tr>
                    <th scope="col">Plantel</th>
                    </tr>
                </thead>

                <tbody>

                    <?php
                        while ($fila = mysqli_fetch_assoc($result1)) {
                            echo "<tr>";
                            echo "<td>" . $fila['clavePlantel'] . "</td>";
                            echo "</tr>";
                        }
                    ?>

                </tbody>

            </table>

        </form>

    </div>
        
    </body>

</html>