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
        
        <div class = "window">

            <div class = "catalog">
                <input type = "button" name = "btnCerrarPlantel" class = "btnCerrarPlantel" value = "Cerrar" onclick = "window.location.href = '../vistas/home.php'">
                
                <form id = "frmCatCoordinaciones" method = "POST">
                    <h1 style = "text-align: center; color: black; margin: 20px; top:-10px;">CATALOGO DE PLANTELES</h1>

                    <div class = "form-group">
                        <input type = "text" id = "txtClavePlantel" name = "txtClavePlantel" id = "txtClavePlantel" placeholder="Plantel" required >
                        <button type = "button" class = "btnBuscarPlantel" name = "btnBuscarPlantel" id ="btnBuscarPlantel">Aceptar</button>
                    </div>
                    
                    <input type = "text" id = "txtCalle" name = "txtCalle" id = "txtCalle" placeholder="Calle" required disabled>
                    <input type = "text" id = "txtExterior" name = "txtExterior" id = "txtExterior" placeholder="Numero Exterior"required disabled>
                    <input type = "text" id = "txtInterior" name = "txtInterior" id = "txtInterior" placeholder="Numero Interior" required disabled>            

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
                                        
                    <button type = "submit" class = "btnGrabarPlantel" name = "btnGrabarPlantel" id = "btnGrabarPlantel" disabled>Grabar</button>
                    <button type = "submit" class = "btnVerListaPlantel" name = "btnVerListaPlantel" id = "btnVerListaPlantel" onclick="cargaContenido('listaPlanteles.php')">Ver Lista</button>
                </form>

            </div>

        </div>

    </body>

</html>

<script type = "text/javascript">
    var nuevoPlantel;

    $(function(){

        $(document).ready(function() {
            
            $('#txtClavePlantel').on('keypress', function(event) {
                
                if (event.which == 13) {
                    event.preventDefault();

                    $('#btnBuscarPlantel').click();
                }

            });
            
        });

        $('#btnBuscarPlantel').click(function(e){
            e.preventDefault();

            if($('#txtClavePlantel').val() != ''){

                $.getJSON('../controlador/controladorPlantel.php', {plantel:$('#txtClavePlantel').val(), accion:'buscar'}, function(resp){
                    
                    if(resp != null){
                        activaDesactivaTxt(false);
                        document.getElementById("codigosPostales").disabled = false;
                        document.getElementById("colonias").disabled = false;
                        document.getElementById("localidades").disabled = false;
                        document.getElementById("estados").disabled = false;
                        document.getElementById("btnBuscarPlantel").disabled = true;
                        document.getElementById("btnGrabarPlantel").disabled = false;
                        document.getElementById("txtClavePlantel").disabled = true;
                        $('#codigosPostales').prop('selectedIndex', resp.codigoPostal);
                        $('#colonias').prop('selectedIndex', resp.colonia);
                        $('#localidades').prop('selectedIndex', resp.localidad);
                        $('#estados').prop('selectedIndex', resp.estado);
                        $('#txtCalle').val(resp.calle);
                        $('#txtExterior').val(resp.numeroExterior);
                        $('#txtInterior').val(resp.numeroInterior);
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
                                document.getElementById("btnGrabarPlantel").disabled = false;
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

        $('#btnGrabarPlantel').click(function(e){
            e.preventDefault();

            var obj = {
                plantel:$('#txtClavePlantel').val(),
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
                    document.getElementById("btnBuscarPlantel").disabled = false;
                    document.getElementById("btnGrabarPlantel").disabled = true;
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