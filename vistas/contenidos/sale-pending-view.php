<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
        <i class="fab fa-creative-commons-nc fa-fw"></i> &nbsp; Ventas pendientes
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
            <a class="active" href="<?php echo SERVERURL; ?>sale-pending/">
                <i class="fab fa-creative-commons-nc fa-fw"></i> &nbsp; Ventas pendientes
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>sale-search-date/">
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

<div class="container-fluid">
    <?php
        require_once "./controladores/ventaControlador.php";
        $ins_venta = new ventaControlador();

        echo $ins_venta->paginador_venta_controlador($pagina[1],15,$pagina[0],"","");
    ?>
</div>

<?php
	include "./vistas/inc/print_invoice_script.php";
?>