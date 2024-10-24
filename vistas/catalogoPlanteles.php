<?php
    include("../controlador/conexionBdd.php");

    $query1 = "SELECT * FROM colonias;";
    $result1 = mysqli_query(conectar(), $query1);
    
    $query2 = "SELECT * FROM codigosPostales;";
    $result2 = mysqli_query(conectar(), $query2);
    
    $query3 = "SELECT * FROM localidades;";
    $result3 = mysqli_query(conectar(), $query3);

    $query4 = "SELECT * FROM estados;";
    $result4 = mysqli_query(conectar(), $query4);
?>

<!DOCTYPE html>

<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Catalogo Planteles</title>
        <link rel = "stylesheet" href = "/cagie/css/styleCatPlanteles.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" type = "text/javascript"></script>
        <script src="/cagie/js/jquery.js" type = "text/javascript"></script>
        <script src="/cagie/js/sweetalert.js" type = "text/javascript"></script>
    </head>
    
    <body>
        
        <div class = "catalogo">
            <input type = "button" name = "btnCerrar" class = "btnCerrar" value = "Cerrar" onclick = "window.location.href = '../vistas/home.php'">
            
            <form id = "frmCatCoordinaciones" method = "POST">
                <h1 style = "text-align: center; color: black; margin: 20px; top:-10px;">CATALOGO DE PLANTELES</h1>

                <div class = "txtClavePlantel">
                    
                    <input type = "text" id = "txtClavePlantel" name = "txtClavePlantel" id = "txtClavePlantel" required >
                    <label id = "lblClavePlantel">Plantel</label>
                </div>
                
                <div class = "txtCalle">
                    <input type = "text" id = "txtCalle" name = "txtCalle" id = "txtCalle" required disabled>
                    <label>Calle</label>
                </div>

                <div class = "txtExterior">
                    <input type = "text" id = "txtExterior" name = "txtExterior" id = "txtExterior" required disabled>
                    <label>Numero Exterior</label>
                </div>

                <div class = "txtInterior">
                    <input type = "text" id = "txtInterior" name = "txtInterior" id = "txtInterior" required disabled>
                    <label>Numero Interior</label>
                </div>
                <p>‎ </p>
                <p>‎ </p>
                <div class = "txtLatitud">
                    <input type = "text" id = "txtLatitud" name = "txtLatitud"  id = "txtLatitud" required disabled>
                    <label>Latitud</label>
                </div>

                <div class = "txtLongitud">
                    <input type = "text" id = "txtLongitud" name = "txtLongitud" id = "txtLongitud" required disabled>
                    <label>Longitud</label>
                </div>                

                <div class = "cmbCodigoPostal">
                    <label class ="lblCodigoPostal" >Codigo Postal</label>

                    <select name = "codigosPostales" class = "codigosPostales" id = "codigosPostales" disabled>
                        <option value="0">Selecciona una opcion</option>
                        
                        <?php
                    
                            while($valores = mysqli_fetch_array($result2)){
                                echo '<option>'.$valores['idCodigoPostal'].'.-'.$valores['codigoPostal'].'</option>';
                            }

                        ?>
                        
                    </select>

                </div>
                
                <div class = "cmbColonia">
                    <label class ="lblColonia" >Colonia</label>

                    <select name = "colonias" class = "colonias" id = "colonias" disabled>
                        <option value="0">Selecciona una opcion</option>
                        
                        <?php
                    
                            while($valores = mysqli_fetch_array($result1)){
                                echo '<option>'.$valores['idColonia'].'.-'.$valores['colonia'].'</option>';
                            }

                        ?>
                        
                    </select>

                </div>

                <div class = "cmbLocalidad">
                    <label class ="lblLocalidad" >Localidad</label>

                    <select name = "localidades" class = "localidades" id = "localidades" disabled>
                        <option value="0">Selecciona una opcion</option>
                        
                        <?php
                    
                            while($valores = mysqli_fetch_array($result3)){
                                echo '<option>'.$valores['idLocalidad'].'.-'.$valores['localidad'].'</option>';
                            }

                        ?>
                        
                    </select>

                </div>

                <div class = "cmbEstado">
                    <label class ="lblEstado" >Estado</label>

                    <select name = "estados" class = "estados" id = "estados" disabled>
                        <option value="0">Selecciona una opcion</option>
                        
                        <?php
                    
                            while($valores = mysqli_fetch_array($result4)){
                                echo '<option>'.$valores['idEstado'].'.-'.$valores['estado'].'</option>';
                            }

                        ?>
                        
                    </select>

                </div>
                
                <br>
                <p>‎ </p>
                <button type = "submit" class = "btnAceptar" name = "btnAceptar" id ="btnAceptar">Aceptar</button>
                <p>‎ </p>
                <button type = "submit" class = "btnGrabar" name = "btnGrabar" id = "btnGrabar" disabled>Grabar</button>
                <button type = "submit" class = "btnVerLista" name = "btnVerLista" id = "btnVerLista" onclick="cargaContenido('listaPlanteles.php')">Ver Lista</button>
                <p></p>
            </form>

        </div>

    </body>

</html>

