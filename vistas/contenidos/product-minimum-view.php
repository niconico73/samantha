<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
        <i class="fas fa-stopwatch-20 fa-fw"></i> &nbsp; Productos en stock mínimo
    </h3>
    <p class="text-justify">
        En el módulo PRODUCTOS podrá agregar nuevos productos al sistema, actualizar datos de los productos, eliminar o actualizar la imagen de los productos, imprimir códigos de barras o SKU de cada producto, buscar productos en el sistema, ver todos los productos en almacén, ver los productos más vendido y filtrar productos por categoría.
    </p>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs text-uppercase">
        <?php if($_SESSION['cargo_svi']=="Administrador"){ ?>
            <li>
                <a href="<?php echo SERVERURL; ?>product-new/">
                    <i class="fas fa-box fa-fw"></i> &nbsp; Nuevo producto
                </a>
            </li>
        <?php } ?>
        <li>
            <a href="<?php echo SERVERURL; ?>product-list/">
                <i class="fas fa-boxes fa-fw"></i> &nbsp; Productos en almacen
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>product-sold/">
                <i class="fas fa-fire-alt fa-fw"></i> &nbsp; Lo más vendido
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>product-category/">
                <i class="fab fa-shopify fa-fw"></i> &nbsp; Productos por categoría
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>product-expiration/">
                <i class="fas fa-history fa-fw"></i> &nbsp; Productos por vencimiento
            </a>
        </li>
        <li>
            <a class="active" href="<?php echo SERVERURL; ?>product-minimum/">
                <i class="fas fa-stopwatch-20 fa-fw"></i> &nbsp; Productos en stock mínimo
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>product-search/">
                <i class="fas fa-search fa-fw"></i> &nbsp; Buscar productos
            </a>
        </li>
    </ul>	
</div>

<div class="container-fluid" style="background-color: #FFF; padding-bottom: 20px;">
    <?php
        require_once "./controladores/productoControlador.php";
        $ins_producto = new productoControlador();

        echo $ins_producto->paginador_producto_controlador($pagina[1],15,$pagina[0],"",$_SESSION['cargo_svi']);
    ?>
</div>