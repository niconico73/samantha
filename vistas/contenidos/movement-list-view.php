<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
        <i class="fas fa-money-check-alt fa-fw"></i> &nbsp; Movimientos realizados
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
            <a class="active" href="<?php echo SERVERURL; ?>movement-list/">
                <i class="fas fa-money-check-alt fa-fw"></i> &nbsp; Movimientos realizados
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>movement-search/">
                <i class="fas fa-search-dollar fa-fw"></i> &nbsp; Buscar movimientos
            </a>
        </li>
    </ul>	
</div>

<div class="container-fluid">
    <?php
        require_once "./controladores/movimientoControlador.php";
        $ins_movimiento = new movimientoControlador();

        echo $ins_movimiento->paginador_movimiento_controlador($pagina[1],15,$pagina[0],"Listado","","");
    ?>
</div>