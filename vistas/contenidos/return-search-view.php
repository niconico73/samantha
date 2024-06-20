<?php
    include "./vistas/inc/admin_security.php";
?>
<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
		<i class="fas fa-dolly-flatbed fa-fw"></i> &nbsp; Buscar devoluciones
    </h3>
    <p class="text-justify">
        En el módulo DEVOLUCIONES podrá ver el listado de todas las devoluciones de compras y ventas realizadas. Además, podrá buscar devoluciones por fecha.
    </p>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs text-uppercase">
		<li>
            <a href="<?php echo SERVERURL; ?>return-list/">
                <i class="fas fa-people-carry fa-fw"></i> &nbsp; Devoluciones realizadas
            </a>
        </li>
        <li>
            <a class="active" href="<?php echo SERVERURL; ?>return-search/">
                <i class="fas fa-dolly-flatbed fa-fw"></i> &nbsp; Buscar devoluciones
            </a>
        </li>
    </ul>	
</div>
<?php
    if(!isset($_SESSION['fecha_inicio_devolucion']) && empty($_SESSION['fecha_inicio_devolucion']) && !isset($_SESSION['fecha_final_devolucion']) && empty($_SESSION['fecha_final_devolucion'])){
?>
<div class="container-fluid">
	<form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" data-form="default" method="POST" autocomplete="off" >
        <input type="hidden" name="modulo" value="devolucion">
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
        <input type="hidden" name="modulo" value="devolucion">
        <input type="hidden" name="eliminar_busqueda" value="eliminar">
		<div class="container-fluid">
			<div class="row justify-content-md-center">
				<div class="col-12 col-md-6">
					<p class="text-center" style="font-size: 20px;">
						Fecha de busqueda: <strong><?php echo date("d-m-Y", strtotime($_SESSION['fecha_inicio_devolucion'])); ?> &nbsp; a &nbsp; <?php echo date("d-m-Y", strtotime($_SESSION['fecha_final_devolucion'])); ?></strong>
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
        require_once "./controladores/devolucionControlador.php";
        $ins_devolucion = new devolucionControlador();

        echo $ins_devolucion->paginador_devolucion_controlador($pagina[1],15,$pagina[0],$_SESSION['fecha_inicio_devolucion'],$_SESSION['fecha_final_devolucion']);
    ?>
</div>
<?php } ?>