<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
        <i class="far fa-money-bill-alt fa-fw"></i> &nbsp; Nuevo movimiento
    </h3>
    <p class="text-justify">
        En el módulo MOVIMIENTOS usted puede realizar, buscar y ver todos los movimientos de efectivo realizados en las cajas de ventas. Los movimientos de <strong>“Entrada de efectivo”</strong> son aquellos donde se ingresa dinero a las cajas de ventas. Los movimientos de <strong>“Retiro de efectivo”</strong> son aquellos donde se extrae el dinero de las cajas de ventas. 
    </p>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs text-uppercase">
        <li>
            <a class="active" href="<?php echo SERVERURL; ?>movement-new/">
                <i class="far fa-money-bill-alt fa-fw"></i> &nbsp; Nuevo movimiento
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>movement-list/">
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
    <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/movimientoAjax.php" method="POST" data-form="save" autocomplete="off">
        <input type="hidden" name="modulo_movimiento" value="registrar">
        <fieldset>
            <legend><i class="fas fa-info-circle"></i> &nbsp; Información del movimiento</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="movimiento_tipo" class="bmd-label-floating">Caja <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <select class="form-control" name="movimiento_caja_reg">
                                <option value="" selected="" >Seleccione una opción</option>
                                <?php
                                    $datos_caja=$lc->datos_tabla("Normal","caja","*",0);

                                    while($campos_caja=$datos_caja->fetch()){
                                        echo '<option value="'.$campos_caja['caja_id'].'">Caja No.'.$campos_caja['caja_numero'].' ('.$campos_caja['caja_nombre'].' - '.MONEDA_SIMBOLO.$campos_caja['caja_efectivo'].' '.MONEDA_NOMBRE.')</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="movimiento_tipo" class="bmd-label-floating">Tipo de movimiento <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <select class="form-control" name="movimiento_tipo_reg" id="movimiento_tipo">
                            <option value="" selected="" >Seleccione una opción</option>
                                <option value="Retiro de efectivo">Retiro de efectivo</option>
                                <option value="Entrada de efectivo">Entrada de efectivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="movimiento_cantidad" class="bmd-label-floating">Cantidad de efectivo <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[0-9.]{1,25}" class="form-control" name="movimiento_cantidad_reg" value="0.00" id="movimiento_cantidad" maxlength="25">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="movimiento_motivo" class="bmd-label-floating">Motivo del movimiento <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{5,70}" class="form-control" name="movimiento_motivo_reg" id="movimiento_motivo" maxlength="70">
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <p class="text-center" style="margin-top: 40px;">
            <button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
            &nbsp; &nbsp;
            <button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
        </p>
        <p class="text-center">
            <small>Los campos marcados con <?php echo CAMPO_OBLIGATORIO; ?> son obligatorios</small>
        </p>
    </form>
</div>