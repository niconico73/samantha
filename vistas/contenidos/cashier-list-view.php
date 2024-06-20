<?php
    include "./vistas/inc/admin_security.php";
?>
<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
        <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de cajas
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
            <a class="active" href="<?php echo SERVERURL; ?>cashier-list/">
                <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de cajas
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>cashier-search/">
                <i class="fas fa-search fa-fw"></i> &nbsp; Buscar caja
            </a>
        </li>
    </ul>	
</div>

<div class="container-fluid">
    <?php
        require_once "./controladores/cajaControlador.php";
        $ins_caja = new cajaControlador();

        echo $ins_caja->paginador_caja_controlador($pagina[1],15,$pagina[0],"");
    ?>
</div>