<?php
    include "./vistas/inc/admin_security.php";
?>
<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
        <i class="fas fa-search fa-fw"></i> &nbsp; Buscar caja
    </h3>
    <p class="text-justify">
        En el módulo CAJA usted podrá registrar cajas de ventas en el sistema para poder realizar ventas, además podrá actualizar los datos de las cajas de venta, realizar búsquedas de cajas o eliminarlas si lo desea.
    </p>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs text-uppercase">
        <li>
            <a href="<?php echo SERVERURL; ?>cashier-new/">
                <i class="fas fa-cash-register fa-fw"></i> &nbsp; Nueva caja
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>cashier-list/">
                <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de cajas
            </a>
        </li>
        <li>
            <a class="active" href="<?php echo SERVERURL; ?>cashier-search/">
                <i class="fas fa-search fa-fw"></i> &nbsp; Buscar caja
            </a>
        </li>
    </ul>	
</div>
<?php
	if(!isset($_SESSION['busqueda_caja']) && empty($_SESSION['busqueda_caja'])){
?>
<div class="container-fluid">
    <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" data-form="default" method="POST" autocomplete="off" >
        <input type="hidden" name="modulo" value="caja">
        <div class="container-fluid">
            <div class="row justify-content-md-center">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="inputSearch" class="bmd-label-floating">¿Qué caja estas buscando?</label>
                        <input type="text" class="form-control" name="busqueda_inicial" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" id="inputSearch" maxlength="30">
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
    <form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" data-form="search" method="POST" autocomplete="off">
        <input type="hidden" name="modulo" value="caja">
        <input type="hidden" name="eliminar_busqueda" value="eliminar">
        <div class="container-fluid">
            <div class="row justify-content-md-center">
                <div class="col-12 col-md-6">
                    <p class="text-center" style="font-size: 20px;">
                    Resultados de la busqueda <strong>“<?php echo $_SESSION['busqueda_caja']; ?>”</strong>
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
        require_once "./controladores/cajaControlador.php";
        $ins_caja = new cajaControlador();

        echo $ins_caja->paginador_caja_controlador($pagina[1],15,$pagina[0],$_SESSION['busqueda_caja']);
    ?>
</div>
<?php } ?>