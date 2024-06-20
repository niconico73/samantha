<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
        <i class="fas fa-cart-plus fa-fw"></i> &nbsp; Detalles de venta
    </h3>
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

<div class="container-fluid form-neon">
    <?php
        include "./vistas/inc/btn_go_back.php";

        $datos_venta=$lc->datos_tabla("Normal","venta INNER JOIN cliente ON venta.cliente_id=cliente.cliente_id INNER JOIN usuario ON venta.usuario_id=usuario.usuario_id INNER JOIN caja ON venta.caja_id=caja.caja_id WHERE (venta_codigo='".$pagina[1]."')","*",0);

        if($datos_venta->rowCount()==1){
            $datos_venta=$datos_venta->fetch();
    ?>
    <h4 class="text-center">Datos de venta</h4>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-4">
                <p class="text-center text-uppercase font-weight-bold bg-dark" style="color: #FFF;" >Datos venta</p>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Tipo de venta
                        <span><?php echo $datos_venta['venta_tipo']; ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Fecha
                        <span><?php echo date("d-m-Y", strtotime($datos_venta['venta_fecha']))." ".$datos_venta['venta_hora']; ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Nro. de factura
                        <span><?php echo $datos_venta['venta_id']; ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Código de venta
                        <span><?php echo $datos_venta['venta_codigo']; ?></span>
                    </li>
                </ul>
            </div>
            <div class="col-12 col-lg-4">
                <p class="text-center text-uppercase font-weight-bold bg-dark" style="color: #FFF;" >Caja & usuarios</p>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Caja
                        <span><?php echo $datos_venta['caja_numero']." (".$datos_venta['caja_nombre']; ?>)</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Vendedor
                        <span><?php echo $datos_venta['usuario_nombre']." ".$datos_venta['usuario_apellido']; ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Cliente
                        <span><?php echo $datos_venta['cliente_nombre']." ".$datos_venta['cliente_apellido']; ?></span>
                    </li>
                </ul>
            </div>
            <div class="col-12 col-lg-4">
                <p class="text-center text-uppercase font-weight-bold bg-dark" style="color: #FFF;" >Totales & estado</p>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Total
                        <span><?php echo MONEDA_SIMBOLO.number_format($datos_venta['venta_total_final'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).' '.MONEDA_NOMBRE; ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Pagado
                        <span><?php echo MONEDA_SIMBOLO.number_format($datos_venta['venta_pagado'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).' '.MONEDA_NOMBRE; ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Cambio
                        <span><?php echo MONEDA_SIMBOLO.number_format($datos_venta['venta_cambio'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).' '.MONEDA_NOMBRE; ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Estado
                        <?php
                            if($datos_venta['venta_estado']=="Cancelado"){
                                echo '<span class="badge badge-secondary">'.$datos_venta['venta_estado'].'</span>';
                            }else{
                                $venta_saldo_pendiente=$datos_venta['venta_total_final']-$datos_venta['venta_pagado'];
                                echo '<span class="badge badge-warning">'.$datos_venta['venta_estado'].' ('.MONEDA_SIMBOLO.number_format(($venta_saldo_pendiente),MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).' '.MONEDA_NOMBRE.')</span>';
                            }
                        ?>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Costos de venta
                        <span><?php echo MONEDA_SIMBOLO.number_format($datos_venta['venta_costo'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).' '.MONEDA_NOMBRE; ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Utilidad (Ganancias)
                        <span><?php echo MONEDA_SIMBOLO.number_format($datos_venta['venta_utilidad'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).' '.MONEDA_NOMBRE; ?></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <h4 class="text-center">Detalles de venta</h4>
    <div class="container-fluid">
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead class="bg-info">
                    <tr class="text-center text-uppercase">
                        <th scope="col">#</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Subtotal</th>
                        <th scope="col"><?php echo $datos_venta['venta_impuesto_nombre'].' '.$datos_venta['venta_impuesto_porcentaje']; ?>%</th>
                        <th scope="col">Total</th>
                        <th scope="col">Dev.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $detalle_venta=$lc->datos_tabla("Normal","venta_detalle WHERE venta_codigo='".$datos_venta['venta_codigo']."'","*",0);
                        if($detalle_venta->rowCount()>=1){
                            $detalle_venta=$detalle_venta->fetchAll();
                            $cc=1;
                            foreach($detalle_venta as $detalle){
                                echo '
                                <tr class="text-center text-uppercase">
                                    <th scope="row">'.$cc.'</th>
                                    <td>'.$detalle['venta_detalle_descripcion'].'</td>
                                    <td>'.$detalle['venta_detalle_cantidad'].'</td>
                                    <td>'.MONEDA_SIMBOLO.number_format($detalle['venta_detalle_precio_venta'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).' '.MONEDA_NOMBRE.'</td>
                                    <td>'.MONEDA_SIMBOLO.number_format($detalle['venta_detalle_subtotal'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).' '.MONEDA_NOMBRE.'</td>
                                    <td>'.MONEDA_SIMBOLO.number_format($detalle['venta_detalle_impuestos'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).' '.MONEDA_NOMBRE.'</td>
                                    <td>'.MONEDA_SIMBOLO.number_format($detalle['venta_detalle_total'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).' '.MONEDA_NOMBRE.'</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-toggle="popover" data-trigger="hover" title="Realizar devolución" data-content="'.$detalle['venta_detalle_descripcion'].'" onclick="devolucion_producto(\''.$detalle['producto_id'].'\',\''.$detalle['venta_detalle_descripcion'].'\')" >
                                            <i class="fas fa-dolly fa-fw"></i>
                                        </button>
                                    </td>
                                </tr>
                                ';
                                $cc++;
                            }
                            echo '
                            <tr class="text-center text-uppercase font-weight-bold">
                                <td colspan="3"></td>
                                <td></td>
                                <td></td>
                                <td>Total</td>
                                <td>'.MONEDA_SIMBOLO.number_format($datos_venta['venta_total_final'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).' '.MONEDA_NOMBRE.'</td>
                                <td></td>
                            </tr>
                            ';
                        }else{
                            echo '<tr class="text-center text-uppercase"><td colspan="9">No hay datos para mostrar</td></tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <hr style="margin: 70px 0; ">

    <h4 class="text-center">Pagos realizados</h4>
<div class="container-fluid">
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="bg-primary">
                <tr class="text-center text-uppercase">
                    <th scope="col">#</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Monto</th>
                    <th scope="col">Vendedor</th>
                    <th scope="col">Caja</th>
                    <th scope="col">Banco</th>
                    <th scope="col">N° operación</th>
                    <th scope="col">Acciones</th> </tr>
            </thead>
            <tbody>
                <?php
                $datos_pago = $lc->datos_tabla(
                    "Normal",
                    "pago INNER JOIN usuario ON pago.usuario_id=usuario.usuario_id 
                     INNER JOIN caja ON pago.caja_id=caja.caja_id 
                     LEFT JOIN detalle_pago ON pago.venta_codigo = detalle_pago.venta_codigo 
                     WHERE (pago.venta_codigo='" . $datos_venta['venta_codigo'] . "')",
                    "*",
                    0
                );
                if ($datos_pago->rowCount() >= 1) {
                    $datos_pago = $datos_pago->fetchAll();
                    $cc = 1;
                    foreach ($datos_pago as $pago) {
                        echo '
                            <tr class="text-center text-uppercase">
                                <th scope="row">' . $cc . '</th>
                                <td>' . date("d-m-Y", strtotime($pago['pago_fecha'])) . '</td>
                                <td>' . MONEDA_SIMBOLO . number_format($pago['pago_monto'], MONEDA_DECIMALES, MONEDA_SEPARADOR_DECIMAL, MONEDA_SEPARADOR_MILLAR) . ' ' . MONEDA_NOMBRE . '</td>
                                <td>' . $pago['usuario_nombre'] . " " . $pago['usuario_apellido'] . '</td>
                                <td>Caja #' . $pago['caja_numero'] . " - " . $pago['caja_nombre'] . '</td>
                                <td>' . (isset($pago['metodo_pago']) ? $pago['metodo_pago'] : 'N/A') . '</td> 
                                <td>' . (isset($pago['numero_operacion']) ? $pago['numero_operacion'] : 'N/A') . '</td>
                                <td>';

                        // Mostrar el botón solo si no hay detalles de pago registrados
                        if (empty($pago['metodo_pago']) || empty($pago['numero_operacion'])) {
                            echo '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ModalEditDetallePago" data-pago-id="' . $pago['pago_id'] . '">
                                      Agregar Detalles
                                  </button>';
                        }

                        echo '</td>
                            </tr>';
                        $cc++;
                    }
                } else {
                    echo '<tr class="text-center text-uppercase"><td colspan="8">No hay datos para mostrar</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
        <?php if($datos_venta['venta_pagado']<$datos_venta['venta_total_final'] && $datos_venta['venta_tipo']="Credito"){ ?>
        <p class="text-center">
            <button type="button" class="btn btn-primary btn-raised" href="#" data-toggle="modal" data-target="#ModalAddPayment"><i class="fas fa-money-bill-wave fa-fw"></i> &nbsp; Agregar un nuevo pago</button>
        </p>
        <?php } ?>
        <?php if ($datos_venta['venta_pagado'] < $datos_venta['venta_total_final'] && $datos_venta['venta_tipo'] == "Credito") { ?>
  
<?php } ?>
    </div>
    

<!-- Modal DETALLES -->
<div class="modal fade" id="ModalEditDetallePago" tabindex="-1" role="dialog" aria-labelledby="ModalEditDetallePagoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalEditDetallePagoLabel">Agregar Detalle de Pago</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="detallePagoForm" class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/ventaAjax.php" method="POST" data-form="save" autocomplete="off">
                    <input type="hidden" name="modulo_venta" value="registrar_detalle_pago">
                    <!-- Input oculto para almacenar el ID del pago -->
                    <input type="hidden" id="venta_codigo" name="venta_codigo" value="">
                    <input type="hidden" id="pago_id" name="pago_id" value="">
                    <div class="form-group">
                        <label for="metodo_pago">Método de pago:</label>
                        <select id="metodo_pago" class="form-control" name="metodo_pago">
                            <option value="">Selecciona un método de pago</option>
                            <option value="BCP">BCP</option>
                            <option value="YAPE">YAPE</option>
                            <option value="PLIM">PLIM</option>
                            <option value="BBVA">BBVA</option>
                            <option value="INTERBANK">INTERBANK</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="numero_operacion">N° de operación:</label>
                        <input type="text" class="form-control" id="numero_operacion" name="numero_operacion">
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Detalle de Pago</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

   <!--FIN Modal DETALLES -->
    <hr style="margin: 70px 0; ">

    <h4 class="text-center">Devoluciones realizadas</h4>
    <div class="container-fluid" id="return-sale" >
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead class="bg-success">
                    <tr class="text-center text-uppercase">
                        <th scope="col">#</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Producto</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Total</th>
                        <th scope="col">Vendedor</th>
                        <th scope="col">Caja</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $datos_devolucion=$lc->datos_tabla("Normal","devolucion INNER JOIN usuario ON devolucion.usuario_id=usuario.usuario_id INNER JOIN caja ON devolucion.caja_id=caja.caja_id WHERE (devolucion.compra_venta_codigo='".$datos_venta['venta_codigo']."' AND devolucion.devolucion_tipo='Devolución de venta')","*",0);
                        if($datos_devolucion->rowCount()>=1){
                            $datos_devolucion=$datos_devolucion->fetchAll();
                            $cc=1;
                            foreach($datos_devolucion as $devolucion){
                                echo '
                                <tr class="text-center text-uppercase">
                                    <th scope="row">'.$cc.'</th>
                                    <td>'.date("d-m-Y", strtotime($devolucion['devolucion_fecha']))." ".$devolucion['devolucion_hora'].'</td>
                                    <td>'.$devolucion['devolucion_descripcion'].'</td>
                                    <td>'.$devolucion['devolucion_cantidad'].'</td>
                                    <td>'.MONEDA_SIMBOLO.number_format($devolucion['devolucion_precio'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).' '.MONEDA_NOMBRE.'</td>
                                    <td>'.MONEDA_SIMBOLO.number_format($devolucion['devolucion_total'],MONEDA_DECIMALES,MONEDA_SEPARADOR_DECIMAL,MONEDA_SEPARADOR_MILLAR).' '.MONEDA_NOMBRE.'</td>
                                    <td>'.$devolucion['usuario_nombre']." ".$devolucion['usuario_apellido'].'</td>
                                    <td>Caja #'.$devolucion['caja_numero']." - ".$devolucion['caja_nombre'].'</td>
                                </tr>
                                ';
                                $cc++;
                            }
                        }else{
                            echo '<tr class="text-center text-uppercase"><td colspan="8">No hay datos para mostrar</td></tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <p class="text-center">
        <a href="#" class="btn btn-outline-info print-barcode" data-id="#return-sale"><i class="fas fa-print"></i> &nbsp; Imprimir</a>
    </p>

    <!-- Modal AddPayment -->
    <div class="modal fade" id="ModalAddPayment" tabindex="-1" role="dialog" aria-labelledby="ModalAddPayment" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form class="modal-content FormularioAjax" action="<?php echo SERVERURL; ?>ajax/ventaAjax.php" method="POST" data-form="save" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalAddPayment">Realizar pago de venta Nro.<?php echo $datos_venta['venta_id']." (".$datos_venta['venta_codigo']; ?>)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="modulo_venta" value="agregar_pago">
                    <input type="hidden" name="pago_codigo_reg" value="<?php echo $datos_venta['venta_codigo']; ?>">
                    <input type="hidden" id="pago_total_pendiente" value="<?php echo number_format(($venta_saldo_pendiente),MONEDA_DECIMALES,'.',''); ?>">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <?php
                                        $datos_caja=$lc->datos_tabla("Normal","caja WHERE caja_id='".$_SESSION['caja_svi']."'","*",0);
                                        $datos_caja=$datos_caja->fetch();
                                    ?>
                                    <label for="pago_caja">Caja</label>
                                    <input type="text" class="form-control" value="Caja Nro.<?php echo $datos_caja['caja_numero']." (".$datos_caja['caja_nombre']; ?>)" id="pago_caja" readonly >
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="pago_pendiente">Pendiente</label>
                                    <input type="text" class="form-control" value="<?php echo number_format(($venta_saldo_pendiente),MONEDA_DECIMALES,'.',''); ?>" id="pago_pendiente" readonly >
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="pago_monto">Monto</label>
                                    <input type="text" class="form-control" id="pago_monto" name="pago_monto_reg" pattern="[0-9.]{1,25}" maxlength="25" >
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="pago_cambio">Cambio</label>
                                    <input type="text" class="form-control" value="0.00" id="pago_cambio" readonly >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-times-circle"></i> &nbsp; Cancelar</button>
                    <button type="submit" class="btn btn-info"><i class="fas fa-money-bill-wave fa-fw"></i> &nbsp; Agregar pago</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal devolucion -->
    <div class="modal fade" id="ModalReturn" tabindex="-1" role="dialog" aria-labelledby="ModalReturn" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form class="modal-content FormularioAjax" action="<?php echo SERVERURL; ?>ajax/devolucionAjax.php" method="POST" data-form="save" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalReturn">Realizar devolución (<span id="devolucion_descripcion"></span>)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="modulo_devolucion" value="venta">
                    <input type="hidden" name="codigo_venta" id="codigo_venta" value="<?php echo $datos_venta['venta_codigo']; ?>">
                    <input type="hidden" name="id_producto" id="id_producto" value="">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="devolucion_caja">Caja</label>
                                    <input type="text" class="form-control" value="Caja Nro.<?php echo $datos_caja['caja_numero']." (".$datos_caja['caja_nombre']; ?>)" id="devolucion_caja" readonly >
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="devolucion_cantidad">Cantidad a devolver</label>
                                    <input type="text" class="form-control" id="devolucion_cantidad" name="devolucion_cantidad" pattern="[0-9]{1,9}" maxlength="9" >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-times-circle"></i> &nbsp; Cancelar</button>
                    <button type="submit" class="btn btn-info"><i class="fas fa-dolly fa-fw"></i> &nbsp; Realizar devolución</button>
                </div>
            </form>
        </div>
    </div>

<!-- Incluir jQuery y Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {
    // Función para abrir el modal con el formulario limpio
    function abrirModalAgregarDetallePago(pago_id, venta_codigo) {
        $('#pago_id').val(pago_id); // Asigna el pago_id al input oculto
        $('#venta_codigo').val(venta_codigo); // Asigna el venta_codigo al input oculto
        $('#ModalEditDetallePago').modal('show');
        $('#metodo_pago').val(''); // Limpiar el campo de método de pago
        $('#numero_operacion').val(''); // Limpiar el campo de número de operación
    }

    // Evento para abrir el modal al hacer clic en un botón de agregar detalle de pago
    $('#btnAgregarDetallePago').click(function() {
        var pago_id = obtenerPagoId(); // Obtener el ID del pago
        var venta_codigo = obtenerVentaCodigo(); // Obtener el código de venta
        if (pago_id && venta_codigo) {
            abrirModalAgregarDetallePago(pago_id, venta_codigo);
        } else {
            alert('Error: No se pudo obtener el ID del pago o el código de venta.');
        }
    });

    // Manejar envío del formulario
    $('#detallePagoForm').submit(function(e) {
        e.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'json',
            data: formData,
            success: function(response) {
                if (response.success) {
                    alert(response.message); // Muestra mensaje de éxito
                    $('#ModalEditDetallePago').modal('hide'); // Cierra el modal
                } else {
                    alert(response.message); // Muestra mensaje de error
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud AJAX:', error);
                alert('Error en la solicitud AJAX. Verifica la consola para más detalles.');
            }
        });
    });

    // Función para obtener el pago_id correspondiente
    function obtenerPagoId() {
        // Aquí debes implementar la lógica para obtener el pago_id deseado
        // Por ejemplo, puedes obtenerlo de un input oculto en tu página
        return $('#pago_id').val(); // Suponiendo que tengas un input con el ID del pago
    }

    // Función para obtener el venta_codigo correspondiente
    function obtenerVentaCodigo() {
        // Aquí debes implementar la lógica para obtener el venta_codigo deseado
        // Por ejemplo, puedes obtenerlo de un input oculto en tu página
        return $('#venta_codigo').val(); // Suponiendo que tengas un input con el código de venta
    }
});

</script>
</script>
    <script>
        /*----------  Calcular cambio  ----------*/
        let pago_abono_input = document.querySelector("#pago_monto");

        pago_abono_input.addEventListener('keyup', function(event){
            event.preventDefault();

            let abono=document.querySelector('#pago_monto').value;
            abono=abono.trim();
            abono=parseFloat(abono);

            let total=document.querySelector('#pago_total_pendiente').value;
            total=total.trim();
            total=parseFloat(total);

            if(abono>=total){
                cambio=abono-total;
                cambio=parseFloat(cambio).toFixed(2);
                document.querySelector('#pago_cambio').value=cambio;
            }else{
                document.querySelector('#pago_cambio').value="0.00";
            }
        });


        /*----------  Hacer devolucion  ----------*/
        function devolucion_producto(producto,descripcion){
            producto.trim();
            descripcion.trim();

            document.querySelector('#id_producto').value=producto;
            document.querySelector('#devolucion_descripcion').innerHTML=descripcion;

            $('#ModalReturn').modal('show');
        }

           
    </script>
    <?php 
        }else{
            include "./vistas/inc/error_alert.php";
            echo '<p class="text-center">*** Es posible que la venta haya sido eliminada del sistema ***</p>';
        }
    ?>
</div>