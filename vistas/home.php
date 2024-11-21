<?php
session_start();

if (!isset($_SESSION['usuarioLogueado']) == true) {
    header('Location:/cagie/index.php');
    die();
}else{
    ?>

    <!DOCTYPE html>

    <html lang="es">

        <head>
            <meta charset = "UTF-8">
            <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
            <title>Menu Principal</title>
            <link rel = "stylesheet" href = "/cagie/css/styleHome.css">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
            <script src="/cagie/css/sweetalert.css"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
            <script src="/cagie/js/sweetalert.js" type = "text/javascript"></script>
            <link rel="apple-touch-icon" sizes="57x57" href="/cagie/img/favicon/apple-icon-57x57.png">
            <link rel="apple-touch-icon" sizes="60x60" href="/cagie/img/favicon/apple-icon-60x60.png">
            <link rel="apple-touch-icon" sizes="72x72" href="/cagie/img/favicon/apple-icon-72x72.png">
            <link rel="apple-touch-icon" sizes="76x76" href="/cagie/img/favicon/apple-icon-76x76.png">
            <link rel="apple-touch-icon" sizes="114x114" href="/cagie/img/favicon/apple-icon-114x114.png">
            <link rel="apple-touch-icon" sizes="120x120" href="/cagie/img/favicon/apple-icon-120x120.png">
            <link rel="apple-touch-icon" sizes="144x144" href="/cagie/img/favicon/apple-icon-144x144.png">
            <link rel="apple-touch-icon" sizes="152x152" href="/cagie/img/favicon/apple-icon-152x152.png">
            <link rel="apple-touch-icon" sizes="180x180" href="/cagie/img/favicon/apple-icon-180x180.png">
            <link rel="icon" type="image/png" sizes="192x192"  href="/cagie/img/favicon/android-icon-192x192.png">
            <link rel="icon" type="image/png" sizes="32x32" href="/cagie/img/favicon/favicon-32x32.png">
            <link rel="icon" type="image/png" sizes="96x96" href="/cagie/img/favicon/favicon-96x96.png">
            <link rel="icon" type="image/png" sizes="16x16" href="/cagie/img/favicon/favicon-16x16.png">
            <link rel="manifest" href="/cagie/img/favicon/manifest.json">
            <meta name="msapplication-TileColor" content="#ffffff">
            <meta name="msapplication-TileImage" content="/cagie/img/favicon/ms-icon-144x144.png">
            <meta name="theme-color" content="#ffffff">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" type = "text/javascript"></script>
            <script src="/cagie/js/jquery.js" type = "text/javascript"></script>
        </head>

        <body>

            <div class = "fondo">
                
                <div class = "content">
                    <img src  = "/cagie/img/logoGrandeUnedl.png" alt = "Logo unedl" width = "625" height = "300">
                    <img src  = "/cagie/img/cagieGrande.png" alt = "Logo cagie" width = "300" height = "300">
                </div>

            </div>

            <nav>

                <ul class =  "menuHorizontal">

                    <li>
                        <a href="#Catalogos">Catálogos</a>

                        <ul class = "menuCatalogos">
                            <li><a href = "#Aulas" onclick="cargaContenido('catalogoAulas.php')">Aulas</a></li>
                            <li><a href = "#Planteles" onclick="cargaContenido('catalogoPlanteles.php')">Planteles</a></li>
                            <li><a href = "#Licenciaturas" onclick="cargaContenido('catalogoLicenciaturas.php')">Licenciaturas</a></li>
                            <li><a href = "#Coordinaciones" onclick="cargaContenido('catalogoCoordinaciones.php')">Coordinaciones</a></li>
                            <li><a href = "#Usuarios" onclick="cargaContenido('catalogoUsuarios.php')">Usuarios</a></li>
                        </ul>

                    </li>

                    <li>
                        <a href="#Movimientos">Movimientos</a>

                        <ul class = "menuMovimientos">
                            <li><a href = "#monitoreoAulas" onclick="cargaContenido('monitoreoInstalaciones.php')">Monitoreo de Aulas</a></li>
                        </ul>

                    </li>

                    <li>
                        <a href="#Reportes">Reportes</a>

                        <ul class = "menuReportes">
                            <li><a href = "#reporteAulas" onclick="cargaContenido('rptAulas.php')">Reporte de Aulas</a></li>
                            <li><a href = "#reporteMovimientos" onclick="cargaContenido('rptMovimientos.php')">Reporte de Movimientos</a></li>
                            <li><a href = "#reporteLicenciaturas" onclick="cargaContenido('rptLicenciaturas.php')">Reporte de Licenciaturas</a></li>
                        </ul>

                    </li>

                    <li>
                        <a href="#Informacion">Información</a>

                        <ul class = "menuInformacion">
                            <li><a href = "#acercaDe" id = "acercaDe" >Acerca de</a></li>
                        </ul>

                    </li>

                    <li>
                        <a href="#Opciones">Opciones</a>

                        <ul class = "MenuOpciones">
                            <li><a id = "salir" href = "#salir" >Salir</a></li>
                            <!-- onclick = "window.location.href = '../index.php'; " -->
                        </ul>

                    </li>

                    <p style = "text-align: center;" >Bienvenido <?php echo $_SESSION['nombreUsuario'] ?></p>
                </ul>
                
            </nav>

            <div id="contenido" class = "contenido">
            <!-- Aquí se cargará el contenido de la página -->
            </div>

        </body>

    </html>

    <script>

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

        $(function (){

            $('#acercaDe').click(function(){

                Swal.fire({
                    html: '<div style="text-align: justify;">El sistema de Control Administrativo y Gestión de Instalaciones Escolares fue diseñado y pensado como una solución de control y lógistica para las instalaciones que requieren monitorear el acceso al mismo. CAGIE es capaz de aplicar control en los accesos de las instalaciones donde se desee tener un monitoreo total de: aulas, auditorios, oficinas, salas de juntas, etc, aplicando auditoria dando a conocer información como: día, hora, persona, rol de cada acceso que tiene cualquiera de las instalaciones. <br><br>Desarrolladores: <br>Luis Gilberto Parra López <br>Maximiliano Garibay Ramirez</div>',
                    icon: 'info',
                    title: 'Acerca De',
                    confirmButtonColor: '#3085d6',
                    backdrop: false,
                    confirmButtonText: 'OK'
                });

            });

            $('#salir').click(function(){

                Swal.fire({
                    title: "¿Deseas cerrar sesión?",
                    icon: "warning",
                    showCancelButton: true,
                    cancelButtonText: "Cancelar",
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    backdrop: false,
                    confirmButtonText: "Confirmar"
                }).then((result) => {

                    if (result.isConfirmed) {

                        $.post('../controlador/cerrarSesion.php', {}, function(resp){
                            window.location.reload();
                        });

                    }

                });

            });

        });

    </script>

    <?php
}

?>