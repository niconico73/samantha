<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
        <i class="fab fa-shopify fa-fw"></i> &nbsp; Productos por categoría
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
            <a class="active" href="<?php echo SERVERURL; ?>product-category/">
                <i class="fab fa-shopify fa-fw"></i> &nbsp; Productos por categoría
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>product-expiration/">
                <i class="fas fa-history fa-fw"></i> &nbsp; Productos por vencimiento
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>product-minimum/">
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

<div class="container-fluid">
    <div class="product-container">
        <div class="product-category">
            <h5 class="text-uppercase text-center"><i class="fas fa-tags"></i> &nbsp; Categorías</h5>
            <ul class="list-unstyled text-center product-category-list">
                <?php
                    $datos_categorias=$lc->datos_tabla("Normal","categoria","*",0);

                    while($campos_categoria=$datos_categorias->fetch()){
                        $total_productos=$lc->datos_tabla("Normal","producto WHERE categoria_id='".$campos_categoria['categoria_id']."'","producto_id",0);

                        echo '<li>
                            <a href="'.SERVERURL.'product-category/'.$campos_categoria['categoria_id'].'/" >'.$campos_categoria['categoria_nombre'].' <span class="badge badge-pill badge-info">'.$total_productos->rowCount().'</span></a>
                        </li>';
                    }
                ?>
            </ul>
        </div>  
        <div class="product-list">
            <?php
                if(isset($pagina[1]) && $pagina[1]>0){

                    $datos_categoria=$lc->datos_tabla("Unico","categoria","categoria_id",$lc->encryption($pagina[1]));

                    if($datos_categoria->rowCount()>=1){
                        $campos=$datos_categoria->fetch();
                        echo '<h3 class="text-center text-uppercase">Productos en categoría <strong>"'.$campos['categoria_nombre'].'"</strong></h3><br>';
                    }

                    require_once "./controladores/productoControlador.php";
                    $ins_producto = new productoControlador();

                    echo $ins_producto->paginador_producto_controlador($pagina[2],15,$pagina[0],$pagina[1],$_SESSION['cargo_svi']);
                }else{
                    echo '
                        <div class="alert text-primary text-center" role="alert">
                            <p><i class="fab fa-shopify fa-fw fa-5x"></i></p>
                            <h4 class="alert-heading">Categoría no seleccionada</h4>
                            <p class="mb-0">Por favor seleccione una categoría para empezar a buscar productos.</p>
                        </div>
                    ';
                }
            ?>
            
        </div>
    </div>	
</div>