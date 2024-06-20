<?php
    include "./vistas/inc/admin_security.php";
?>

<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
        <i class="far fa-image fa-fw"></i> &nbsp; Gestionar imagen
    </h3>
    <p class="text-justify">
        En el módulo PRODUCTOS podrá agregar nuevos productos al sistema, actualizar datos de los productos, eliminar o actualizar la imagen de los productos, imprimir códigos de barras o SKU de cada producto, buscar productos en el sistema, ver todos los productos en almacén, ver los productos más vendido y filtrar productos por categoría.
    </p>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs text-uppercase">
        <li>
            <a href="<?php echo SERVERURL; ?>product-new/">
                <i class="fas fa-box fa-fw"></i> &nbsp; Nuevo producto
            </a>
        </li>
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
    <?php
        include "./vistas/inc/btn_go_back.php";

        $datos_producto=$lc->datos_tabla("Unico","producto","producto_id",$pagina[1]);

        if($datos_producto->rowCount()==1){
            $campos=$datos_producto->fetch();
    ?>
    <div class="form-neon">
        <h3 class="text-center text-info"><?php echo $campos['producto_nombre']; ?></h3>
        <hr>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-6">
                    <?php if(is_file("./vistas/assets/product/".$campos['producto_foto'])){ ?>
                        <form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/productoAjax.php" method="POST" data-form="delete" autocomplete="off" >
                            <input type="hidden" name="modulo_producto" value="img_eliminar">
                            <input type="hidden" name="producto_img_id_del" value="<?php echo $pagina[1]; ?>">
                            <figure>
                                <img class="img-fluid img-product-info" src="<?php echo SERVERURL; ?>vistas/assets/product/<?php echo $campos['producto_foto']; ?>" alt="<?php echo $campos['producto_nombre']; ?>">
                            </figure>
                            <p class="text-center" style="margin-top: 40px;">
                                <button type="submit" class="btn btn-raised btn-danger btn-sm">
                                <i class="far fa-trash-alt"></i> &nbsp; ELIMINAR IMAGEN</button>
                            </p>
                        </form>
                    <?php }else{ ?>
                        <figure>
                            <img class="img-fluid img-product-info" src="<?php echo SERVERURL; ?>vistas/assets/img/producto.png" alt="<?php echo $campos['producto_nombre']; ?>">
                        </figure>
                    <?php } ?>
                </div>
                <div class="col-12 col-md-6">
                    <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/productoAjax.php" method="POST" data-form="update" autocomplete="off" enctype="multipart/form-data" >
                        <input type="hidden" name="producto_img_id_up" value="<?php echo $pagina[1]; ?>">
                        <input type="hidden" name="modulo_producto" value="img_actualizar">
                        <fieldset>
                            <legend><i class="far fa-image"></i> &nbsp; Actualizar foto o imagen del producto</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <input type="file" class="form-control-file" name="producto_foto" id="producto_foto" accept=".jpg, .png, .jpeg">
                                            <small class="text-muted">Tipos de archivos permitidos: JPG, JPEG, PNG. Tamaño máximo 3MB. Resolución recomendada 300px X 300px o superior manteniendo el aspecto cuadrado (1:1)</small>
                                        </div>
                                        <p class="text-center" style="margin-top: 40px;">
                                            <button type="submit" class="btn btn-raised btn-success btn-sm"><i class="fas fa-sync"></i> &nbsp; ACTUALIZAR IMAGEN</button>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php 
        }else{
            include "./vistas/inc/error_alert.php";
        } 
    ?>
</div>