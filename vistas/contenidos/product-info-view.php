<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
        <i class="fas fa-box-open fa-fw"></i> &nbsp; Información del producto
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
        <fieldset>
            <div class="container-fluid">
                <legend><i class="fas fa-barcode"></i> &nbsp; Código de barras y SKU</legend>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="producto_codigo" class="bmd-label-floating">Código de barras</label>
                            <input type="text" value="<?php echo $campos['producto_codigo']; ?>" class="form-control input-barcode" id="producto_codigo" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="producto_sku" class="bmd-label-floating">SKU</label>
                            <input type="text" value="<?php echo $campos['producto_sku']; ?>" class="form-control input-barcode" id="producto_sku" readonly >
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <br><br><br>
        <fieldset>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-4 align-self-center">
                        <figure>
                            <?php
                                if(is_file("./vistas/assets/product/".$campos['producto_foto'])){
                                    echo '<img class="img-fluid img-product-info" src="'.SERVERURL.'vistas/assets/product/'.$campos['producto_foto'].'" alt="'.$campos['producto_nombre'].'">';
                                }else{
                                    echo '<img class="img-fluid img-product-info" src="'.SERVERURL.'vistas/assets/img/producto.png" alt="'.$campos['producto_nombre'].'">';
                                }
                            ?>
                        </figure>
                    </div>
                    <div class="col-12 col-md-8">
                        <legend class="text-center"><i class="fas fa-box"></i> &nbsp; Información del producto</legend>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="producto_stock_total" class="bmd-label-floating">Stock o existencias</label>
                                        <input type="text" value="<?php echo $campos['producto_stock_total']; ?>" class="form-control" id="producto_stock_total" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="producto_stock_minimo" class="bmd-label-floating">Stock mínimo</label>
                                        <input type="text" value="<?php echo $campos['producto_stock_minimo']; ?>" class="form-control" id="producto_stock_minimo" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="producto_unidad" class="bmd-label-floating">Presentación del producto</label>
                                        <input type="text" value="<?php echo $campos['producto_tipo_unidad']; ?>" class="form-control" id="producto_unidad" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="producto_precio_compra" class="bmd-label-floating">Precio de compra</label>
                                        <input type="text" value="<?php echo $campos['producto_precio_compra']; ?>" class="form-control" id="producto_precio_compra" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="producto_precio_venta" class="bmd-label-floating">Precio de venta</label>
                                        <input type="text" value="<?php echo $campos['producto_precio_venta']; ?>" class="form-control" id="producto_precio_venta" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="producto_precio_venta_mayoreo" class="bmd-label-floating">Precio de venta por mayoreo</label>
                                        <input type="text" value="<?php echo $campos['producto_precio_mayoreo']; ?>" class="form-control" id="producto_precio_venta_mayoreo" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="producto_descuento" class="bmd-label-floating">Descuento (%) en venta </label>
                                        <input type="text" value="<?php echo $campos['producto_descuento']; ?>" class="form-control" id="producto_descuento" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="producto_precio_total" class="bmd-label-floating">Precio de venta con descuento</label>
                                        <input type="text" value="<?php $total_price=$campos['producto_precio_venta']-($campos['producto_precio_venta']*($campos['producto_descuento']/100)); echo number_format($total_price,MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR); ?>" class="form-control" id="producto_precio_total" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="producto_precio_total_mayoreo" class="bmd-label-floating">Precio de venta por mayoreo con descuento</label>
                                        <input type="text" value="<?php $total_price=$campos['producto_precio_mayoreo']-($campos['producto_precio_mayoreo']*($campos['producto_descuento']/100)); echo number_format($total_price,MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR); ?>" class="form-control" id="producto_precio_total_mayoreo" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="producto_marca" class="bmd-label-floating">Marca</label>
                                        <input type="text" value="<?php echo $campos['producto_marca']; ?>" class="form-control" id="producto_marca" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="producto_modelo" class="bmd-label-floating">Modelo</label>
                                        <input type="text" value="<?php echo $campos['producto_modelo']; ?>" class="form-control" id="producto_modelo" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <br><br><br>
        <fieldset>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="producto_vencimiento" class="bmd-label-floating">Fecha de vencimiento</label>
                            <?php
                                if($campos['producto_vencimiento']=="No"){
                                    $producto_vencimiento="No tiene vencimiento";
                                }else{
                                    $producto_vencimiento=date("d-m-Y", strtotime($campos['producto_fecha_vencimiento']));
                                }
                            ?>
                            <input type="text" value="<?php echo $producto_vencimiento; ?>" class="form-control" id="producto_vencimiento" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="producto_garantia" class="bmd-label-floating">Garantía de fabrica</label>
                            <?php
                                if($campos['producto_garantia_unidad']=="0" || $campos['producto_garantia_tiempo']=="N/A"){
                                    $producto_garantia="Sin garantía de fabrica";
                                }else{
                                    $producto_garantia=$campos['producto_garantia_unidad']." ".$campos['producto_garantia_tiempo'];
                                }
                            ?>
                            <input type="text" value="<?php echo $producto_garantia; ?>" class="form-control" id="producto_garantia" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <br><br><br>  
        <fieldset>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="producto_categoria" class="bmd-label-floating">Categoría</label>
                            <?php
                                $datos_categoria=$lc->datos_tabla("Unico","categoria","categoria_id",$lc->encryption($campos['categoria_id']));
                                $datos_categoria=$datos_categoria->fetch();
                                echo '<input type="text" value="'.$datos_categoria['categoria_nombre'].' ('.$datos_categoria['categoria_ubicacion'].')" class="form-control" id="producto_categoria" readonly>';
                            ?>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="producto_estado" class="bmd-label-floating">Estado del producto</label>
                            <input type="text" value="<?php echo $campos['producto_estado']; ?>" class="form-control" id="producto_estado" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <br><br><br>
    </div>
    <?php 
        }else{
            include "./vistas/inc/error_alert.php";
        } 
    ?>
</div>