<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
		<i class="fas fa-search-dollar fa-fw"></i> &nbsp; Buscar venta (Fecha)
    </h3>
    <p class="text-justify">
    	En el módulo VENTAS podrá realizar ventas de productos, puede usar lector de código de barras o hacerlo de forma manual digitando el código del producto (debe de configurar estas opciones en ajustes de su cuenta). También puede ver las ventas realizadas y buscar ventas en el sistema.
	</p>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs text-uppercase">
		<li>
            <a href="<?php echo SERVERURL; ?>sale-new/">
                <i class="fas fa-cart-plus fa-fw"></i> &nbsp; Nueva venta
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>sale-new/wholesale/">
                <i class="fas fa-parachute-box fa-fw"></i> &nbsp; Venta por mayoreo
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>sale-list/">
                <i class="fas fa-coins fa-fw"></i> &nbsp; Ventas realizadas
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>sale-pending/">
                <i class="fab fa-creative-commons-nc fa-fw"></i> &nbsp; Ventas pendientes
            </a>
        </li>
        <li>
            <a class="active" href="<?php echo SERVERURL; ?>sale-search-date/">
                <i class="fas fa-search-dollar fa-fw"></i> &nbsp; Buscar venta (Fecha)
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>sale-search-code/">
                <i class="fas fa-search-dollar fa-fw"></i> &nbsp; Buscar venta (Código)
            </a>
        </li>
    </ul>	
</div>

<?php
    if(!isset($_SESSION['fecha_inicio_venta_date']) && empty($_SESSION['fecha_inicio_venta_date']) && !isset($_SESSION['fecha_final_venta_date']) && empty($_SESSION['fecha_final_venta_date'])){
?>
<div class="container-fluid">
	<form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" data-form="default" method="POST" autocomplete="off" >
        <input type="hidden" name="modulo" value="venta_date">
		<div class="container-fluid">
			<div class="row justify-content-md-center">
				<div class="col-12 col-md-4">
					<div class="form-group">
						<label for="fecha_inicio" >Fecha inicial (día/mes/año)</label>
						<input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" maxlength="30">
					</div>
				</div>
				<div class="col-12 col-md-4">
					<div class="form-group">
						<label for="fecha_final" >Fecha final (día/mes/año)</label>
						<input type="date" class="form-control" name="fecha_final" id="fecha_final" maxlength="30">
					</div>
				</div>
				<div class="col-12">
					<p class="text-center" style="margin-top: 40px;">
						<button type="submit" class="btn btn-raised btn-info"><i class="fas fa-search"></i> &nbsp; BUSCAR</button>
					</p>
				</div>
			</div>
		</div>
	</form>
</div>
<?php }else{ ?>
<div class="container-fluid">
	<form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" data-form="search" method="POST" autocomplete="off" >
        <input type="hidden" name="modulo" value="venta_date">
        <input type="hidden" name="eliminar_busqueda" value="eliminar">
		<div class="container-fluid">
			<div class="row justify-content-md-center">
				<div class="col-12 col-md-6">
					<p class="text-center" style="font-size: 20px;">
						Fecha de busqueda: <strong><?php echo date("d-m-Y", strtotime($_SESSION['fecha_inicio_venta_date'])); ?> &nbsp; a &nbsp; <?php echo date("d-m-Y", strtotime($_SESSION['fecha_final_venta_date'])); ?></strong>
					</p>
				</div>
				<div class="col-12">
					<p class="text-center" style="margin-top: 20px;">
						<button type="submit" class="btn btn-raised btn-danger"><i class="far fa-trash-alt"></i> &nbsp; ELIMINAR BÚSQUEDA</button>
					</p>
				</div>
			</div>
		</div>
	</form>
</div>

<div class="container-fluid">
    <?php
        require_once "./controladores/ventaControlador.php";
        $ins_venta = new ventaControlador();

        echo $ins_venta->paginador_venta_controlador($pagina[1],15,$pagina[0],$_SESSION['fecha_inicio_venta_date'],$_SESSION['fecha_final_venta_date']);
    ?>
</div>
<?php
		include "./vistas/inc/print_invoice_script.php";
	}
?>