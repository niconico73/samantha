<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
        <?php
            if(isset($pagina[1]) && $pagina[1]=="wholesale"){
                echo '<i class="fas fa-parachute-box fa-fw"></i> &nbsp; Venta por mayoreo';
            }else{
                echo '<i class="fas fa-cart-plus fa-fw"></i> &nbsp; Nueva venta';
            }
        ?>
    </h3>
    <p class="text-justify">
    	En el módulo VENTAS podrá realizar ventas de productos, puede usar lector de código de barras o hacerlo de forma manual digitando el código del producto (debe de configurar estas opciones en ajustes de su cuenta). También puede ver las ventas realizadas y buscar ventas en el sistema.
	</p>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs text-uppercase">
        <?php if(isset($pagina[1]) && $pagina[1]=="wholesale"){ ?>
            <li>
                <a href="<?php echo SERVERURL; ?>sale-new/">
                    <i class="fas fa-cart-plus fa-fw"></i> &nbsp; Nueva venta
                </a>
            </li>
            <li>
                <a class="active" href="<?php echo SERVERURL; ?>sale-new/wholesale/">
                    <i class="fas fa-parachute-box fa-fw"></i> &nbsp; Venta por mayoreo
                </a>
            </li>
        <?php }else{ ?>
            <li>
                <a class="active" href="<?php echo SERVERURL; ?>sale-new/">
                    <i class="fas fa-cart-plus fa-fw"></i> &nbsp; Nueva venta
                </a>
            </li>
            <li>
                <a href="<?php echo SERVERURL; ?>sale-new/wholesale/">
                    <i class="fas fa-parachute-box fa-fw"></i> &nbsp; Venta por mayoreo
                </a>
            </li>
        <?php } ?>
        <li>
            <a href="<?php echo SERVERURL; ?>sale-list/">
                <i class="fas fa-coins fa-fw"></i> &nbsp; Ventas realizadas
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>sale-pending/">
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
        $check_empresa=$lc->datos_tabla("Normal","empresa LIMIT 1","*",0);

        if($check_empresa->rowCount()==1){
            $datos_empresa=$check_empresa->fetch();

            $datos_caja=$lc->datos_tabla("Normal","caja WHERE caja_id='".$_SESSION['caja_svi']."'","*",0);
            $datos_caja=$datos_caja->fetch();
    ?>
    <div class="form-neon">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-lg-9">
                    <div class="alert alert-light text-center" role="alert" style="font-size: 12px;">
                        <?php
                            if($_SESSION['lector_codigo_svi']=="Barras"){
                                $txt_codigo="de barras";
                            }else{
                                $txt_codigo="SKU";
                            }


                            if($_SESSION['lector_estado_svi']=="Deshabilitado"){
                        ?>
                            <p>Está utilizando la <strong class="text-uppercase">configuración manual</strong> con lectura de <strong class="text-uppercase">códigos <?php echo $txt_codigo; ?></strong>, para agregar productos debe de digitar el código <?php echo $txt_codigo; ?> en el campo "Código de producto" y luego presionar &nbsp; <strong class="text-uppercase" ><i class="far fa-check-circle"></i> &nbsp; Agregar producto</strong>. También puede agregar el producto mediante la opción &nbsp; <strong class="text-uppercase"><i class="fas fa-search"></i> &nbsp; Buscar producto</strong></p>
                        <?php }else{ ?>
                            <p>Está utilizando la <strong class="text-uppercase">configuración automática</strong> con lectura de <strong class="text-uppercase">códigos <?php echo $txt_codigo; ?></strong>, debe de conectar un lector de código de barras a su computadora, luego seleccionar el campo "Código de producto" y escanear el código con el lector. También puede escribir el código y presionar la tecla <strong class="text-uppercase">enter</strong></p>
                        <?php } ?>
                        <hr>
                        <p class="mb-0">Puede cambiar esta configuración en los &nbsp; <a href="<?php echo SERVERURL."user-update/".$lc->encryption($_SESSION['id_svi'])."/"; ?>"><i class="fas fa-user-cog"></i>&nbsp; ajustes de su cuenta</a>.</p>
                    </div>
                    <?php
                        if(isset($_SESSION['alerta_producto_agregado']) && $_SESSION['alerta_producto_agregado']!=""){
                            echo '
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                '.$_SESSION['alerta_producto_agregado'].'
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            ';
                            unset($_SESSION['alerta_producto_agregado']);
                        }

                        if(isset($_SESSION['venta_codigo_factura']) && $_SESSION['venta_codigo_factura']!=""){
                    ?>
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <h4 class="alert-heading text-center">Venta realizada</h4>
                        <p class="text-center">La venta se realizó con éxito. ¿Que desea hacer a continuación? </p>
                        <br>
                        <div class="container">
                            <div class="row">
                                <div class="col-12 col-md-6 text-center">
                                    <button type="button" class="btn btn-primary" onclick="print_ticket('<?php echo SERVERURL."pdf/ticket_".THERMAL_PRINT_SIZE."mm.php?code=".$_SESSION['venta_codigo_factura']; ?>')" >
                                        <i class="fas fa-receipt fa-4x"></i><br>
                                        Imprimir Boleta
                                    </buttona>
                                </div>
                                <div class="col-12 col-md-6 text-center">
                                    <button type="button" class="btn btn-primary" onclick="print_invoice('<?php echo SERVERURL."pdf/invoice.php?code=".$_SESSION['venta_codigo_factura']; ?>')" >
                                        <i class="fas fa-file-invoice-dollar fa-4x"></i><br>
                                        Imprimir factura
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php
                            unset($_SESSION['venta_codigo_factura']);
                        }
                    ?>
                    <div class="container-fluid">
                        <form class="row align-items-center" id="sale-barcode-form" autocomplete="off">
                            <div class="col-12 col-md-3">
                                <button type="button" class="btn btn-primary" id="btn_modal_buscar_codigo" ><i class="fas fa-search"></i> &nbsp; Buscar producto</button>
                            </div>
                            <?php if($_SESSION['lector_estado_svi']=="Deshabilitado"){ ?>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="barcode-input">Código de producto</label>
                                    <input type="text" pattern="[a-zA-Z0-9- ]{1,70}" class="form-control sale-input-barcode" id="sale-barcode-input" maxlength="70" >
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <button type="button" class="btn btn-primary" onclick="agregar_producto()" ><i class="far fa-check-circle"></i> &nbsp; Agregar producto</button>
                            </div>
                            <?php }else{ ?>
                            <div class="col-12 col-md-9">
                                <div class="form-group">
                                    <label class="bmd-label-floating" for="barcode-input">Código de producto</label>
                                    <input type="text" pattern="[a-zA-Z0-9- ]{1,70}" class="form-control sale-input-barcode" id="sale-barcode-input" maxlength="70"  autofocus="autofocus" >
                                </div>
                            </div>
                            <?php } ?>
                        </form>
                    </div>
                    <?php
                        if(!isset($_SESSION['venta_descuento'])){
                            $_SESSION['venta_descuento']=0;
                        }

                        if(isset($pagina[1]) && $pagina[1]=="wholesale"){
                           $_SESSION['venta_tipo']="mayoreo";
                        }else{
                           $_SESSION['venta_tipo']="normal";
                        }

                    ?>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-sm">
                            <thead class="bg-info">
                                <tr class="text-center">
                                    <th scope="col">#</th>
                                    <th scope="col">Código de barra</th>
                                    <th scope="col">Producto</th>
                                    <th scope="col">Cant.</th>
                                    <th scope="col">Precio</th>
                                    <?php
                                        if($_SESSION['venta_descuento']>=1){
                                            echo '<th scope="col">'.$_SESSION['venta_descuento'].'% Desc.</th>';
                                        }
                                    ?>
                                    <th scope="col">Subtotal</th>
                                    <th scope="col">Actualizar</th>
                                    <th scope="col">Remover</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $_SESSION['venta_impuesto_nombre']=$datos_empresa['empresa_impuesto_nombre'];
                                $_SESSION['venta_impuesto_porcentaje']=$datos_empresa['empresa_impuesto_porcentaje'];

                                if(isset($_SESSION['datos_producto_venta']) && count($_SESSION['datos_producto_venta'])>=1){
                                    $_SESSION['venta_total']=0;
                                    $_SESSION['venta_impuestos']=0;
                                    $_SESSION['venta_subtotal']=0;
                                    $_SESSION['venta_costos']=0;
                                    $cc=1;
                                    foreach($_SESSION['datos_producto_venta'] as $productos){
                                ?>
                                <tr class="text-center">
                                    <th scope="row"><?php echo $cc; ?></th>

                                    <td><?php echo $productos['producto_codigo']; ?></td>

                                    <td><?php echo $productos['venta_detalle_descripcion']; ?></td>

                                    <td>
                                        <input type="text" class="form-control sale_input-cant" value="<?php echo $productos['venta_detalle_cantidad']; ?>" id="sale_input_<?php echo $productos['producto_codigo']; ?>" >
                                    </td>

                                    <td><?php echo MONEDA_SIMBOLO.number_format($productos['venta_detalle_precio_venta'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR)." ".MONEDA_NOMBRE; ?></td>

                                    <?php if($_SESSION['venta_descuento']>=1){ ?>
                                        <td><?php echo MONEDA_SIMBOLO.number_format(($productos['venta_detalle_total']*($_SESSION['venta_descuento']/100)),MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR)." ".MONEDA_NOMBRE; ?></td>
                                    <?php } ?>

                                    <td><?php echo MONEDA_SIMBOLO.number_format($productos['venta_detalle_total']-($productos['venta_detalle_total']*($_SESSION['venta_descuento']/100)),MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR)." ".MONEDA_NOMBRE; ?></td>

                                    <td>
                                        <button type="button" class="btn btn-success" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Actualizar cantidad" onclick="actualizar_cantidad('#sale_input_<?php echo $productos['producto_codigo']; ?>','<?php echo $productos['producto_codigo']; ?>')">
                                            <i class="fas fa-redo-alt"></i>
                                        </button>
                                    </td>

                                    <td>
                                        <form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/ventaAjax.php" method="POST" data-form="shop" autocomplete="off">
                                            <input type="hidden" name="producto_codigo_del" value="<?php echo $productos['producto_codigo']; ?>">
                                            <input type="hidden" name="modulo_venta" value="eliminar_producto">
                                            <button type="submit" class="btn btn-warning" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Remover producto" >
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php
                                        $cc++;
                                        $_SESSION['venta_total']+=$productos['venta_detalle_total'];
                                        $_SESSION['venta_impuestos']+=$productos['venta_detalle_impuestos'];
                                        $_SESSION['venta_subtotal']+=$productos['venta_detalle_subtotal'];
                                        $_SESSION['venta_costos']+=$productos['venta_detalle_costos'];
                                    }
                                ?>
                                <tr class="text-center font-weight-bold">
                                    <td colspan="4"></td>
                                    <?php if($_SESSION['venta_descuento']>=1){ ?>
                                        <td></td>
                                    <?php } ?>
                                    <td>TOTAL</td>
                                    <td><?php echo MONEDA_SIMBOLO.number_format($_SESSION['venta_total']-($_SESSION['venta_total']*($_SESSION['venta_descuento']/100)),MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR)." ".MONEDA_NOMBRE; ?></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <?php
                                }else{
                                    $_SESSION['venta_total']=0;
                                    $_SESSION['venta_impuestos']=0;
                                    $_SESSION['venta_subtotal']=0;
                                    $_SESSION['venta_costos']=0;
                                ?>
                                <tr class="text-center">
                                    <th colspan="9">No hay productos agregados</th>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-12 col-lg-3">
                    <h3 class="text-center text-uppercase">Datos de la venta</h3>
                    <hr>

                    <div class="form-group">
                        <label for="venta_fecha">Fecha</label>
                        <input type="date" class="form-control" name="venta_fecha_reg" id="venta_fecha" value="<?php echo date("Y-m-d"); ?>" readonly >
                    </div>

                    <div class="form-group">
                        <label for="venta_caja">Caja</label>
                        <input type="text" class="form-control" id="venta_caja" value="Caja #<?php echo $datos_caja['caja_numero']." - ".$datos_caja['caja_nombre']; ?>" readonly >
                    </div>

                    <div class="form-group">
                        <label for="venta_cliente">Cliente</label>
                        <?php
                            if(isset($_SESSION['datos_cliente_venta']) && count($_SESSION['datos_cliente_venta'])>=1 && $_SESSION['datos_cliente_venta']['cliente_id']!=1){
                        ?>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-10 text-center">
                                    <input type="text" class="form-control" id="venta_cliente" value="<?php echo $_SESSION['datos_cliente_venta']['cliente_nombre']." ".$_SESSION['datos_cliente_venta']['cliente_apellido']; ?>" readonly>
                                </div>
                                <div class="col-2 text-center">
                                    <form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/ventaAjax.php" method="POST" data-form="sale_cliente" autocomplete="off">
                                        <input type="hidden" name="cliente_id_del" value="<?php echo $_SESSION['datos_cliente_venta']['cliente_id']; ?>">
                                        <input type="hidden" name="modulo_venta" value="eliminar_cliente">
                                        <button type="submit" class="btn btn-danger" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Remover cliente">
                                            <i class="fas fa-user-times"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php
                            }else{
                                $datos_cliente=$lc->datos_tabla("Normal","cliente WHERE cliente_id='1'","*",0);
                                if($datos_cliente->rowCount()==1){
                                    $datos_cliente=$datos_cliente->fetch();

                                    $_SESSION['datos_cliente_venta']=[
                                        "cliente_id"=>$datos_cliente['cliente_id'],
                                        "cliente_tipo_documento"=>$datos_cliente['cliente_tipo_documento'],
                                        "cliente_numero_documento"=>$datos_cliente['cliente_numero_documento'],
                                        "cliente_nombre"=>$datos_cliente['cliente_nombre'],
                                        "cliente_apellido"=>$datos_cliente['cliente_apellido']
                                    ];

                                }else{
                                    $_SESSION['datos_cliente_venta']=[
                                        "cliente_id"=>1,
                                        "cliente_tipo_documento"=>"N/A",
                                        "cliente_numero_documento"=>"N/A",
                                        "cliente_nombre"=>"Publico",
                                        "cliente_apellido"=>"General"
                                    ];
                                }
                        ?>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-10 text-center">
                                    <input type="text" class="form-control" id="venta_cliente" value="<?php echo $_SESSION['datos_cliente_venta']['cliente_nombre']." ".$_SESSION['datos_cliente_venta']['cliente_apellido']; ?>" readonly>
                                </div>
                                <div class="col-2 text-center">
                                    <button type="button" class="btn btn-info" data-toggle="popover" data-trigger="hover" id="btn_modal_cliente" data-placement="top" data-content="Agregar cliente">
                                        <i class="fas fa-user-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>

                    <?php if($_SESSION['venta_total']>0){ ?>
                    <form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/ventaAjax.php" method="POST" data-form="save" autocomplete="off" name="formsale">
                        <input type="hidden" name="modulo_venta" value="registrar_venta">
                    <?php }else { ?>
                    <form name="formsale">
                    <?php } ?>

                    <label>Tipo de pago</label>
                    <div class="form-group text-center">
                        <div class="form-check form-check-inline" onclick="resetear_total('Contado')" >
                            <input class="form-check-input" type="radio" name="venta_tipo_venta_reg" value="Contado" id="venta_radio_contado" checked >
                            <label class="form-check-label text-secondary" for="venta_radio_contado" ><i class="fas fa-money-bill-alt"></i> &nbsp; Contado</label>
                        </div>
                        &nbsp; &nbsp;
                        <div class="form-check form-check-inline" onclick="resetear_total('Credito')" >
                            <input class="form-check-input" type="radio" name="venta_tipo_venta_reg" value="Credito" id="venta_radio_credito">
                            <label class="form-check-label text-secondary" for="venta_radio_credito" ><i class="fab fa-cc-visa"></i> &nbsp; Credito</label>
                        </div>
                    </div>

                 

                    <div class="form-group">
                        <label for="venta_abono" class="bmd-label-floating" >Total pagado por cliente <?php echo CAMPO_OBLIGATORIO; ?></label>
                        <input type="text" class="form-control" name="venta_abono_reg" id="venta_abono" value="0.00" pattern="[0-9.]{1,25}" maxlength="25" >
                    </div>

                    <div class="form-group">
                        <label for="venta_cambio" class="bmd-label-floating" >Cambio devuelto a cliente</label>
                        <input type="text" class="form-control" id="venta_cambio" value="0.00" readonly >
                    </div>

                    <?php
                        $_SESSION['venta_subtotal']=number_format($_SESSION['venta_subtotal'],MONEDA_DECIMALES,'.','');

                        $_SESSION['venta_impuestos']=number_format($_SESSION['venta_impuestos'],MONEDA_DECIMALES,'.','');

                        $_SESSION['venta_total']=number_format($_SESSION['venta_total'],MONEDA_DECIMALES,'.','');
                    ?>
                        <ul class="list-group list-unstyled">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Subtotal
                                <span class="badge badge-pill"> + <?php echo MONEDA_SIMBOLO.number_format($_SESSION['venta_subtotal'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR)." ".MONEDA_NOMBRE; ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo $_SESSION['venta_impuesto_nombre']." (".$_SESSION['venta_impuesto_porcentaje']; ?>%)
                                <span class="badge badge-pill"> + <?php echo MONEDA_SIMBOLO.number_format($_SESSION['venta_impuestos'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR)." ".MONEDA_NOMBRE; ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Descuento
                                <span class="badge badge-pill"> - <?php echo MONEDA_SIMBOLO.number_format($_SESSION['venta_total']*($_SESSION['venta_descuento']/100),MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR)." ".MONEDA_NOMBRE; ?></span>
                            </li>
                            <li><hr></li>
                            <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                Total
                                <span class="badge badge-pill" > <?php echo MONEDA_SIMBOLO.number_format(($_SESSION['venta_total']-($_SESSION['venta_total']*($_SESSION['venta_descuento']/100))),MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR)." ".MONEDA_NOMBRE; ?></span>
                            </li>
                        </ul>
                        <?php if($_SESSION['venta_total']>0){ ?>
                        <p class="text-center" style="margin-top: 40px;">
                            <button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR VENTA</button>
                        </p>
                        <?php } ?>
                        <p class="text-center">
                            <small>Los campos marcados con <?php echo CAMPO_OBLIGATORIO; ?> son obligatorios</small>
                        </p>
                        <input type="hidden" value="<?php echo number_format(($_SESSION['venta_total']-($_SESSION['venta_total']*($_SESSION['venta_descuento']/100))),MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,""); ?>" id="venta_total_descuento">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
        }else{
            echo '
                <div class="alert alert-danger text-center" role="alert">
                    <p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
                    <h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
                    <p class="mb-0">No hemos podio seleccionar algunos datos sobre los impuestos, por favor <a href="'.SERVERURL.'company/" >verifique aquí los datos de la empresa</a></p>
                </div>
            ';
        }
    ?>
</div>

<!-- MODAL CLIENTE -->
<!-- MODAL CLIENTE -->
<div class="modal fade" id="modal_cliente" tabindex="-1" role="dialog" aria-labelledby="modal_cliente" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_cliente">Agregar cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="form-group">
                        <label for="input_cliente" class="bmd-label-floating">Documento, Nombre, Apellido, Teléfono</label>
                        <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" name="input_cliente" id="input_cliente" maxlength="30">
                    </div>
                </div>
                <br>
                <div class="container-fluid" id="tabla_clientes"></div>
                <!-- Botón "Registrar Cliente Nuevo" -->
                <button id="btn_registrar_cliente" class="btn btn-primary" style="display: none;">Registrar Cliente Nuevo</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="buscar_cliente()"><i class="fas fa-search fa-fw"></i> &nbsp; Buscar</button>
                &nbsp; &nbsp;
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<!-- MODAL BUSCAR CODIGO -->
<div class="modal fade" id="modal_buscar_codigo" tabindex="-1" role="dialog" aria-labelledby="modal_buscar_codigo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_buscar_codigo">Buscar código de producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="form-group">
                        <label for="input_codigo" class="bmd-label-floating">Nombre, marca, modelo</label>
                        <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" name="input_codigo" id="input_codigo" maxlength="30">
                    </div>
                </div>
                <br>
                <div class="container-fluid" id="tabla_productos"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="buscar_codigo()" ><i class="fas fa-search fa-fw"></i> &nbsp; Buscar</button>
                &nbsp; &nbsp;
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>

    let sale_form_barcode = document.querySelector("#sale-barcode-form");
    sale_form_barcode.addEventListener('submit', function(event){
        event.preventDefault();
        setTimeout('agregar_producto()',100);
    });


    /* Configuracion automatica con lector de codigo de barras */
    <?php if($_SESSION['lector_estado_svi']=="Habilitado"){ ?>
        let sale_input_barcode = document.querySelector("#sale-barcode-input");

        sale_input_barcode.addEventListener('paste',function(){
            setTimeout('agregar_producto()',100);
        });
    <?php } ?>


    /* Agregar producto */
    function agregar_producto(){
        let codigo_producto=document.querySelector('#sale-barcode-input').value;

        codigo_producto=codigo_producto.trim();

        if(codigo_producto!=""){

            let datos = new FormData();
            datos.append("producto_codigo_add", codigo_producto);
            datos.append("modulo_venta", "agregar_producto");

            fetch('<?php echo SERVERURL; ?>ajax/ventaAjax.php',{
                method: 'POST',
                body: datos
            })
            .then(respuesta => respuesta.json())
            .then(respuesta =>{
                return alertas_ajax(respuesta);
            });

        }else{
            Swal.fire({
                title: 'Ocurrió un error inesperado',
                text: 'Debes de introducir el código del producto',
                type: 'error',
                confirmButtonText: 'Aceptar'
            });
        }

    }
/* funcion metodo de pago NICOLAS */



    /*----------  Buscar cliente  ----------*/
   function buscar_cliente(){
    let input_cliente = document.querySelector('#input_cliente').value;

    input_cliente = input_cliente.trim();

    if(input_cliente != ""){

        let datos = new FormData();
        datos.append("buscar_cliente", input_cliente);
        datos.append("modulo_venta", "buscar_cliente");

        fetch('<?php echo SERVERURL; ?>ajax/ventaAjax.php',{
            method: 'POST',
            body: datos
        })
        .then(respuesta => respuesta.text())
        .then(respuesta =>{
            let tabla_clientes = document.querySelector('#tabla_clientes');
            if(respuesta.trim().includes("No hemos encontrado ningún cliente en el sistema que coincida con")) {
                // Cliente no encontrado
                tabla_clientes.innerHTML = "<p>No hemos encontrado ningún cliente en el sistema que coincida con '" + input_cliente + "'.</p>";
                // Crear el botón "Registrar Cliente Nuevo"
                let botonNuevoCliente = document.createElement('button');
                botonNuevoCliente.textContent = 'Registrar Cliente Nuevo';
                botonNuevoCliente.classList.add('btn', 'btn-primary');
                // Asignar evento al botón para redireccionar a la página de registro
                botonNuevoCliente.onclick = function() {
                    redireccionarNuevoCliente();
                };
                // Agregar el botón al contenedor
                tabla_clientes.appendChild(botonNuevoCliente);
            } else {
                // Mostrar resultados de la búsqueda
                tabla_clientes.innerHTML = respuesta;
            }
        });

    } else {
        Swal.fire({
            title: 'Ocurrió un error inesperado',
            text: 'Debes de introducir el Numero de documento, Nombre, Apellido o Teléfono del cliente',
            type: 'error',
            confirmButtonText: 'Aceptar'
        });
    }
}

function redireccionarNuevoCliente() {
    // Redireccionar a la página de registro de cliente
    window.location.href = '<?php echo SERVERURL; ?>client-new';
}





    /*----------  Agregar cliente  ----------*/
    function agregar_cliente(id){
        $('#modal_cliente').modal('hide');
        Swal.fire({
            title: '¿Quieres agregar este cliente?',
            text: "Se va a agregar este cliente para realizar una venta",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, agregar',
            cancelButtonText: 'No, cancelar'
        }).then((result) => {
            if(result.value){

                let datos = new FormData();
                datos.append("cliente_id_add", id);
                datos.append("modulo_venta", "agregar_cliente");

                fetch('<?php echo SERVERURL; ?>ajax/ventaAjax.php',{
                    method: 'POST',
                    body: datos
                })
                .then(respuesta => respuesta.json())
                .then(respuesta =>{
                    return alertas_ajax(respuesta);
                });

            }else{
                $('#modal_cliente').modal('show');
            }
        });
    }


    /* Mostrar modal cliente y buscar codigo */
    $(document).ready(function(){
        $('#btn_modal_cliente').on('click',function(){
            $('#modal_cliente').modal('show');
        });

        $('#btn_modal_buscar_codigo').on('click',function(){
            $('#modal_buscar_codigo').modal('show');
        });
    });


    /*----------  Agregar descuento  ----------*/
    function aplicar_descuento(){
        let descuento=document.querySelector('#venta_descuento').value;
        descuento=descuento.trim();

        if(descuento>0){
            Swal.fire({
                title: "¿Estás seguro?",
                text: "Desea aplicar el descuento seleccionado",
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, aplicar',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if(result.value){

                    let datos = new FormData();
                    datos.append("venta_descuento_add", descuento);
                    datos.append("modulo_venta", "aplicar_descuento");

                    fetch('<?php echo SERVERURL; ?>ajax/ventaAjax.php',{
                        method: 'POST',
                        body: datos
                    })
                    .then(respuesta => respuesta.json())
                    .then(respuesta =>{
                        return alertas_ajax(respuesta);
                    });
                }
            });
        }else{
            Swal.fire({
                title: 'Ocurrió un error inesperado',
                text: 'Debes de introducir un descuento mayor a 0%',
                type: 'error',
                confirmButtonText: 'Aceptar'
            });
        }
    }


    /*----------  Remover descuento  ----------*/
    function remover_descuento(descuento){

        if(descuento>0){
            Swal.fire({
                title: "¿Estás seguro?",
                text: "Desea remover el descuento aplicado",
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, remover',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if(result.value){

                    let datos = new FormData();
                    datos.append("venta_descuento_del", descuento);
                    datos.append("modulo_venta", "remover_descuento");

                    fetch('<?php echo SERVERURL; ?>ajax/ventaAjax.php',{
                        method: 'POST',
                        body: datos
                    })
                    .then(respuesta => respuesta.json())
                    .then(respuesta =>{
                        return alertas_ajax(respuesta);
                    });
                }
            });
        }else{
            Swal.fire({
                title: 'Ocurrió un error inesperado',
                text: 'Ha ocurrido un error no podemos procesar su petición',
                type: 'error',
                confirmButtonText: 'Aceptar'
            });
        }
    }


    /*----------  Calcular cambio  ----------*/
    let venta_abono_input = document.querySelector("#venta_abono");

    venta_abono_input.addEventListener('keyup', function(event){
        event.preventDefault();

        let abono=document.querySelector('#venta_abono').value;
        abono=abono.trim();
        abono=parseFloat(abono);

        let total=document.querySelector('#venta_total_descuento').value;
        total=total.trim();
        total=parseFloat(total);

        let tipo_pago=document.formsale.venta_tipo_venta_reg.value;

        if(abono>=total && tipo_pago=="Contado"){
            cambio=abono-total;
            cambio=parseFloat(cambio).toFixed(<?php echo MONEDA_DECIMALES; ?>);
            document.querySelector('#venta_cambio').value=cambio;
        }else{
            document.querySelector('#venta_cambio').value="0.00";
        }
    });


    /*----------  Resetear total abonado  ----------*/
    function resetear_total(opcion){

        let tipo_pago=document.formsale.venta_tipo_venta_reg.value;

        if(tipo_pago!=opcion){
            document.querySelector('#venta_abono').value="0.00";
            document.querySelector('#venta_cambio').value="0.00";
        }

    }


    /*----------  Buscar codigo  ----------*/
    function buscar_codigo(){
        let input_codigo=document.querySelector('#input_codigo').value;

        input_codigo=input_codigo.trim();

        if(input_codigo!=""){

            let datos = new FormData();
            datos.append("buscar_codigo", input_codigo);
            datos.append("modulo_venta", "buscar_codigo");

            fetch('<?php echo SERVERURL; ?>ajax/ventaAjax.php',{
                method: 'POST',
                body: datos
            })
            .then(respuesta => respuesta.text())
            .then(respuesta =>{
                let tabla_productos=document.querySelector('#tabla_productos');
                tabla_productos.innerHTML=respuesta;
            });

        }else{
            Swal.fire({
                title: 'Ocurrió un error inesperado',
                text: 'Debes de introducir el Nombre, Marca o Modelo del producto',
                type: 'error',
                confirmButtonText: 'Aceptar'
            });
        }
    }

    /*----------  Agregar codigo  ----------*/
    function agregar_codigo($codigo){
        $('#modal_buscar_codigo').modal('hide');
        document.querySelector('#sale-barcode-input').value=$codigo;
        setTimeout('agregar_producto()',100);
    }
</script>

<?php
	include "./vistas/inc/print_invoice_script.php";
?>
