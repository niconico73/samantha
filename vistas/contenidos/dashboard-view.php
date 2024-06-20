<!-- Page header -->
<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fab fa-dashcube fa-fw"></i> &nbsp; DASHBOARD
    </h3>
    <p class="text-justify">
        <?php 
        if (isset($_SESSION['nombre_svi'], $_SESSION['apellido_svi'])) {
            echo '¡Bienvenido <strong>' . $_SESSION['nombre_svi'] . ' ' . $_SESSION['apellido_svi'] . '</strong>! Este es el panel principal del sistema acá podrá encontrar atajos para acceder a los distintos listados de cada módulo del sistema.';
        }
        ?>
    </p>
</div>
<div class="container-fluid">
    <div class="full-box tile-container">

    <?php
    /*---------- Inicio Opciones del administrador ----------*/
    if (isset($_SESSION['cargo_svi']) && $_SESSION['cargo_svi'] == "Administrador") {
        $total_cajas = $lc->datos_tabla("Normal", "caja", "caja_id", 0);
        if ($total_cajas) {
            $total_cajas_count = $total_cajas->rowCount();
    ?>
    <a href="<?php echo defined('SERVERURL') ? SERVERURL . 'cashier-list/' : ''; ?>" class="tile">
        <div class="tile-tittle">Cajas</div>
        <div class="tile-icon">
            <i class="fas fa-cash-register fa-fw"></i>
            <p><?php echo $total_cajas_count; ?> Registradas</p>
        </div>
    </a>
    <?php
            $total_cajas->closeCursor();
        }
        
        $total_categorias = $lc->datos_tabla("Normal", "categoria", "categoria_id", 0); 
        if ($total_categorias) {
            $total_categorias_count = $total_categorias->rowCount();
    ?>
    <a href="<?php echo defined('SERVERURL') ? SERVERURL . 'category-list/' : ''; ?>" class="tile">
        <div class="tile-tittle">Categorías</div>
        <div class="tile-icon">
            <i class="fas fa-tags fa-fw"></i>
            <p><?php echo $total_categorias_count; ?> Registradas</p>
        </div>
    </a>
    <?php 
            $total_categorias->closeCursor();
        }

        $total_usuarios = $lc->datos_tabla("Normal", "usuario WHERE usuario_id != '1' AND usuario_id != '".$_SESSION['id_svi']."'", "usuario_id", 0); 
        if ($total_usuarios) {
            $total_usuarios_count = $total_usuarios->rowCount();
    ?>
    <a href="<?php echo defined('SERVERURL') ? SERVERURL . 'user-list/' : ''; ?>" class="tile">
        <div class="tile-tittle">Usuarios</div>
        <div class="tile-icon">
            <i class="fas fa-user-tie fa-fw"></i>
            <p><?php echo $total_usuarios_count; ?> Registrados</p>
        </div>
    </a>
    <?php 
            $total_usuarios->closeCursor();
        }
    } 
    /*---------- Fin Opciones del administrador ----------*/ 
    ?>

<a href="<?php echo defined('SERVERURL') ? SERVERURL . 'product-list/' : ''; ?>" class="tile">
    <div class="tile-tittle">Productos</div>
    <div class="tile-icon">
        <i class="fas fa-boxes fa-fw"></i>
        <p>Registrados</p>
    </div>
</a>

<a href="<?php echo defined('SERVERURL') ? SERVERURL . 'client-list/' : ''; ?>" class="tile">
    <div class="tile-tittle">Clientes</div>
    <div class="tile-icon">
        <i class="fas fa-child fa-fw"></i>
        <p>Registrados</p>
    </div>
</a>


    <a href="<?php echo defined('SERVERURL') ? SERVERURL . 'sale-list/' : ''; ?>" class="tile">
        <div class="tile-tittle">Ventas</div>
        <div class="tile-icon">
            <i class="fas fa-coins fa-fw"></i>
            <p> &nbsp; </p>
        </div>
    </a>

    <?php 
    /*---------- Inicio Opciones del administrador ----------*/
    if (isset($_SESSION['cargo_svi']) && $_SESSION['cargo_svi'] == "Administrador") { 
    ?>
    <a href="<?php echo defined('SERVERURL') ? SERVERURL . 'return-list/' : ''; ?>" class="tile">
        <div class="tile-tittle">Devoluciones</div>
        <div class="tile-icon">
            <i class="fas fa-people-carry fa-fw"></i>
            <p> &nbsp; </p>
        </div>
    </a>
    <a href="<?php echo defined('SERVERURL') ? SERVERURL . 'report-sales/' : ''; ?>" class="tile">
        <div class="tile-tittle">Reportes</div>
        <div class="tile-icon">
            <i class="far fa-file-pdf fa-fw"></i>
            <p> &nbsp; </p>
        </div>
    </a>
    <?php } /*---------- Fin Opciones del administrador ----------*/ ?>

    </div>
</div>
<div class="full-box page-header">
    <h3 class="text-left text-uppercase"></h3>

    <div class="container-fluid">
    <!-- Formulario para generar reporte por usuario -->
    <div class="container-fluid">
        <h4 class="text-center">Generar reporte por usuario</h4>
        <div class="form-neon">
            <div class="container-fluid">
                <div class="row justify-content-md-center">
                <div class="col-12 col-md-4">
    <div class="form-group">
        <label for="usuario_id">Usuario</label>
        <!-- Corrección: Utiliza el ID de usuario de la sesión -->
        <input type="text" class="form-control" name="usuario_id" id="usuario_id" value="<?php echo isset($_SESSION['id_svi']) ? $_SESSION['id_svi'] : ''; ?>" readonly>
    </div>
</div>
<div class="col-12 col-md-4">
    <div class="form-group">
        <label for="fecha_inicio">Fecha inicial (día/mes/año)</label>
        <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" maxlength="30" required>
    </div>
</div>
<div class="col-12 col-md-4">
    <div class="form-group">
        <label for="fecha_final">Fecha final (día/mes/año)</label>
        <input type="date" class="form-control" name="fecha_final" id="fecha_final" maxlength="30" required>
    </div>
</div>
                    <div class="col-12">
                        <p class="text-center" style="margin-top: 40px;">
                            <button type="button" class="btn btn-raised btn-success" onclick="generar_reporte_totales()"><i class="far fa-file-pdf"></i> &nbsp; GENERAR REPORTE DE PRODUCTOS</button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Aquí podrías mostrar los resultados del informe por usuario si lo deseas -->
</div>

    <!-- Aquí podrías mostrar los resultados del informe por usuario si lo deseas -->
</div>

<script>
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
                let usuario_id = '<?php echo isset($_SESSION['id_svi']) ? $_SESSION['id_svi'] : ''; ?>';
                let fecha_inicio = document.querySelector('#fecha_inicio').value.trim();
                let fecha_final = document.querySelector('#fecha_final').value.trim();

                if(fecha_inicio !== "" && fecha_final !== ""){
                    url = "<?php echo defined('SERVERURL') ? SERVERURL : ''; ?>pdf/report-salestotal.php?usuario_id=" + usuario_id + "&fi=" + fecha_inicio + "&ff=" + fecha_final;

                    window.open(url, 'Imprimir reporte de totales', 'width=820,height=720,top=0,left=100,menubar=NO,toolbar=YES');
                }else{
                    Swal.fire({
                        title: 'Ocurrió un error inesperado',
                        text: 'Debe proporcionar la fecha de inicio y final para generar el reporte de totales.',
                        type: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            }
        });
    }
</script>

