<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
        <i class="fas fa-sync fa-fw"></i> &nbsp; Actualizar cliente
    </h3>
    <p class="text-justify">
        En el módulo CLIENTE podrá registrar en el sistema los datos de sus clientes más frecuentes para realizar ventas, además podrá realizar búsquedas de clientes, actualizar datos de sus clientes o eliminarlos si así lo desea.
    </p>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs text-uppercase">
        <li>
            <a href="<?php echo SERVERURL; ?>client-new/">
                <i class="fas fa-child fa-fw"></i> &nbsp; Nuevo cliente
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>client-list/">
                <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de clientes
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>client-search/">
                <i class="fas fa-search fa-fw"></i> &nbsp; Buscar cliente
            </a>
        </li>
    </ul>	
</div>

<div class="container-fluid">
    <?php
        include "./vistas/inc/btn_go_back.php";
        
        $datos_cliente=$lc->datos_tabla("Unico","cliente","cliente_id",$pagina[1]);

        if($datos_cliente->rowCount()==1){
            $campos=$datos_cliente->fetch();
    ?>
    <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/clienteAjax.php" method="POST" data-form="update" autocomplete="off" >
        <input type="hidden" name="cliente_id_up" value="<?php echo $pagina[1]; ?>">
        <input type="hidden" name="modulo_cliente" value="actualizar">
        <fieldset>
            <legend><i class="far fa-address-card"></i> &nbsp; Información personal</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="cliente_tipo_documento" class="bmd-label-floating">Tipo de documento <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <select class="form-control" name="cliente_tipo_documento_up" id="cliente_tipo_documento">
                                <option value="" selected="" >Seleccione una opción</option>
                                <?php
                                    echo $lc->generar_select(DOCUMENTOS_USUARIOS,$campos['cliente_tipo_documento']);
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="cliente_numero_documento" class="bmd-label-floating">Numero de documento <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[a-zA-Z0-9-]{7,30}" class="form-control" name="cliente_numero_documento_up" value="<?php echo $campos['cliente_numero_documento']; ?>" id="cliente_numero_documento" maxlength="30">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="cliente_nombre" class="bmd-label-floating">Nombres <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,35}" class="form-control" name="cliente_nombre_up" value="<?php echo $campos['cliente_nombre']; ?>" id="cliente_nombre" maxlength="35">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="cliente_apellido" class="bmd-label-floating">Apellidos <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,35}" class="form-control" name="cliente_apellido_up" value="<?php echo $campos['cliente_apellido']; ?>" id="cliente_apellido" maxlength="35">
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <br><br><br>
        <fieldset>
            <legend><i class="fas fa-map-marked-alt"></i> &nbsp; Información de residencia</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cliente_provincia" class="bmd-label-floating">Estado, provincia o departamento <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,30}" class="form-control" name="cliente_provincia_up" value="<?php echo $campos['cliente_provincia']; ?>" id="cliente_provincia" maxlength="30">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cliente_ciudad" class="bmd-label-floating">Ciudad o pueblo <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,30}" class="form-control" name="cliente_ciudad_up" value="<?php echo $campos['cliente_ciudad']; ?>" id="cliente_ciudad" maxlength="30">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cliente_direccion" class="bmd-label-floating">Calle o dirección de casa <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{4,70}" class="form-control" name="cliente_direccion_up" value="<?php echo $campos['cliente_direccion']; ?>" id="cliente_direccion" maxlength="70">
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <br><br><br>
        <fieldset>
            <legend><i class="far fa-address-book"></i> &nbsp; Información de contacto</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="cliente_telefono" class="bmd-label-floating">Teléfono <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[0-9()+]{8,20}" class="form-control" name="cliente_telefono_up" value="<?php echo $campos['cliente_telefono']; ?>" id="cliente_telefono" maxlength="20">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="cliente_email" class="bmd-label-floating">Email</label>
                            <input type="email" class="form-control" name="cliente_email_up" value="<?php echo $campos['cliente_email']; ?>" id="cliente_email" maxlength="50">
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