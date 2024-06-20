<?php
    include "./vistas/inc/admin_security.php";
?>
<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
        <i class="fas fa-user-tie fa-fw"></i> &nbsp; Nuevo usuario
    </h3>
    <p class="text-justify">
        En el módulo USUARIO podrá registrar nuevos usuarios en el sistema ya sea un administrador o un cajero, también podrá ver la lista de usuarios registrados, buscar usuarios en el sistema, actualizar datos de otros usuarios y los suyos.
    </p>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs text-uppercase">
        <li>
            <a class="active" href="<?php echo SERVERURL; ?>user-new/">
                <i class="fas fa-user-tie fa-fw"></i> &nbsp; Nuevo usuario
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>user-list/">
                <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de usuarios
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>user-search/">
                <i class="fas fa-search fa-fw"></i> &nbsp; Buscar usuario
            </a>
        </li>
    </ul>	
</div>

<div class="container-fluid">
    <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/usuarioAjax.php" method="POST" data-form="save" autocomplete="off" >
        <input type="hidden" name="modulo_usuario" value="registrar">
        <fieldset>
            <legend><i class="far fa-address-card"></i> &nbsp; Información personal</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="usuario_tipo_documento" class="bmd-label-floating">Tipo de documento <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <select class="form-control" name="usuario_tipo_documento_reg" id="usuario_tipo_documento">
                                <option value="" selected="" >Seleccione una opción</option>
                                <?php
                                    echo $lc->generar_select(DOCUMENTOS_USUARIOS,"VACIO");
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="usuario_numero_documento" class="bmd-label-floating">Numero de documento <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[a-zA-Z0-9-]{7,30}" class="form-control" name="usuario_numero_documento_reg" id="usuario_numero_documento" maxlength="30">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="usuario_cargo" class="bmd-label-floating">Cargo <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <select class="form-control" name="usuario_cargo_reg" id="usuario_cargo">
                                <option value="" selected="">Seleccione una opción</option>
                                <option value="Administrador">1 - Administrador</option>
                                <option value="Cajero">2 - Cajero</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="usuario_nombre" class="bmd-label-floating">Nombres <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,35}" class="form-control" name="usuario_nombre_reg" id="usuario_nombre" maxlength="35">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="usuario_apellido" class="bmd-label-floating">Apellidos <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,35}" class="form-control" name="usuario_apellido_reg" id="usuario_apellido" maxlength="35">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="usuario_telefono" class="bmd-label-floating">Teléfono</label>
                            <input type="text" pattern="[0-9()+]{8,20}" class="form-control" name="usuario_telefono_reg" id="usuario_telefono" maxlength="20">
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
                        <legend><i class="fas fa-user-friends"></i> &nbsp; Genero</legend>
                        <div class="form-group">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="usuario_genero_reg" value="Masculino" checked >
                                    <i class="fas fa-male fa-fw"></i> &nbsp; Masculino
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="usuario_genero_reg" value="Femenino">
                                    <i class="fas fa-female fa-fw"></i> &nbsp; Femenino
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <legend><i class="fas fa-barcode"></i> &nbsp; Configuración de lector de código de barras</legend>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="usuario_lector_reg" value="Habilitado" checked >
                                                <i class="far fa-check-circle fa-fw"></i> &nbsp; Usar lector
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="usuario_lector_reg" value="Deshabilitado">
                                                <i class="far fa-times-circle fa-fw"></i> &nbsp; No usar lector
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="usuario_tipo_codigo_reg" value="Barras" checked >
                                                <i class="fas fa-barcode fa-fw"></i> &nbsp; Código barras
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="usuario_tipo_codigo_reg" value="SKU">
                                                <i class="fas fa-barcode fa-fw"></i> &nbsp; Código SKU
                                            </label>
                                        </div>
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
            <legend><i class="fas fa-cash-register"></i> &nbsp; Caja de ventas</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <select class="form-control" name="usuario_caja_reg">
                                <option value="" selected="" >Seleccione una opción</option>
                                <?php
                                    $datos_caja=$lc->datos_tabla("Normal","caja","*",0);

                                    while($campos_caja=$datos_caja->fetch()){
                                        if($campos_caja['caja_estado']=="Habilitada"){
                                            echo '<option value="'.$campos_caja['caja_id'].'">Caja No.'.$campos_caja['caja_numero'].' ('.$campos_caja['caja_nombre'].')</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <br><br><br>
        <fieldset>
            <legend><i class="fas fa-user-lock"></i> &nbsp; Información de la cuenta</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="usuario_usuario" class="bmd-label-floating">Nombre de usuario <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[a-zA-Z0-9]{4,25}" class="form-control" name="usuario_usuario_reg" id="usuario_usuario" maxlength="25">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="usuario_email" class="bmd-label-floating">Email</label>
                            <input type="email" class="form-control" name="usuario_email_reg" id="usuario_email" maxlength="50">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="usuario_clave_1" class="bmd-label-floating">Contraseña <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="password" class="form-control" name="usuario_clave_1_reg" id="usuario_clave_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="usuario_clave_2" class="bmd-label-floating">Repetir contraseña <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="password" class="form-control" name="usuario_clave_2_reg" id="usuario_clave_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="usuario_estado" class="bmd-label-floating">Estado de la cuenta <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <select class="form-control" name="usuario_estado_reg" id="usuario_estado">
                                <option value="Activa" selected="" >1 - Activa</option>
                                <option value="Deshabilitada">2 - Deshabilitada</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <br><br><br>
        <fieldset>
            <div class="container-fluid">
            <legend><i class="fas fa-portrait"></i> &nbsp; Avatar</legend>
                <div class="row">
                    <?php
                        $directorio_avatar=opendir("./vistas/assets/avatar/");

                        $check="checked";
                        while($avatar=readdir($directorio_avatar)){
                            if(is_file("./vistas/assets/avatar/".$avatar)){
                                echo '
                                    <div class="col-6 col-md-4 col-lg-2">
                                        <div class="radio radio-avatar-form">
                                            <label>
                                                <input type="radio" name="usuario_avatar_reg" value="'.$avatar.'" '.$check.' >
                                                <img src="'.SERVERURL.'vistas/assets/avatar/'.$avatar.'" alt="'.$avatar.'" class="img-fluid img-avatar-form">
                                            </label>
                                        </div>
                                    </div>
                                ';
                                $check="";
                            }
                        }
                    ?>
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