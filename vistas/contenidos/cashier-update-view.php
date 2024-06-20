<?php
    include "./vistas/inc/admin_security.php";
?>
<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
        <i class="fas fa-sync fa-fw"></i> &nbsp; Actualizar caja
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
            <a href="<?php echo SERVERURL; ?>cashier-list/">
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
        include "./vistas/inc/btn_go_back.php";
        
        $datos_caja=$lc->datos_tabla("Unico","caja","caja_id",$pagina[1]);

        if($datos_caja->rowCount()==1){
            $campos=$datos_caja->fetch();
    ?>
    <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/cajaAjax.php" method="POST" data-form="update" autocomplete="off">
        <input type="hidden" name="caja_id_up" value="<?php echo $pagina[1]; ?>" >
        <input type="hidden" name="modulo_caja" value="actualizar">
        <fieldset>
            <legend><i class="far fa-address-card"></i> &nbsp; Información de la caja</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="caja_numero" class="bmd-label-floating">Numero de caja <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[0-9]{1,5}" class="form-control" name="caja_numero_up" value="<?php echo $campos['caja_numero']; ?>" id="caja_numero" maxlength="5">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="caja_nombre" class="bmd-label-floating">Nombre o código de caja <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ:# ]{3,70}" class="form-control" name="caja_nombre_up" value="<?php echo $campos['caja_nombre']; ?>" id="caja_nombre" maxlength="70">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="caja_estado" class="bmd-label-floating">Estado de la caja</label>
                            <select class="form-control" name="caja_estado_up" id="caja_estado">
                                <?php
                                    $array_estado=["Habilitada","Deshabilitada"];
                                    echo $lc->generar_select($array_estado,$campos['caja_estado']);
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="caja_efectivo" class="bmd-label-floating">Efectivo en caja</label>
                            <input type="text" pattern="[0-9.]{1,25}" class="form-control" name="caja_efectivo_up" value="<?php echo number_format($campos['caja_efectivo'],MONEDA_DECIMALES,'.',''); ?>" id="caja_efectivo" maxlength="25">
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <p class="text-center" style="margin-top: 40px;">
            <button type="submit" class="btn btn-raised btn-success btn-sm"><i class="fas fa-sync"></i> &nbsp; ACTUALIZAR</button>
        </p>
        <p class="text-center">
            <small>Los campos marcados con <?php echo CAMPO_OBLIGATORIO; ?> son obligatorios</small>
        </p>
    </form>
    <?php 
        }else{
            include "./vistas/inc/error_alert.php";
        } 
    ?>
</div>