<script type = "text/javascript">
    var nuevoPlantel;

    $(function(){

        $('#btnAceptar').click(function(e){
            e.preventDefault();

            if($('#txtClavePlantel').val() != ''){

                $.getJSON('../controlador/controladorPlantel.php', {plantel:$('#txtClavePlantel').val(), accion:'buscar'}, function(resp){
                    
                    if(resp != null){
                        activaDesactivaTxt(false);
                        document.getElementById("codigosPostales").disabled = false;
                        document.getElementById("colonias").disabled = false;
                        document.getElementById("localidades").disabled = false;
                        document.getElementById("estados").disabled = false;
                        document.getElementById("btnAceptar").disabled = true;
                        document.getElementById("btnGrabar").disabled = false;
                        document.getElementById("txtClavePlantel").disabled = true;
                        document.getElementById("lblClavePlantel").style = "top: -5px;";
                        $('#codigosPostales').prop('selectedIndex', resp.codigoPostal);
                        $('#colonias').prop('selectedIndex', resp.colonia);
                        $('#localidades').prop('selectedIndex', resp.localidad);
                        $('#estados').prop('selectedIndex', resp.estado);
                        $('#txtCalle').val(resp.calle);
                        $('#txtExterior').val(resp.numeroExterior);
                        $('#txtInterior').val(resp.numeroInterior);
                        $('#txtLatitud').val(resp.latitud);
                        $('#txtLongitud').val(resp.longitud);
                        nuevoPlantel = false;
                    }else{

                        Swal.fire({
                            title: "Plantel no encontrado, ¿deseas registrarlo?",
                            showDenyButton: true,
                            icon: 'question',
                            confirmButtonText: "Si",
                            backdrop: false,
                            denyButtonText: `No`
                            }).then((result) => {

                            if (result.isConfirmed) {
                                document.getElementById("codigosPostales").disabled = false;
                                document.getElementById("colonias").disabled = false;
                                document.getElementById("localidades").disabled = false;
                                document.getElementById("estados").disabled = false;
                                activaDesactivaTxt(false);
                                nuevoPlantel = true;
                            } else if (result.isDenied) {
                                $('#txtClavePlantel').val('');
                                document.getElementById("codigosPostales").disabled = true;
                                document.getElementById("colonias").disabled = true;
                                document.getElementById("localidades").disabled = true;
                                document.getElementById("estados").disabled = true;
                                activaDesactivaTxt(true);
                            }

                        });

                        $('#codigosPostales').prop('selectedIndex', 0);
                        $('#colonias').prop('selectedIndex', 0);
                        $('#localidades').prop('selectedIndex', 0);     
                        $('#estados').prop('selectedIndex', 0);     
                    }

                });

            }else{

                Swal.fire({
                    icon: "error",
                    title: "No dejes el campo de plantel vacio",
                    showConfirmButton: false,
                    backdrop: false,
                    timer: 1500
                });

            }

        });

        $('#btnGrabar').click(function(e){
            e.preventDefault();

            var obj = {
                plantel:$('#txtClavePlantel').val(),
                latitud:$('#txtLatitud').val(),
                longitud:$('#txtLongitud').val(),
                calle:$('#txtCalle').val(),
                numeroExterior:$('#txtExterior').val(),
                numeroInterior:$('#txtInterior').val(),
                codigoPostal:$('#codigosPostales').prop('selectedIndex'),
                colonia:$('#colonias').prop('selectedIndex'),
                localidad:$('#localidades').prop('selectedIndex'),
                estado:$('#estados').prop('selectedIndex'),
                nuevoPlantel:nuevoPlantel,
                accion:'grabar'
            };

            $.post('../controlador/controladorPlantel.php', obj, function(resp){

                if(resp == 'success'){

                    Swal.fire({
                        icon: "success",
                        title: "Plantel grabado correctamente",
                        showConfirmButton: false,
                        backdrop: false,
                        timer: 1500
                    });

                    $('#txtClavePlantel').val('');
                    $('#txtLatitud').val('');
                    $('#txtLongitud').val('');
                    $('#txtCalle').val('');
                    $('#txtExterior').val('');
                    $('#txtInterior').val('');
                    $('#codigosPostales').prop('selectedIndex', 0);
                    $('#colonias').prop('selectedIndex', 0);
                    $('#localidades').prop('selectedIndex', 0);
                    $('#estados').prop('selectedIndex', 0);
                    document.getElementById("codigosPostales").disabled = true;
                    document.getElementById("colonias").disabled = true;
                    document.getElementById("localidades").disabled = true;
                    document.getElementById("estados").disabled = true;
                    document.getElementById("btnAceptar").disabled = false;
                    document.getElementById("btnGrabar").disabled = true;
                    document.getElementById("txtClavePlantel").disabled = false;
                    activaDesactivaTxt(true);
                }else{

                    Swal.fire({
                        icon: "error",
                        title: "Error al grabar el plantel en la base de datos",
                        showConfirmButton: false,
                        backdrop: false,
                        timer: 1500
                    });

                }

            });

        });

    });

    function activaDesactivaTxt(valor){
        document.getElementById("txtCalle").disabled = valor;
        document.getElementById("txtLatitud").disabled = valor;
        document.getElementById("txtLongitud").disabled = valor;
        document.getElementById("txtExterior").disabled = valor;
        document.getElementById("txtInterior").disabled = valor;
    }

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

</script>