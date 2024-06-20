<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
		<i class="fas fa-search-dollar fa-fw"></i> &nbsp; Buscar movimientos
    </h3>
    <p class="text-justify">
        En el módulo MOVIMIENTOS usted puede realizar, buscar y ver todos los movimientos de efectivo realizados en las cajas de ventas. Los movimientos de <strong>“Entrada de efectivo”</strong> son aquellos donde se ingresa dinero a las cajas de ventas. Los movimientos de <strong>“Retiro de efectivo”</strong> son aquellos donde se extrae el dinero de las cajas de ventas. 
    </p>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs text-uppercase">
		<li>
            <a href="<?php echo SERVERURL; ?>movement-new/">
                <i class="far fa-money-bill-alt fa-fw"></i> &nbsp; Nuevo movimiento
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>movement-list/">
                <i class="fas fa-money-check-alt fa-fw"></i> &nbsp; Movimientos realizados
            </a>
        </li>
        <li>
            <a class="active" href="<?php echo SERVERURL; ?>movement-search/">
                <i class="fas fa-search-dollar fa-fw"></i> &nbsp; Buscar movimientos
            </a>
        </li>
    </ul>	
</div>
<?php
    if(!isset($_SESSION['fecha_inicio_movimiento']) && empty($_SESSION['fecha_inicio_movimiento']) && !isset($_SESSION['fecha_final_movimiento']) && empty($_SESSION['fecha_final_movimiento'])){
?>
<div class="container-fluid">
	<form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" data-form="default" method="POST" autocomplete="off" >
        <input type="hidden" name="modulo" value="movimiento">
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
        <input type="hidden" name="modulo" value="movimiento">
        <input type="hidden" name="eliminar_busqueda" value="eliminar">
		<div class="container-fluid">
			<div class="row justify-content-md-center">
				<div class="col-12 col-md-6">
					<p class="text-center" style="font-size: 20px;">
						Fecha de busqueda: <strong><?php echo date("d-m-Y", strtotime($_SESSION['fecha_inicio_movimiento'])); ?> &nbsp; a &nbsp; <?php echo date("d-m-Y", strtotime($_SESSION['fecha_final_movimiento'])); ?></strong>
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
        require_once "./controladores/movimientoControlador.php";
        $ins_movimiento = new movimientoControlador();

        echo $ins_movimiento->paginador_movimiento_controlador($pagina[1],15,$pagina[0],"Busqueda",$_SESSION['fecha_inicio_movimiento'],$_SESSION['fecha_final_movimiento']);
    ?>
</div>
<?php } ?>