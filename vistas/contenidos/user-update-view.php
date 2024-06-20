<?php
    if($lc->encryption($_SESSION['id_svi'])!=$pagina[1]){
        if($_SESSION['cargo_svi']!="Administrador"){
            $lc->forzar_cierre_sesion_controlador();
            exit();
        }
    }
?>
<div class="full-box page-header">
    <h3 class="text-left text-uppercase">
        <i class="fas fa-sync fa-fw"></i> &nbsp; Actualizar cuenta
    </h3>
    <p class="text-justify">
        En el módulo USUARIO podrá registrar nuevos usuarios en el sistema ya sea un administrador o un cajero, también podrá ver la lista de usuarios registrados, buscar usuarios en el sistema, actualizar datos de otros usuarios y los suyos.
    </p>
</div>

<?php if($_SESSION['cargo_svi']=="Administrador"){ ?>
<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs text-uppercase">
        <li>
            <a href="<?php echo SERVERURL; ?>user-new/">
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
<?php } ?>

<div class="container-fluid">
    <?php
        include "./vistas/inc/btn_go_back.php";
        
        $datos_usuario=$lc->datos_tabla("Unico","usuario","usuario_id",$pagina[1]);

        if($datos_usuario->rowCount()==1){
            $campos=$datos_usuario->fetch();
    ?>
    <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/usuarioAjax.php" method="POST" data-form="update" autocomplete="off" >
        <input type="hidden" name="usuario_id_up" value="<?php echo $pagina[1]; ?>">
        <input type="hidden" name="modulo_usuario" value="actualizar">
        <fieldset>
            <legend><i class="far fa-address-card"></i> &nbsp; Información personal</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="usuario_tipo_documento" class="bmd-label-floating">Tipo de documento <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <select class="form-control" name="usuario_tipo_documento_up" id="usuario_tipo_documento">
                                <?php
                                    echo $lc->generar_select(DOCUMENTOS_USUARIOS,$campos['usuario_tipo_documento']);
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="usuario_numero_documento" class="bmd-label-floating">Numero de documento <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[a-zA-Z0-9-]{7,30}" class="form-control" name="usuario_numero_documento_up" value="<?php echo $campos['usuario_numero_documento']; ?>" id="usuario_numero_documento" maxlength="30">
                        </div>
                    </div>
                    <?php if($_SESSION['cargo_svi']=="Administrador" && $campos['usuario_id']!=1){ ?>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="usuario_cargo" class="bmd-label-floating">Cargo <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <select class="form-control" name="usuario_cargo_up" id="usuario_cargo">
                                <?php
                                    $array_cargo=["Administrador","Cajero"];
                                    echo $lc->generar_select($array_cargo,$campos['usuario_cargo']);
                                ?> 
                            </select>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="usuario_nombre" class="bmd-label-floating">Nombres <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,35}" class="form-control" name="usuario_nombre_up" value="<?php echo $campos['usuario_nombre']; ?>" id="usuario_nombre" maxlength="35">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="usuario_apellido" class="bmd-label-floating">Apellidos <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,35}" class="form-control" name="usuario_apellido_up" value="<?php echo $campos['usuario_apellido']; ?>" id="usuario_apellido" maxlength="35">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="usuario_telefono" class="bmd-label-floating">Teléfono</label>
                            <input type="text" pattern="[0-9()+]{8,20}" class="form-control" name="usuario_telefono_up" value="<?php echo $campos['usuario_telefono']; ?>" id="usuario_telefono" maxlength="20">
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
                                    <input type="radio" name="usuario_genero_up" value="Masculino" <?php if($campos['usuario_genero']=="Masculino"){ echo "checked"; } ?> >
                                    <i class="fas fa-male fa-fw"></i> &nbsp; Masculino
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="usuario_genero_up" value="Femenino" <?php if($campos['usuario_genero']=="Femenino"){ echo "checked"; } ?> >
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
                                                <input type="radio" name="usuario_lector_up" value="Habilitado" <?php if($campos['usuario_lector']=="Habilitado"){ echo "checked"; } ?> >
                                                <i class="far fa-check-circle fa-fw"></i> &nbsp; Usar lector
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="usuario_lector_up" value="Deshabilitado" <?php if($campos['usuario_lector']=="Deshabilitado"){ echo "checked"; } ?> >
                                                <i class="far fa-times-circle fa-fw"></i> &nbsp; No usar lector
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="usuario_tipo_codigo_up" value="Barras" <?php if($campos['usuario_tipo_codigo']=="Barras"){ echo "checked"; } ?> >
                                                <i class="fas fa-barcode fa-fw"></i> &nbsp; Código barras
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="usuario_tipo_codigo_up" value="SKU" <?php if($campos['usuario_tipo_codigo']=="SKU"){ echo "checked"; } ?> >
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
                            <select class="form-control" name="usuario_caja_up">
                            <?php
                                $datos_caja=$lc->datos_tabla("Normal","caja","*",0);
                                while($campos_caja=$datos_caja->fetch()){
                                    if($campos_caja['caja_id']==$campos['caja_id']){
                                        echo '<option value="'.$campos_caja['caja_id'].'" selected="" >Caja No.'.$campos_caja['caja_numero'].' - '.$campos_caja['caja_nombre'].' (Actual)</option>';
                                    }else{
                                        if($campos_caja['caja_estado']=="Habilitada"){
                                            echo '<option value="'.$campos_caja['caja_id'].'">Caja No.'.$campos_caja['caja_numero'].' - '.$campos_caja['caja_nombre'].'</option>';
                                        }
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
                            <input type="text" pattern="[a-zA-Z0-9]{4,25}" class="form-control" name="usuario_usuario_up" value="<?php echo $campos['usuario_usuario']; ?>" id="usuario_usuario" maxlength="25">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="usuario_email" class="bmd-label-floating">Email</label>
                            <input type="email" class="form-control" name="usuario_email_up" value="<?php echo $campos['usuario_email']; ?>" id="usuario_email" maxlength="50">
                        </div>
                    </div>
                    <div class="col-12">
                        <p class="text-center">Si desea actualizar su contraseña en el sistema debe de introducir una nueva contraseña y repetirla</p>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="usuario_clave_1" class="bmd-label-floating">Nueva contraseña</label>
                            <input type="password" class="form-control" name="usuario_clave_1_up" id="usuario_clave_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="usuario_clave_2" class="bmd-label-floating">Repetir nueva contraseña</label>
                            <input type="password" class="form-control" name="usuario_clave_2_up" id="usuario_clave_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
                        </div>
                    </div>
                    <?php if($_SESSION['cargo_svi']=="Administrador" && $campos['usuario_id']!=1){ ?>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="usuario_estado" class="bmd-label-floating">Estado de la cuenta <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <select class="form-control" name="usuario_estado_up" id="usuario_estado">
                                <?php
                                    $array_estado=["Activa","Deshabilitada"];
                                    echo $lc->generar_select($array_estado,$campos['usuario_estado']);
                                ?> 
                            </select>
                        </div>
                    </div>
                    <?php } ?>
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

                        $check="";
                        while($avatar=readdir($directorio_avatar)){
                            if(is_file("./vistas/assets/avatar/".$avatar)){
                                
                                if($campos['usuario_foto']==$avatar){
                                    $check="checked";
                                }

                                echo '
                                    <div class="col-6 col-md-4 col-lg-2">
                                        <div class="radio radio-avatar-form">
                                            <label>
                                                <input type="radio" name="usuario_foto_up" value="'.$avatar.'" '.$check.' >
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
        <br><br><br>
        <fieldset>
            <p class="text-center">Para poder actualizar los datos en el sistema debe de introducir su nombre de usuario y su contraseña actual</p>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="administrador_usuario" class="bmd-label-floating">Usuario <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="text" pattern="[a-zA-Z0-9]{4,25}" class="form-control" name="administrador_usuario" id="administrador_usuario" maxlength="25">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="administrador_clave" class="bmd-label-floating">Contraseña <?php echo CAMPO_OBLIGATORIO; ?></label>
                            <input type="password" class="form-control" name="administrador_clave" id="administrador_clave" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
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