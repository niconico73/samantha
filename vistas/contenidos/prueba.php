<?php
    include "./vistas/inc/admin_security.php";
?>

<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
        <i class="fas fa-hand-holding-usd fa-fw"></i> &nbsp; Reportes de ventas por usuario
    </h3>
    <p class="text-justify">
        En el módulo REPORTES podrá ver, generar e imprimir reportes de ventas por usuario en formato PDF.
    </p>
</div>

<div class="container-fluid">
    <!-- Formulario para generar reporte por usuario -->
    <div class="container-fluid">
        <h4 class="text-center">Generar reporte por usuario</h4>
        <div class="form-neon">
            <div class="container-fluid">
                <div class="row justify-content-md-center">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="usuario_id">Seleccione un usuario</label>
                            <select class="form-control" name="usuario_id" id="usuario_id">
                                <option value="">Seleccione un usuario</option>
                                <?php
                                    // Conexión a la base de datos
                                    $conexion = new mysqli("localhost", "root", "", "ventas");

                                    // Verificar conexión
                                    if ($conexion->connect_error) {
                                        die("Error en la conexión: " . $conexion->connect_error);
                                    }

                                    // Consulta SQL para obtener los usuarios
                                    $query = "SELECT usuario_id, usuario_nombre FROM usuario";
                                    $resultado = $conexion->query($query);

                                    // Verificar si se obtuvieron resultados
                                    if ($resultado->num_rows > 0) {
                                        // Recorrer los resultados y generar las opciones del select
                                        while($fila = $resultado->fetch_assoc()) {
                                            echo "<option value='" . $fila["usuario_id"] . "'>" . $fila["usuario_nombre"] . "</option>";
                                        }
                                    }

                                    // Cerrar conexión
                                    $conexion->close();
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="fecha_inicio">Fecha inicial (día/mes/año)</label>
                            <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" maxlength="30">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="fecha_final">Fecha final (día/mes/año)</label>
                            <input type="date" class="form-control" name="fecha_final" id="fecha_final" maxlength="30">
                        </div>
                    </div>
                    <div class="col-12">
                        <p class="text-center" style="margin-top: 40px;">
                            <button type="button" class="btn btn-raised btn-info" onclick="generar_reporte()"><i class="far fa-file-pdf"></i> &nbsp; GENERAR REPORTE DE VENTA</button>
                            <button type="button" class="btn btn-raised btn-success" onclick="generar_reporte_totales()"><i class="far fa-file-pdf"></i> &nbsp; GENERAR REPORTE DE PRODUCTOS</button>
                            <button type="button" class="btn btn-raised btn-success" onclick="generar_reporte_productos()"><i class="far fa-file-pdf"></i> &nbsp; GENERAR REPORTE GLOBAL</button></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Aquí podrías mostrar los resultados del informe por usuario si lo deseas -->
</div>

<script>
    function generar_reporte(){
        Swal.fire({
            title: '¿Quieres generar el reporte?',
            text: "La generación del reporte PDF puede tardar unos minutos para completarse",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, generar',
            cancelButtonText: 'No, cancelar'
        }).then((result) => {
            if(result.value){
                let usuario_id = document.querySelector('#usuario_id').value;
                let fecha_inicio = document.querySelector('#fecha_inicio').value;
                let fecha_final = document.querySelector('#fecha_final').value;

                usuario_id.trim();
                fecha_inicio.trim();
                fecha_final.trim();

                if(usuario_id != "" && fecha_inicio != "" && fecha_final != ""){
                    url = "<?php echo SERVERURL; ?>pdf/report-sales.php?usuario_id=" + usuario_id + "&fi=" + fecha_inicio + "&ff=" + fecha_final;
                    window.open(url, 'Imprimir reporte de ventas', 'width=820,height=720,top=0,left=100,menubar=NO,toolbar=YES');
                }else{
                    Swal.fire({
                        title: 'Ocurrió un error inesperado',
                        text: 'Debe seleccionar un usuario y proporcionar la fecha de inicio y final para generar el reporte.',
                        type: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            }
        });
    }

    function generar_reporte_totales(){
        Swal.fire({
            title: '¿Quieres generar el reporte de totales?',
            text: "La generación del reporte PDF puede tardar unos minutos para completarse",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, generar',
            cancelButtonText: 'No, cancelar'
        }).then((result) => {
            if(result.value){
                let usuario_id = document.querySelector('#usuario_id').value;
                let fecha_inicio = document.querySelector('#fecha_inicio').value;
                let fecha_final = document.querySelector('#fecha_final').value;

                usuario_id.trim();
                fecha_inicio.trim();
                fecha_final.trim();

                if(usuario_id != "" && fecha_inicio != "" && fecha_final != ""){
                    url = "<?php echo SERVERURL; ?>pdf/report-salestotal.php?usuario_id=" + usuario_id + "&fi=" + fecha_inicio + "&ff=" + fecha_final;
                    window.open(url, 'Imprimir reporte de totales', 'width=820,height=720,top=0,left=100,menubar=NO,toolbar=YES');
                }else{
                    Swal.fire({
                        title: 'Ocurrió un error inesperado',
                        text: 'Debe seleccionar un usuario y proporcionar la fecha de inicio y final para generar el reporte de totales.',
                        type: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            }
        });
    }
    function generar_reporte_productos(){
        Swal.fire({
            title: '¿Quieres generar el reporte de productos?',
            text: "La generación del reporte PDF puede tardar unos minutos para completarse",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, generar',
            cancelButtonText: 'No, cancelar'
        }).then((result) => {
            if(result.value){
                let usuario_id = document.querySelector('#usuario_id').value;
                let fecha_inicio = document.querySelector('#fecha_inicio').value;
                let fecha_final = document.querySelector('#fecha_final').value;

                usuario_id.trim();
                fecha_inicio.trim();
                fecha_final.trim();

                if(usuario_id != "" && fecha_inicio != "" && fecha_final != ""){
                    url = "<?php echo SERVERURL; ?>pdf/report-report-global.php?usuario_id=" + usuario_id + "&fi=" + fecha_inicio + "&ff=" + fecha_final;
                    window.open(url, 'Imprimir reporte de productos', 'width=820,height=720,top=0,left=100,menubar=NO,toolbar=YES');
                }else{
                    Swal.fire({
                        title: 'Ocurrió un error inesperado',
                        text: 'Debe seleccionar un usuario y proporcionar la fecha de inicio y final para generar el reporte de productos.',
                        type: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            }
        });
    }
</script>
