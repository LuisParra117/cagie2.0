<?php
    include("../controlador/conexionBdd.php");
    session_start();

    $credencial = $_SESSION['credencialUsuario'];

    $query1 = "SELECT * FROM planteles;";
    $result1 = mysqli_query(conectar(), $query1);

    $query2 = "SELECT * FROM licenciaturas;";
    $result2 = mysqli_query(conectar(), $query2);

    $query3 = "SELECT * FROM coordinaciones;";
    $result3 = mysqli_query(conectar(), $query3);


    $query4 =  "SELECT aula FROM aulas
                WHERE licenciatura = '" . $_SESSION['licenciaturaUsuario'] . "'
                AND coordinacion = '" . $_SESSION['coordinacionUsuario'] . "';";
    $result4 = mysqli_query(conectar(),$query4);

    while($row4 = mysqli_fetch_array($result4)){
        $aulas[] = $row4['aula'];
    }

    function getEstatus($posicion, $arreglo){
        $query5 = "SELECT estatus FROM aulas WHERE aula = '" . $arreglo[$posicion] . "';";
        $result5 = mysqli_query(conectar(), $query5);

        if($result5){
            $row5 = mysqli_fetch_assoc($result5);

            if($row5 > 0){
                $estatus = $row5['estatus'];
            }

        }

        return $estatus;
    }

?>

<!DOCTYPE html>

<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Monitoreo Instalaciones</title>
        <link rel = "stylesheet" href = "/cagie/css/styleMonitoreo.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" type = "text/javascript"></script>
        <script src="/cagie/js/jquery.js" type = "text/javascript"></script>
        <link href = "../css/bootstrap-grid.css" rel ="stylesheet">
    </head>
    
    <body>
        
        <div class = "catalogo">
        
            <form id = "frmMonitoreo" method = "POST">
                <h1 style = "text-align: center; color: black; margin: 20px; top:-10px;">MONITOREO DE INSTALACIONES</h1>
                
                <?php
                    
                    if($_SESSION['nombreUsuario'] == 'Luis Gilberto Parra Lopez'){
                        echo '<h2 style ="text-align: center;">Aulas de la Licenciatura: Ingeniería de Software</h2>';
                    }else{
                        echo '<h2 style ="text-align: center;">Aulas de la Licenciatura: Derecho</h2>';
                    }

                    
                ?>
                
               
                <br>

                <!-- <button type = "submit" class = "btnAceptar" name = "btnAceptar" id = "btnAceptar">Aceptar</button> -->
                <input type = "button" name = "btnCerrar" class = "btnCerrar" value = "Cerrar" onclick = "window.location.href = '../vistas/home.php'">
                
                <div class = "panelAulas">
                    
                    <div class="container text-center">

                        <div class = "row row-cols-3">

                            <?php                    
                                
                                $cantidadAulas = count($aulas);

                                for($i = 0; $i < $cantidadAulas; $i++){
                                    
                                    $est = getEstatus($i, $aulas);

                                    if($est == "1"){
                                        echo '<div class="col"><img credencial = "' . $credencial . '" estatus = "1" aula = "' . $aulas[$i] . '" id = "' . $aulas[$i] . '"src="/cagie/img/puertaAbierta.png" alt="Puerta Abierta" width="40" height="40"><p style="display: inline-block; vertical-align: top;">' . $aulas[$i] . '</p><p></p></div>';
                                    }else{
                                        echo '<div class="col"><img credencial = "' . $credencial . '" estatus = "0" aula = "' . $aulas[$i] . '" id = "' . $aulas[$i] . '"src="/cagie/img/puertaCerrada.png" alt="Puerta Cerrada" width="40" height="40"><p style="display: inline-block; vertical-align: top;">' . $aulas[$i] . '</p><p></p></div>';
                                    }
                                    
                                }
                                
                            ?>

                            <p></p>
                        </div>

                    </div>
                    
                </div>

            </form>

        </div>

    </body>

</html>

<script text = "javascript">

    $(function(){
        
        $('img').click(function(){
            var aula=$(this).attr('aula');
            var estatus=$(this).attr('estatus');
            var credencial=$(this).attr('credencial');

            var objAcceso = {
                aula:aula,
                estatus:estatus,
                credencial:credencial
            };

            $.post('../controlador/controladorMonitoreo.php', objAcceso, function(resp){
                var acceso = document.getElementById(aula);
                
                if(resp == 'apertura'){
                    acceso.setAttribute("src", "/cagie/img/puertaAbierta.png");
                    acceso.setAttribute("estatus", "1");
                }else if(resp == 'cierre'){
                    acceso.setAttribute("src", "/cagie/img/puertaCerrada.png");
                    acceso.setAttribute("estatus", "0");
                }

            });

        });

    });

</script>